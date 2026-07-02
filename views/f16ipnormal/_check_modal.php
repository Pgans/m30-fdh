<?php
// ====================================================
// _check_modal.php — Universal Template
// วิธีใช้: include __DIR__ . '/_check_modal.php';
// ปุ่ม:   onclick="openCheckModal('visit_id','hn','fullname')"
// ✅ Copy วางที่โฟลเดอร์ view ไหนก็ทำงานได้เลย
// ====================================================
$_checkUrl = \yii\helpers\Url::to(['check-data']);
?>

<style>
#mdCheckModal .modal-dialog  { max-width:80vw; width:80vw; margin:20px auto; }
#mdCheckModal .modal-content { border-radius:10px; overflow:hidden; border:none; }
#mdCheckModal .modal-header  { background:linear-gradient(135deg,#1D9E75 0%,#0F6E56 100%); border-bottom:none; padding:14px 18px; }
#mdCheckModal .modal-footer  { background:#f9f9f9; border-top:1px solid #e5e5e5; padding:10px 18px; }
#mdBody { max-height:75vh; overflow-y:auto; padding:16px 18px; }
.md-sum-row  { display:flex; gap:10px; margin-bottom:16px; }
.md-sum-card { flex:1; border-radius:10px; padding:14px 16px; display:flex; align-items:center; gap:12px; }
.md-sc-ok    { background:#E1F5EE; } .md-sc-empty { background:#FCEBEB; } .md-sc-na { background:#F1EFE8; }
.md-sc-icon  { width:36px; height:36px; border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:17px; font-weight:700; flex-shrink:0; }
.md-sc-ok    .md-sc-icon { background:#9FE1CB; color:#085041; }
.md-sc-empty .md-sc-icon { background:#F7C1C1; color:#791F1F; }
.md-sc-na    .md-sc-icon { background:#D3D1C7; color:#444441; }
.md-sc-num { font-size:26px; font-weight:700; line-height:1; }
.md-sc-ok    .md-sc-num { color:#0F6E56; } .md-sc-empty .md-sc-num { color:#A32D2D; } .md-sc-na .md-sc-num { color:#5F5E5A; }
.md-sc-lbl { font-size:11px; font-weight:500; margin-top:3px; }
.md-sc-ok    .md-sc-lbl { color:#1D9E75; } .md-sc-empty .md-sc-lbl { color:#E24B4A; } .md-sc-na .md-sc-lbl { color:#888780; }
.md-frow  { border:1px solid #e4e4e4; border-radius:8px; margin-bottom:6px; overflow:hidden; transition:box-shadow .15s; }
.md-frow:hover { box-shadow:0 2px 6px rgba(0,0,0,.07); }
.md-fhdr  { display:flex; align-items:center; gap:10px; padding:10px 14px; user-select:none; transition:background .1s; }
.md-fhdr.cl { cursor:pointer; } .md-fhdr.cl:hover { background:rgba(0,0,0,.02); }
.md-fh-ok    { border-left:4px solid #1D9E75; } .md-fh-empty { border-left:4px solid #E24B4A; }
.md-fh-na    { border-left:4px solid #B4B2A9; } .md-fh-warn  { border-left:4px solid #EF9F27; }
.md-fname { font-size:13px; font-weight:600; min-width:60px; color:#333; }
.md-req   { color:#E24B4A; font-size:12px; }
.md-pill  { font-size:11px; font-weight:500; padding:3px 11px; border-radius:20px; }
.md-pill-ok    { background:#E1F5EE; color:#0F6E56; } .md-pill-empty { background:#FCEBEB; color:#A32D2D; }
.md-pill-na    { background:#F1EFE8; color:#5F5E5A; } .md-pill-warn  { background:#FAEEDA; color:#633806; }
.md-chev  { margin-left:auto; font-size:11px; color:#bbb; transition:transform .2s; }
.md-frow.open .md-chev { transform:rotate(180deg); }
.md-fbody { display:none; border-top:1px solid #eee; }
.md-frow.open .md-fbody { display:block; }
.md-tbl   { width:100%; border-collapse:collapse; font-size:11px; }
.md-tbl th { background:#E1F5EE; padding:5px 10px; text-align:left; border-bottom:1px solid #e5e5e5; color:#0F6E56; font-size:10px; font-weight:600; white-space:nowrap; text-transform:uppercase; letter-spacing:.03em; }
.md-tbl td { padding:5px 10px; border-bottom:1px solid #f0f0f0; color:#333; white-space:nowrap; }
.md-tbl tr:last-child td { border-bottom:none; }
.md-tbl tbody tr:hover td { background:#f5fff8; }
.md-inv-hdr td { background:#E1F5EE !important; color:#0F6E56; font-weight:600; padding:7px 12px !important; }
.md-prog-bar  { height:5px; background:rgba(255,255,255,.3); border-radius:3px; overflow:hidden; margin-bottom:14px; }
.md-prog-fill { height:100%; background:#fff; border-radius:3px; transition:width .25s; width:0; }
.md-err-box   { background:#FCEBEB; border:1px solid #F7C1C1; border-radius:8px; padding:12px 14px; color:#791F1F; font-size:13px; }
.md-alert     { border-radius:8px; padding:10px 14px; font-size:13px; font-weight:500; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
.md-alert-ok  { background:#E1F5EE; color:#0F6E56; border:1px solid #9FE1CB; }
.md-alert-err { background:#FCEBEB; color:#A32D2D; border:1px solid #F7C1C1; }
</style>

<div class="modal fade" id="mdCheckModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <div style="display:flex;align-items:center;gap:11px;">
          <div style="width:40px;height:40px;border-radius:10px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fas fa-clipboard-check" style="color:#fff;font-size:18px;"></i>
          </div>
          <div>
            <div style="font-size:15px;font-weight:600;color:#fff;">ตรวจสอบข้อมูลก่อนส่ง</div>
            <div id="mdInfo" style="font-size:11px;color:rgba(255,255,255,.8);margin-top:2px;"></div>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal"
                style="font-size:22px;color:#fff;opacity:.8;margin-left:auto;">&times;</button>
      </div>

      <div id="mdBody">
        <div id="mdProgress" style="display:none;margin-bottom:6px;">
          <div class="md-prog-bar"><div class="md-prog-fill" id="mdFill"></div></div>
          <div style="font-size:11px;color:#999;text-align:center;margin-top:6px;">
            <i class="fas fa-spinner fa-spin"></i>&nbsp;กำลังตรวจสอบข้อมูล...
          </div>
        </div>
        <div id="mdAlert" style="display:none;"></div>
        <div id="mdSummary" style="display:none;margin-bottom:14px;">
          <div class="md-sum-row">
            <div class="md-sum-card md-sc-ok">
              <div class="md-sc-icon">&#10004;</div>
              <div><div class="md-sc-num" id="mdOk">0</div><div class="md-sc-lbl">มีข้อมูล</div></div>
            </div>
            <div class="md-sum-card md-sc-empty">
              <div class="md-sc-icon">&#10008;</div>
              <div><div class="md-sc-num" id="mdEmpty">0</div><div class="md-sc-lbl">ไม่มีข้อมูล</div></div>
            </div>
            <div class="md-sum-card md-sc-na">
              <div class="md-sc-icon">&mdash;</div>
              <div><div class="md-sc-num" id="mdNa">0</div><div class="md-sc-lbl">ไม่บังคับ</div></div>
            </div>
          </div>
        </div>
        <div id="mdGrid"></div>
      </div>

      <div class="modal-footer">
        <small style="font-size:11px;color:#999;">
          <span style="color:#E24B4A;font-weight:700;">*</span> = แฟ้มบังคับ
          &nbsp;&nbsp;<i class="fas fa-hand-pointer" style="font-size:10px;"></i> คลิกแถบเพื่อดูข้อมูล
        </small>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"
                style="border-radius:7px;padding:6px 18px;">
          <i class="fas fa-times"></i> ปิด
        </button>
      </div>

    </div>
  </div>
</div>

<script>
var _mdUrl = '<?= $_checkUrl ?>';

// ====================================================
// openCheckModal — เรียกจากปุ่มในตาราง
// ====================================================
function openCheckModal(visit, hn, name) {
    $('#mdInfo').html('<b>HN:</b> ' + hn + '&nbsp;|&nbsp;<b>Visit:</b> ' + visit + '&nbsp;|&nbsp;' + name);
    $('#mdGrid').html('');
    $('#mdAlert').hide().html('');
    $('#mdSummary').hide();
    $('#mdProgress').show();
    $('#mdFill').css('width', '0%');
    $('#mdCheckModal').modal('show');

    var pct = 0;
    var t = setInterval(function () {
        pct += 7;
        if (pct > 88) { clearInterval(t); pct = 88; }
        $('#mdFill').css('width', pct + '%');
    }, 70);

    $.getJSON(_mdUrl, { visit: visit, hn: hn })
        .done(function (res) {
            clearInterval(t);
            $('#mdFill').css('width', '100%');
            setTimeout(function () { $('#mdProgress').hide(); }, 300);
            _mdRender(res);
        })
        .fail(function (x) {
            clearInterval(t);
            $('#mdProgress').hide();
            $('#mdGrid').html(
                '<div class="md-err-box">' +
                '<i class="fas fa-exclamation-triangle"></i>&nbsp;' +
                'เกิดข้อผิดพลาด HTTP <b>' + x.status + '</b>' +
                '</div>'
            );
        });
}

// ====================================================
// _mdRender — วาดรายการแฟ้ม
// ====================================================
function _mdRender(res) {
    if (!res.success) {
        $('#mdGrid').html(
            '<div class="md-err-box">' +
            '<i class="fas fa-exclamation-triangle"></i>&nbsp;' +
            '<b>[Error]</b> ' + res.message +
            (res.file ? '<br><small>' + res.file + ' line ' + res.line + '</small>' : '') +
            '</div>'
        );
        return;
    }

    var ok = 0, empty = 0, na = 0, html = '';

    $.each(res.data, function (_, item) {
        var hc, pc, icon, label;
        if      (item.status === 'ok')        { hc='md-fh-ok';   pc='md-pill-ok';   icon='&#10004;'; label='มี '+item.count+' record'; ok++; }
        else if (item.status === 'empty')     { hc='md-fh-empty';pc='md-pill-empty';icon='&#10008;'; label='ไม่มีข้อมูล!'; empty++; }
        else if (item.status === 'error')     { hc='md-fh-warn'; pc='md-pill-warn'; icon='&#9888;';  label='Query Error'; empty++; }
        else if (item.status === 'no_config') { hc='md-fh-warn'; pc='md-pill-warn'; icon='&#9881;';  label='ไม่มี config'; empty++; }
        else                                  { hc='md-fh-na';   pc='md-pill-na';   icon='&mdash;'; label='ไม่บังคับ'; na++; }

        var req = item.required ? '<span class="md-req"> *</span>' : '';
        var msg = item.message  ? '<span style="font-size:10px;color:#aaa;margin-left:6px;">(' + item.message + ')</span>' : '';

        // ADP — ถ้า Controller ส่ง rows_invoice มาด้วยก็แสดงใบเสร็จ
        var tbl = (item.table === 'ADP' && item.rows_invoice && item.rows_invoice.length > 0)
            ? _mdBuildAdp(item.rows, item.rows_invoice)
            : _mdBuildTbl(item.rows);
        var has = (tbl !== '');

        html +=
            '<div class="md-frow' + (item.status === 'empty' ? ' open' : '') + '">' +
            '<div class="md-fhdr ' + hc + (has ? ' cl' : '') + '"' +
            (has ? ' onclick="mdToggle(this)"' : '') + '>' +
            '<span class="md-fname">' + item.table + req + '</span>' +
            '<span class="md-pill ' + pc + '">' + icon + '&nbsp;' + label + '</span>' +
            msg +
            (has ? '<span class="md-chev">&#9660;</span>' : '') +
            '</div>' +
            (has ? '<div class="md-fbody"><div style="overflow-x:auto;">' + tbl + '</div></div>' : '') +
            '</div>';
    });

    $('#mdGrid').html(html);
    $('#mdOk').text(ok);
    $('#mdEmpty').text(empty);
    $('#mdNa').text(na);
    $('#mdSummary').fadeIn(200);

    if (res.hasError) {
        $('#mdAlert')
            .html('<i class="fas fa-times-circle"></i>&nbsp;ข้อมูลไม่ครบ — กรุณาตรวจสอบแฟ้มสีแดงก่อนส่ง')
            .removeClass('md-alert-ok').addClass('md-alert md-alert-err').show();
    } else {
        $('#mdAlert')
            .html('<i class="fas fa-check-circle"></i>&nbsp;ข้อมูลครบถ้วน — พร้อมส่งข้อมูล')
            .removeClass('md-alert-err').addClass('md-alert md-alert-ok').show();
    }
}

// ====================================================
// _mdBuildAdp — ADP + visit_invoice (ใบเสร็จ)
// ✅ ทำงานอัตโนมัติถ้า Controller ส่ง rows_invoice มา
// ====================================================
function _mdBuildAdp(rows, invRows) {
    var invHtml = '', invTotal = 0, adpHtml = '', adpTotal = 0;

    // ส่วนที่ 1: visit_invoice (มี header หมวด)
    if (invRows && invRows.length > 0) {
        invHtml =
            '<table class="md-tbl" style="width:100%;">' +
            '<thead><tr>' +
            '<th style="width:52%">รายการ</th>' +
            '<th style="text-align:center;width:8%">จำนวน</th>' +
            '<th style="text-align:right;width:12%">ราคา/หน่วย</th>' +
            '<th style="text-align:right;width:14%">จำนวนเงินเบิกได้</th>' +
            '<th style="text-align:right;width:14%">จำนวนเงินสุทธิ</th>' +
            '</tr></thead><tbody>';

        invRows.forEach(function (r) {
            var itm = r['item'] || '', inv = r['invoice'] || '';
            var amt = parseFloat(r['amount'] || 0);
            var sub = parseFloat(r['subtotal'] || 0);
            var isHdr = (sub === 0 && (inv === '' || parseInt(inv) === 0));
            invTotal += sub;

            if (isHdr) {
                invHtml += '<tr class="md-inv-hdr"><td colspan="5">' + itm + '</td></tr>';
            } else {
                var qty = parseInt(inv) || '';
                var up  = (qty > 0 && sub > 0) ? (sub / qty) : amt;
                invHtml +=
                    '<tr>' +
                    '<td style="padding-left:24px;">' + itm + '</td>' +
                    '<td style="text-align:center;">' + qty + '</td>' +
                    '<td style="text-align:right;">' + (up > 0 ? Number(up.toFixed(2)).toLocaleString() : '') + '</td>' +
                    '<td style="text-align:right;">' + (sub > 0 ? Number(sub).toLocaleString() : '') + '</td>' +
                    '<td style="text-align:right;font-weight:500;color:#0F6E56;">' + (sub > 0 ? Number(sub).toLocaleString() : '') + '</td>' +
                    '</tr>';
            }
        });

        invHtml +=
            '<tr style="background:#E1F5EE;">' +
            '<td colspan="3" style="text-align:right;font-weight:600;padding:7px 12px;color:#0F6E56;">รวมทั้งหมด</td>' +
            '<td style="text-align:right;font-weight:700;color:#0F6E56;font-size:13px;">' + Number(invTotal).toLocaleString() + '</td>' +
            '<td style="text-align:right;font-weight:700;color:#0F6E56;font-size:13px;">' + Number(invTotal).toLocaleString() + '</td>' +
            '</tr></tbody></table>';
    }

    // ส่วนที่ 2: ADP rows (ไม่มี header หมวด)
    if (rows && rows.length > 0) {
        adpHtml =
            '<div style="margin-top:14px;padding-top:10px;border-top:1px dashed #c8e6d8;">' +
            '<div style="font-size:11px;font-weight:600;color:#888;margin-bottom:6px;">' +
            '<i class="fas fa-file-alt"></i>&nbsp;ข้อมูล ADP' +
            '</div>' +
            '<table class="md-tbl" style="width:100%;">' +
            '<thead><tr>' +
            '<th style="width:40%">CODE</th>' +
            '<th style="text-align:center;width:8%">QTY</th>' +
            '<th style="text-align:right;width:12%">RATE</th>' +
            '<th style="text-align:right;width:12%">TOTCOPAY</th>' +
            '<th style="width:10%">CAGCODE</th>' +
            '<th style="width:18%">DATEOPD</th>' +
            '</tr></thead><tbody>';

        rows.forEach(function (r) {
            var code = r['CODE'] || r['code'] || '-';
            var qty  = r['QTY']  || r['qty']  || 1;
            var rate = r['RATE'] || r['rate'] || 0;
            var tot  = r['TOTCOPAY'] || r['totcopay'] || r['TOTAL'] || r['total'] || (qty * rate);
            var cag  = r['CAGCODE'] || r['cagcode'] || '';
            var dt   = r['DATEOPD'] || r['dateopd'] || '';
            adpTotal += parseFloat(tot) || 0;

            adpHtml +=
                '<tr>' +
                '<td style="padding-left:12px;font-family:monospace;font-size:11px;">[' + code + ']</td>' +
                '<td style="text-align:center;">' + qty + '</td>' +
                '<td style="text-align:right;">' + Number(rate).toLocaleString() + '</td>' +
                '<td style="text-align:right;color:#0F6E56;font-weight:500;">' + Number(tot).toLocaleString() + '</td>' +
                '<td style="color:#888;font-size:10px;">' + cag + '</td>' +
                '<td style="color:#888;font-size:10px;">' + dt + '</td>' +
                '</tr>';
        });

        adpHtml += '</tbody></table></div>';
    }

    // ส่วนที่ 3: เปรียบเทียบยอด
    var cmp = '';
    if (rows && rows.length > 0 && invRows && invRows.length > 0) {
        var match = (Math.round(adpTotal) === Math.round(invTotal));
        cmp =
            '<div style="margin-top:10px;padding:9px 14px;border-radius:8px;font-size:12px;font-weight:500;' +
            'background:' + (match ? '#E1F5EE' : '#FCEBEB') + ';' +
            'border:1px solid ' + (match ? '#9FE1CB' : '#F7C1C1') + ';' +
            'color:' + (match ? '#0F6E56' : '#A32D2D') + ';">' +
            '<i class="fas fa-' + (match ? 'check-circle' : 'exclamation-triangle') + '"></i>&nbsp;' +
            'ยอด visit_invoice: <b>' + Number(invTotal).toLocaleString() + '</b>' +
            '&nbsp;&nbsp;|&nbsp;&nbsp;' +
            'ยอด ADP: <b>' + Number(adpTotal).toLocaleString() + '</b>' +
            (match ? '&nbsp;&nbsp;— ยอดตรงกัน &#10004;' : '&nbsp;&nbsp;— ยอดไม่ตรงกัน กรุณาตรวจสอบ') +
            '</div>';
    }

    return (!invHtml && !adpHtml) ? '' : '<div style="padding:12px;">' + invHtml + adpHtml + cmp + '</div>';
}

// ====================================================
// _mdBuildTbl — ตารางทั่วไป
// ====================================================
function _mdBuildTbl(rows) {
    if (!rows || rows.length === 0) return '';
    var cols = Object.keys(rows[0]);
    var h = '<table class="md-tbl"><thead><tr>';
    cols.forEach(function (c) { h += '<th>' + c + '</th>'; });
    h += '</tr></thead><tbody>';
    rows.forEach(function (row) {
        h += '<tr>';
        cols.forEach(function (c) {
            var v = (row[c] !== null && row[c] !== undefined)
                ? row[c] : '<span style="color:#ccc;font-style:italic;">null</span>';
            h += '<td>' + v + '</td>';
        });
        h += '</tr>';
    });
    return h + '</tbody></table>';
}

// ====================================================
// mdToggle — เปิด/ปิดตาราง
// ====================================================
function mdToggle(hdr) {
    var r = hdr.closest('.md-frow');
    if (r) r.classList.toggle('open');
}
</script>
