    /**
     * Export ข้อมูลรายเดือนเป็น CSV
     */
    public function actionExportMonth($month)
    {
        // ตรวจสอบ format ของ month
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            throw new \yii\web\BadRequestHttpException('รูปแบบเดือนไม่ถูกต้อง');
        }
        
        $data = $this->queryDataWithReason();
        
        // กรองข้อมูลเฉพาะเดือนที่เลือก
        $monthData = [];
        foreach ($data as $row) {
            $serviceDate = $row['regdate'];
            
            if (empty($serviceDate) || strtotime($serviceDate) === false) {
                continue;
            }
            
            $monthKey = date('Y-m', strtotime($serviceDate));
            
            if ($monthKey === $month) {
                $monthData[] = $row;
            }
        }
        
        // Export
        $this->exportToCsv($monthData, $month);
    }
    
    /**
     * Export ข้อมูลเป็น CSV พร้อม format และเติมเหตุผลอัตโนมัติ
     * 
     * @param array $data ข้อมูลที่จะ export
     * @param string $month (optional) เดือนสำหรับตั้งชื่อไฟล์ เช่น 2025-01
     */
    private function exportToCsv($data, $month = null)
    {
        // เหตุผลสำรองสำหรับรายการที่ไม่มีเหตุผล
        $defaultReasons = [
            'ให้บริการนอกพื้นที่ไม่สามารถขอ Authen ได้ทันในวันที่รับบริการ',
            'ระบบอินเตอร์เนตของหน่วยบริการมีปัญหา ทำให้ไม่สามารถขอ Authen ได้',
            'ปัญหาในหน่วยบริการเอง มีผู้รับบริการจำนวนมาก ทำให้ไม่สามารถขอ Authen ได้ทันเวลา'
        ];
        
        // ตั้งชื่อไฟล์
        if ($month) {
            $filename = 'c305_report_' . $month . '_' . date('Ymd_His') . '.csv';
        } else {
            $filename = 'c305_report_' . date('Ymd_His') . '.csv';
        }
        
        // Set headers สำหรับ download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // เปิด output stream
        $output = fopen('php://output', 'w');
        
        // เพิ่ม BOM สำหรับ UTF-8 เพื่อให้ Excel แสดงผลภาษาไทยได้ถูกต้อง
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // เขียน Header (ภาษาไทย)
        $headers = [
            'เลขอ้างอิงชื่อไฟล์',
            'รหัสอ้างอิงจากแฟ้ม SERVICE',
            'รหัสบัตรประชาชน',
            'HN',
            'วันที่เข้ารับบริการ',
            'ชื่อ-สกุล',
            'เหตุผล'
        ];
        fputcsv($output, $headers);
        
        // เขียนข้อมูล
        if (!empty($data)) {
            foreach ($data as $row) {
                // Format HN ให้ครบ 6 หลัก
                $hn = $row['hn'] ?? '';
                if (!empty($hn)) {
                    // แปลงเป็นตัวเลข แล้วเติม 0 ข้างหน้าให้ครบ 6 หลัก
                    $hn = str_pad(intval($hn), 6, '0', STR_PAD_LEFT);
                }
                
                // ตรวจสอบและเติมเหตุผล
                $reason = trim($row['reason'] ?? '');
                if (empty($reason)) {
                    // สุ่มเลือกเหตุผลจาก array
                    $randomIndex = array_rand($defaultReasons);
                    $reason = $defaultReasons[$randomIndex];
                }
                
                // Format วันที่ให้เป็น d/m/Y ถ้ามี
                $regdate = $row['regdate'] ?? '';
                if (!empty($regdate) && strtotime($regdate) !== false) {
                    $regdate = date('d/m/Y', strtotime($regdate));
                }
                
                $csvRow = [
                    $row['tran_id'] ?? '',
                    $row['trans_id2'] ?? '',
                    $row['cid'] ?? '',
                    $hn,
                    $regdate,
                    $row['fullname'] ?? '',
                    $reason
                ];
                fputcsv($output, $csvRow);
            }
        }
        
        fclose($output);
        exit();
    }
