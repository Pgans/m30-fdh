<?php
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'ANC-DENT';

$this->registerCss('
    @import url("https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;600;700&display=swap");

    body, .well { font-family: "Sarabun", sans-serif; }

    /* ─── WRAPPER ─── */
    .anc-wrapper {
        background: #f4f6fb;
        padding: 20px;
        border-radius: 16px;
        border: none;
        box-shadow: none;
    }
    .anc-subtitle {
        font-size: 11px;
        color: #9ca3af;
        margin-bottom: 12px;
        letter-spacing: 0.3px;
    }

    /* ─── BADGE ROW ─── */
    .badge-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
    }
    .stat-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 16px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        border: 1.5px solid transparent;
        text-decoration: none !important;
        transition: box-shadow .15s, transform .1s;
        white-space: nowrap;
    }
    .stat-chip:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
    .stat-chip.active { box-shadow: 0 0 0 3px rgba(0,0,0,.18); }

    .chip-all        { background:#6c48ff; color:#fff; border-color:#6c48ff; }
    .chip-sent       { background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
    .chip-wait       { background:#fffbeb; color:#b45309; border-color:#fde68a; }
    .chip-today      { background:#ecfdf5; color:#065f46; border-color:#a7f3d0; }
    .chip-money-ok   { background:#ecfdf5; color:#065f46; border-color:#6ee7b7; }
    .chip-money-no   { background:#fef2f2; color:#991b1b; border-color:#fecaca; }
    .chip-money-all  { background:#f3f4f6; color:#374151; border-color:#d1d5db; }

    /* ─── CONTROL ROW ─── */
    .ctrl-row {
        display: flex;
        gap: 14px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        position: relative;
        z-index: 100;       /* ✅ ลอยเหนือตาราง */
    }
    .ctrl-card {
        background: #fff;
        border-radius: 14px;
        padding: 16px 20px;
        border: 1px solid #e5e7eb;
        flex: 1;
        min-width: 180px;
        position: relative;
        z-index: 100;
    }
    .ctrl-card.accent-purple { border-left: 4px solid #6c48ff; }
    .ctrl-card.accent-teal   { border-left: 4px solid #0f9d8a; }
    .ctrl-card.accent-none   { border: 1px solid #e5e7eb; }

    .ctrl-label {
        font-size: 11px;
        font-weight: 700;
        color: #6c48ff;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 4px;
    }
    .ctrl-label.teal { color: #0f9d8a; }
    .ctrl-val {
        font-size: 24px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 10px;
        line-height: 1.1;
    }
    .pill-btn {
        padding: 5px 16px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .pill-purple { background: #6c48ff; color: #fff; }
    .pill-teal   { background: #0f9d8a; color: #fff; }

    .date-form-inner {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .date-label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        white-space: nowrap;
    }
    .date-form-inner .form-control {
        border-radius: 8px !important;
        border: 1px solid #d1d5db !important;
        font-size: 13px;
        width: 145px;
    }
    .btn-search {
        background: #6c48ff;
        color: #fff;
        border: none;
        border-radius: 999px;
        padding: 7px 22px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }
    .btn-search:hover { background: #5638e0; }

    /* ─── DATEPICKER ─── */
    .datepicker {
        z-index: 9999 !important;
    }

    /* ─── QUICK LINKS ─── */
    .quick-links {
        font-size: 13px;
        margin-bottom: 14px;
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        align-items: center;
    }
    .quick-links a { color: #6b7280; text-decoration: none; }
    .quick-links a:hover { text-decoration: underline; }
    .quick-links .ql-warn    { color: #d97706; font-weight: 600; }
    .quick-links .ql-success { color: #059669; font-weight: 700; }

    /* ─── TABLE CONTAINER ─── */
    .table-shell {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,.05);
        position: relative;
        z-index: 1;         /* ✅ ต่ำกว่า ctrl-row */
    }
    .table-scroll-wrap {
        height: 520px;
        overflow-y: auto;
        overflow-x: auto;
    }
    .table-scroll-wrap::-webkit-scrollbar { width: 6px; height: 6px; }
    .table-scroll-wrap::-webkit-scrollbar-track { background: #f9fafb; }
    .table-scroll-wrap::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

    /* ─── GRIDVIEW OVERRIDES ─── */
    .kv-grid-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        font-family: "Sarabun", sans-serif;
    }
    .kv-grid-table thead th {
        background: #1e1b4b !important;
        color: #e0e7ff !important;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .4px;
        padding: 11px 12px;
        border: none !important;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 2;         /* ✅ ลดจาก 10 → 2 */
    }

    .kv-grid-table tbody tr { border-bottom: 1px solid rgba(0,0,0,.04); }
    .kv-grid-table tbody tr:hover { filter: brightness(0.96); }
    .kv-grid-table tbody td {
        padding: 10px 13px;
        vertical-align: middle;
        border: none;
        white-space: nowrap;
        font-size: 14px;
        font-family: "Sarabun", sans-serif;
        color: #1f2937;
        line-height: 1.5;
    }
    .kv-grid-table tbody tr.row-wait { background: #fff1f2; }
    .kv-grid-table tbody tr.row-sent { background: #f0fdf4; }

    /* ─── STATUS BADGE ─── */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 18px 5px 10px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        font-family: "Sarabun", sans-serif;
        letter-spacing: 0.1px;
    }
    .status-wait {
        background: #ffe4e6;
        color: #be123c;
        border: 1px solid #fecdd3;
    }
    .status-wait .s-icon {
        width: 18px; height: 18px;
        border-radius: 50%;
        background: #fb7185;
        color: #fff;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 900; line-height: 1;
    }
    .status-sent {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .status-sent .s-icon {
        width: 18px; height: 18px;
        border-radius: 50%;
        background: #22c55e;
        color: #fff;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 900; line-height: 1;
    }

    /* ─── DIAG BADGE ─── */
    .diag-code {
        display: inline-block;
        padding: 2px 9px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
    }
    .diag-sent { background: #d1fae5; color: #065f46; }
    .diag-wait { background: #fee2e2; color: #991b1b; }

    /* ─── SERIAL BADGE ─── */
    .no-badge {
        display: inline-block;
        background: #e5e7eb;
        color: #374151;
        border-radius: 999px;
        padding: 1px 9px;
        font-size: 11px;
        font-weight: 700;
    }

    /* ─── FLOATING SEND BUTTON ─── */
    .float-send-btn {
        position: fixed;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        background: #22c55e;
        color: #fff;
        border: 4px solid #fff;
        box-shadow: 0 8px 24px rgba(34,197,94,.45);
        border-radius: 999px;
        padding: 12px 32px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        letter-spacing: .3px;
        transition: background .2s, transform .1s;
    }
    .float-send-btn:hover { background: #16a34a; transform: translateX(-50%) translateY(-2px); }
    .float-send-btn i { margin-right: 8px; }

    /* ─── EMPTY ROW ─── */
    .empty-row td {
        text-align: center;
        padding: 40px;
        color: #ef4444;
        font-weight: 700;
        font-size: 15px;
    }

    /* ─── LOADING ─── */
    #loading-spinner {
        position: fixed;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        z-index: 9999;
    }
');
?>

<div class="anc-wrapper">
    <div class="anc-subtitle">
        <i class="fa fa-filter"></i> เงื่อนไข: UCS-สิทธิ์บัตรทอง &nbsp;|&nbsp; รหัสโรค ('z340','z348')
    </div>

    <!-- ─── STAT CHIPS ─── -->
    <div class="badge-row">
        <a href="<?= Url::to(['index', 'date1' => $date1, 'date2' => $date2, 'status' => 'all']) ?>"
           class="stat-chip chip-all <?= $statusFilter == 'all' ? 'active' : '' ?>">
            <i class="fa fa-folder"></i> ทั้งหมด <strong>(<?= $totalCases ?>)</strong>
        </a>
        <a href="<?= Url::to(['index', 'date1' => $date1, 'date2' => $date2, 'status' => 'success']) ?>"
           class="stat-chip chip-sent <?= $statusFilter == 'success' ? 'active' : '' ?>">
            <i class="fa fa-check-circle"></i> ส่งแล้ว <strong>(<?= $sentCases ?> เคส)</strong>
        </a>
        <a href="<?= Url::to(['index', 'date1' => $date1, 'date2' => $date2, 'status' => 'waiting']) ?>"
           class="stat-chip chip-wait <?= $statusFilter == 'waiting' ? 'active' : '' ?>">
            <i class="fa fa-clock-o"></i> รอส่ง <strong>(<?= $waitCases ?> เคส)</strong>
        </a>
        <a href="<?= Url::to(['index', 'date1' => $date1, 'date2' => $date2, 'status' => 'today']) ?>"
   class="stat-chip chip-today <?= $statusFilter == 'today' ? 'active' : '' ?>">
    <i class="fa fa-calendar"></i>
    ส่งวันนี้ (<?= $amountToday ?> เคส)
</a>
        <span class="stat-chip chip-money-ok">
    <i class="fa fa-check"></i> 
    ยอดชดเชยแล้ว (<?= number_format($compensated, 2) ?>)
</span>

 <a>
<a href="<?= Url::to(['index', 'date1' => $date1, 'date2' => $date2, 'status' => 'not_compensated']) ?>"
   class="stat-chip chip-money-no <?= $statusFilter == 'not_compensated' ? 'active' : '' ?>">
    <i class="fa fa-times"></i>
    ยังไม่ชดเชย (<?= number_format($notCompensated, 2) ?>)
</a>

<span class="stat-chip chip-money-all">
    <i class="fa fa-calculator"></i> 
    ค่ารักษาทั้งหมด (<?= number_format($totalAmount, 2) ?>)
</span>
    </div>

    <!-- ─── CONTROL CARDS ─── -->
    <div class="ctrl-row">

        <!-- Card 1: D_UPDATE -->
        <div class="ctrl-card accent-purple">
            <div class="ctrl-label">ยืนยันส่งผ่านวันนี้ (D_UPDATE)</div>
            <div class="ctrl-val"><?= Html::encode($amountToday) ?> <small style="font-size:14px;color:#6b7280;">เคส</small></div>

            <?php
            Modal::begin([
                'id' => 'myModal',
                'header' => '<h4><i class="fa fa-file-text-o"></i> File List</h4>',
                'size' => Modal::SIZE_LARGE,
            ]);
            echo '<div id="modal-content" style="min-height:120px;display:flex;align-items:center;justify-content:center;">
                    <i class="fa fa-spinner fa-spin fa-2x text-muted"></i>
                  </div>';
            Modal::end();
            ?>
            <?= Html::a('<i class="fa fa-folder-open"></i> เปิดอ่านไฟล์', '#', [
                'class' => 'pill-btn pill-purple',
                'data-toggle' => 'modal',
                'data-target' => '#myModal',
                'data-url' => Url::to(['f16erext/list-files-partial']),
            ]) ?>
        </div>

        <!-- Card 2: TOKEN -->
        <div class="ctrl-card accent-teal">
            <div class="ctrl-label teal"><i class="fa fa-key"></i> STATUS TOKEN</div>
            <div class="ctrl-val" style="color:#059669;font-size:18px;">
                <i class="fa fa-circle" style="font-size:10px;vertical-align:2px;color:#22c55e;"></i> Status: OK
            </div>
            <a href="<?= Url::to(['f16ancdent/run-curl']) ?>" class="pill-btn pill-teal">
                <i class="fa fa-refresh"></i> Run Token
            </a>
        </div>

        <!-- Card 3: Date Search -->
        <div class="ctrl-card accent-none" style="flex:2;">
            <?php $form = ActiveForm::begin(['action' => ['f16ancdent/index'], 'method' => 'post']); ?>
            <?= Html::hiddenInput('status', $statusFilter) ?>
            <div class="date-form-inner">
                <span class="date-label">วันที่เริ่มต้น:</span>
                <?= yii\jui\DatePicker::widget([
                    'name' => 'date1',
                    'value' => $date1,
                    'language' => 'th',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => ['changeMonth' => true, 'changeYear' => true],
                ]); ?>
                <span class="date-label">ถึงวันที่:</span>
                <?= yii\jui\DatePicker::widget([
                    'name' => 'date2',
                    'value' => $date2,
                    'language' => 'th',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control'],
                    'clientOptions' => ['changeMonth' => true, 'changeYear' => true],
                ]); ?>
                <button type="submit" class="btn-search">
                    <i class="fa fa-search"></i> เรียกดู
                </button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <!-- ─── QUICK LINKS ─── -->
    <div class="quick-links">
        <a href="https://uat-fdh.inet.co.th/hospital/detail" target="_blank">FDH-UAT</a>
        <span style="color:#d1d5db">|</span>
        <a href="https://fdh.moph.go.th/hospital/" target="_blank">FDH-Production</a>
        <span style="color:#d1d5db">|</span>
        <a href="<?= Url::to(['fdhancdent/index']) ?>" target="_blank" class="ql-warn">
            Query หน้าต่างใหม่ <i class="fa fa-arrow-circle-right"></i>
        </a>
        <span style="color:#d1d5db">|</span>
        <?= Html::a('<i class="fa fa-file-excel-o"></i> Export Excel', ['f16ancdent/exports'], [
            'class' => 'ql-success',
            'style' => 'text-decoration:none;'
        ]) ?>
    </div>

    <!-- ─── TABLE ─── -->
    <div class="table-shell">
        <div id="loading-spinner">
            <div class="custom-spinner"></div>
        </div>

        <?= Html::beginForm(['f16ancdent/data'], 'post', ['name' => 'frmMain']); ?>

        <?php
        $allowedUsers = [6, 96, 289, 383];
        $currentUserId = Yii::$app->user->id ?? null;
        if (in_array($currentUserId, $allowedUsers)) :
        ?>
            <button type="submit" name="btnSubmit" id="btnSubmit" class="float-send-btn">
                <i class="fa fa-paper-plane"></i> ส่งข้อมูล ANC-DENT
            </button>
        <?php endif; ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}',
            'tableOptions' => ['class' => 'kv-grid-table'],
            'containerOptions' => ['class' => 'table-scroll-wrap'],
            'hover' => false,
            'bordered' => false,
            'striped' => false,
            'condensed' => true,
            'rowOptions' => function ($model) {
                $cls = !empty($model['messagecode']) ? 'row-sent' : 'row-wait';
                return ['class' => $cls];
            },
            'columns' => [
                // Checkbox
                [
                    'class' => 'kartik\grid\CheckboxColumn',
                    'name' => 'chkDel[]',
                    'checkboxOptions' => function ($model) {
                        return [
                            'value' => ($model['visit_id'] ?? '') . ($model['hn'] ?? ''),
                            'style' => 'width:15px;height:15px;accent-color:#6c48ff;',
                        ];
                    },
                    'header' => '<input type="checkbox" id="CheckAll" onClick="ClickCheckAll(this);" style="width:15px;height:15px;accent-color:#6c48ff;">',
                    'width' => '38px',
                ],
                // Row number
                [
                    'attribute' => 'No',
                    'label' => '#',
                    'width' => '44px',
                    'hAlign' => GridView::ALIGN_CENTER,
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<span class="no-badge">' . Html::encode($model['No'] ?? '') . '</span>';
                    },
                ],
                [
                    'attribute' => 'regdate',
                    'label' => 'วันที่',
                    'width' => '110px',
                    'value' => function ($model) {
                        return $model['regdate'] ?? '';
                    },
                ],
                [
                    'attribute' => 'visit_id',
                    'label' => 'เลขบริการ',
                    'width' => '100px',
                ],
                [
                    'attribute' => 'hn',
                    'label' => 'HN',
                    'width' => '85px',
                ],
                [
                    'attribute' => 'fullname',
                    'label' => 'ชื่อ-สกุล',
                ],
                [
                    'attribute' => 'age',
                    'label' => 'อายุ',
                    'width' => '50px',
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
                [
                    'attribute' => 'unit_name',
                    'label' => 'แผนก',
                ],
                [
                    'attribute' => 'Diagx',
                    'label' => 'โรคหลัก',
                ],
                
                [
                    'attribute' => 'oper',
                    'label' => 'หัตถการ',
                ],
                [
                    'attribute' => 'inscl',
                    'label' => 'สิทธิ์',
                    'width' => '65px',
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
                [
                    'attribute' => 'hospmain',
                    'label' => 'สถานหลัก',
                    'width' => '90px',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $val = $model['hospmain'] ?? '';
                        $color = ($val === '10953') ? '#166534' : '#be123c';
                        $bg    = ($val === '10953') ? '#dcfce7' : '#ffe4e6';
                        $border= ($val === '10953') ? '#bbf7d0' : '#fecdd3';
                        return '<span style="display:inline-block;padding:3px 10px;border-radius:6px;font-weight:600;font-size:13px;'
                             . 'background:' . $bg . ';color:' . $color . ';border:1px solid ' . $border . ';">'
                             . Html::encode($val)
                             . '</span>';
                    },
                ],
                [
				'attribute' => 'amount',
				'label'     => 'ค่ารักษา',
				'format'    => 'raw',
				'hAlign'    => GridView::ALIGN_RIGHT,
				'value'     => function ($model) {
					$val    = (float)($model['amount'] ?? 0);
					$bg     = ($val == 0) ? '#ffe4e6' : '#eff6ff';
					$color  = ($val == 0) ? '#be123c' : '#1d4ed8';
					$border = ($val == 0) ? '#fecdd3' : '#bfdbfe';
					return '<span style="display:inline-block;padding:3px 10px;border-radius:6px;
							font-weight:600;font-size:13px;background:' . $bg . ';
							color:' . $color . ';border:1px solid ' . $border . ';">'
						 . number_format($val, 2)
						 . '</span>';
				},
			],
			[
				'attribute' => 'ret_statement',
				'label'     => 'ชดเชย',
				'format'    => 'raw',
				'hAlign'    => GridView::ALIGN_RIGHT,
				'value'     => function ($model) {
					$val    = (float)($model['ret_statement'] ?? 0);
					$bg     = ($val == 0) ? '#ffe4e6' : '#eff6ff';
					$color  = ($val == 0) ? '#be123c' : '#1d4ed8';
					$border = ($val == 0) ? '#fecdd3' : '#bfdbfe';
					return '<span style="display:inline-block;padding:3px 10px;border-radius:6px;
							font-weight:600;font-size:13px;background:' . $bg . ';
							color:' . $color . ';border:1px solid ' . $border . ';">'
						 . number_format($val, 2)
						 . '</span>';
				},
			],
                [
					'attribute' => 'messagecode',
					'label'     => 'สถานะ',
					'format'    => 'raw',
					'value'     => function ($model) {
						if (!empty($model['messagecode'])) {
							$badge = '<span class="status-badge status-sent">'
								   . '<span class="s-icon">&#10003;</span>'
								   . Html::encode($model['messagecode'])
								   . '</span>';
						} else {
							$badge = '<span class="status-badge status-wait">'
								   . '<span class="s-icon">&#10005;</span>'
								   . 'รอส่ง'
								   . '</span>';
						}

						// ✅ แสดง d_update ใต้ badge
						$dUpdate = '';
						if (!empty($model['d_update'])) {
							$dUpdate = '<div style="font-size:11px;color:#6b7280;margin-top:4px;padding-left:2px;">'
									 . '<i class="fa fa-clock-o" style="margin-right:3px;"></i>'
									 . Html::encode($model['d_update'])
									 . '</div>';
						}

						return $badge . $dUpdate;
					},
				],
                /* ── claim_anc ───────────────────────────────────────── */
        ['attribute' => 'claim_code', 'header' => 'claim_anc', 'value' => function($m){ 
		$claim = $m['claim_code'] ?? '';
		$user  = $m['users'] ?? '';
		return $claim . '<br><small style="color:purple; font-size:14px;">' . $user . '</small>'; 
		}, 'format' => 'raw'],

				
				[
					'label' => 'เช็คสถานะ',
					'format' => 'raw',
					'contentOptions' => [
						'style' => 'white-space:nowrap;text-align:center;vertical-align:middle;width:160px;'
					],
					'value' => function ($model) {
						$visitIdPad = str_pad($model['visit_id'], 10, '0', STR_PAD_LEFT);
						$hnPad      = str_pad($model['hn'],        6, '0', STR_PAD_LEFT);
						$safeId     = 'r' . $visitIdPad;

						return
							'<button type="button"
								class="btn-check-status"
								data-value="' . $visitIdPad . $hnPad . '"
								data-hn="'    . $hnPad      . '"
								data-visit="' . $visitIdPad . '"
								style="background:linear-gradient(135deg,#e3f2fd,#bbdefb);
									   color:#1565c0;border:1px solid #90caf9;border-radius:20px;
									   padding:3px 10px;font-size:11px;font-weight:bold;
									   cursor:pointer;white-space:nowrap;">
								<i class="fa fa-search"></i> เช็ค
							</button>
							<div class="check-result"
								 id="result-' . $safeId . '"
								 style="margin-top:4px;font-size:10px;display:none;
										max-width:140px;word-wrap:break-word;">
							</div>';
					}
				],
				
                [
                    'attribute' => 'claimcode',
                    'label' => 'authen',
                    'width' => '90px',
                ],
            ],
           'emptyText' => '<div style="padding:40px;text-align:center;color:#ef4444;font-weight:700;font-size:15px;"><i class="fa fa-exclamation-circle fa-2x" style="display:block;margin-bottom:10px;"></i>ไม่พบข้อมูลตามเงื่อนไขและช่วงเวลาที่เลือก</div>',
            'emptyTextOptions' => ['class' => ''],
        ]); ?>   

        <?= Html::endForm(); ?>
    </div>
</div>

<?php $this->registerJs(
    "var _csrf    = '" . Yii::$app->request->csrfParam . "';" .
    "var _csrfVal = '" . Yii::$app->request->getCsrfToken() . "';" .
    "var _url     = '" . Url::to(['f16ancdent/check']) . "';",
\yii\web\View::POS_END); ?>

<?php $this->registerJs(<<<'JS'
console.log('=== FDH Script Loaded ===');

$(document).on('mouseenter', '.btn-check-status', function () {
    var val = String($(this).data('value'));
    if (val && val.length >= 16) {
        $(this).attr('title',
            'VisitID: ' + val.substring(0, 10) +
            '\nHN: '    + val.substring(10, 16)
        );
    }
});

$(document).on('click', '.btn-check-status', function () {
    var btn       = $(this);
    var val       = String(btn.data('value'));
    var hn        = btn.data('hn');
    var visitId   = btn.data('visit');
    var resultBox = $('#result-r' + visitId);   // ✅ แก้จาก hn → r+visitId
    var statusCell= $('#td-status-' + visitId);
    var row       = btn.closest('tr');           // ✅ หา row จาก closest แทน id

    btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
    resultBox.hide().removeClass('text-success text-danger text-info');

    var postData    = { chkDel: [val] };
    postData[_csrf] = _csrfVal;

    $.ajax({
        url     : _url,
        type    : 'POST',
        data    : postData,
        dataType: 'json',
        success : function (res) {

            var item = null;
            if (res.results && res.results[String(visitId)]) {
                item = res.results[String(visitId)];
            } else if (res.results) {
                $.each(res.results, function (k, v) {
                    if (String(v.hn) === String(hn)) { item = v; return false; }
                });
            }

            if (!item) {
                item = { success: false, status: 'error', message: res.message || 'ไม่พบข้อมูล' };
            }

            var msgText      = item.message || '-';
            var status       = String(item.status || '').toLowerCase();
            var approvedList = ['approved','paid','accepted','success','waited','claimed','processed','complete','completed','cut_off_batch'];
            var isApproved   = approvedList.indexOf(status) !== -1;
            var currentDate  = new Date().toISOString().replace('T',' ').substring(0, 16);

            // ── ปุ่ม + result box ──
            if (isApproved) {
                btn.html('<i class="fa fa-check-circle" style="color:#2e7d32"></i> ผ่าน');
                resultBox
                    .removeClass('text-danger text-info').addClass('text-success')
                    .html('<div style="margin-top:4px;padding:4px 8px;border-radius:8px;background:#dcfce7;border:1px solid #86efac;color:#15803d;font-size:10px;font-weight:700;"><i class="fa fa-check-circle"></i> ' + msgText + '</div>')
                    .show();
                row.removeClass('row-wait').addClass('row-pass');

            } else if (item.success) {
                btn.html('<i class="fa fa-paper-plane" style="color:#1565c0"></i> ส่งแล้ว');
                resultBox
                    .removeClass('text-danger text-success').addClass('text-info')
                    .html('<div style="margin-top:4px;padding:4px 8px;border-radius:8px;background:#dbeafe;border:1px solid #93c5fd;color:#1d4ed8;font-size:10px;font-weight:700;"><i class="fa fa-paper-plane"></i> ' + msgText + '</div>')
                    .show();
                row.removeClass('row-wait').addClass('row-pass');

            } else {
                btn.html('<i class="fa fa-times-circle" style="color:#c62828"></i> ไม่ผ่าน');
                resultBox
                    .removeClass('text-success text-info').addClass('text-danger')
                    .html('<div style="margin-top:4px;padding:4px 8px;border-radius:8px;background:#fee2e2;border:1px solid #fca5a5;color:#b91c1c;font-size:10px;font-weight:700;"><i class="fa fa-times-circle"></i> ' + msgText + '</div>')
                    .show();
                row.removeClass('row-pass').addClass('row-wait');
            }

            btn.prop('disabled', false);

            // ── td-status ──
            if (statusCell.length) {
                var icon  = isApproved   ? 'fa-check-circle'
                          : item.success ? 'fa-paper-plane'
                          :               'fa-times-circle';
                var color = isApproved   ? '#16a34a'
                          : item.success ? '#2563eb'
                          :               '#dc2626';
                statusCell.html(
                    '<div style="color:' + color + ';font-weight:600;">' +
                    '<i class="fa ' + icon + '"></i> ' + msgText + '</div>' +
                    '<div style="font-size:11px;color:#6b7280;margin-top:2px;">' +
                    '<i class="fa fa-clock-o"></i> ' + currentDate + '</div>'
                );
            }

            // ── กระพริบแถว ──
            row.css({ background: '#fef08a', transition: 'background 0.3s' });
            setTimeout(function () { row.css('background', ''); }, 1000);
        },
        error: function (xhr) {
            btn.html('<i class="fa fa-times" style="color:#c62828"></i> Error').prop('disabled', false);
            resultBox
                .removeClass('text-success text-info').addClass('text-danger')
                .html('<div style="padding:4px 8px;border-radius:8px;background:#fee2e2;color:#b91c1c;font-size:10px;">AJAX ERROR: ' + xhr.status + '</div>')
                .show();
        }
    });
});
JS
, \yii\web\View::POS_END); ?>

<script>
    function ClickCheckAll(vol) {
        var checkboxes = document.querySelectorAll('input[name="chkDel[]"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = vol.checked;
        });
    }

    document.querySelector('form[name="frmMain"]').addEventListener('submit', function(event) {
        var checkedRows = document.querySelectorAll('input[name="chkDel[]"]:checked');
        var count = checkedRows.length;

        if (count > 0) {
            event.preventDefault();
            var currentIndex = 0;

            function processRow() {
                if (currentIndex < count) {
                    var row = checkedRows[currentIndex].closest('tr');
                    var originalBackgroundColor = row.style.backgroundColor;
                    row.style.backgroundColor = '#F8B6F6';

                    row.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });

                    setTimeout(function() {
                        row.style.backgroundColor = originalBackgroundColor;
                        currentIndex++;
                        processRow();
                    }, 400);
                } else {
                    document.frmMain.submit();
                }
            }
            processRow();
        } else {
            alert('กรุณาเลือกรายการที่ต้องการส่งข้อมูลอย่างน้อย 1 รายการ');
            event.preventDefault();
        }
    });

    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.data('url');
        var modal = $(this);
        $.ajax({
            url: url,
            success: function(data) {
                modal.find('#modal-content').html(data);
            }
        });
    });
</script>