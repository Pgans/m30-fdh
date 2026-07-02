<?php

use yii\helpers\Html;

?>

<div class="invoice-details">
    <h3>รายละเอียดค่ารักษาพยาบาล Visit ID: <?= Html::encode($visit_id) ?></h3>
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>วันที่บันทึก</th>
                <th>รายการ</th>
                <th>เลขที่ใบเสร็จ</th>
                <th>จำนวนเงิน</th>
                <th>รวมย่อย</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($invoices)): ?>
                <?php $total = 0; ?>
                <?php foreach ($invoices as $invoice): ?>
                    <tr>
                        <td><?= Html::encode($invoice['record_dt']) ?></td>
                        <td><?= Html::encode($invoice['item']) ?></td>
                        <td><?= Html::encode($invoice['invoice']) ?></td>
                        <td class="text-right"><?= number_format($invoice['amount'], 2) ?></td>
                        <td class="text-right"><?= number_format($invoice['subtotal'], 2) ?></td>
                    </tr>
                    <?php $total += $invoice['subtotal']; ?>
                <?php endforeach; ?>
                <tr class="info">
                    <td colspan="4" class="text-right"><strong>รวมทั้งสิ้น</strong></td>
                    <td class="text-right"><strong><?= number_format($total, 2) ?></strong></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">ไม่พบข้อมูลค่ารักษาพยาบาล</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="text-right">
        <?= Html::a('ส่งออก CSV', ['export-csv', 'visit_id' => $visit_id], [
            'class' => 'btn btn-warning',
            'target' => '_blank',
            'data-pjax' => '0',
        ]) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
    </div>
</div>