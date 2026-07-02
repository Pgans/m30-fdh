

<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <title>Document</title>  
</head>  
<body>  
 
    
<div id="pdfplace">
ไม่ได้ติดตั้งโปรแกรม Adobe Reader หรือบราวเซอร์ไม่รองรับการแสดงผล PDF 
<a href="../ekgftp/2.pdf">คลิกที่นี้เพื่อดาวน์โหลดไฟล์ PDF</a>
</div>
 
<script type="text/javascript" src="js/pdfobject.js"></script>
 <script type="text/javascript">
  window.onload = function (){
    var myPDF = new PDFObject({ 
        url: "../ekgftp/2.pdf",
        id: "myPDF",
        width: "650px",
        height: "700px",
        pdfOpenParams: {
            navpanes: 1,
            statusbar: 0,
            view: "FitH",
            pagemode: "thumbs"
        }
        }).embed('pdfplace');
  };
</script>
<div>
<object data="mindpp_file.pdf" type="application/pdf" width="600" height="400">แสดงไฟล์ : <a href="../ekgftp/2.pdf">test.pdf</a></object>
</div>
</body>
</html>