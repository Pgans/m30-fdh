<!DOCTYPE html>  
<html>  
<head>  
    <meta charset="UTF-8">  
    <title>Document</title>
    <style>
    h2 {display: inline;}
    </style>
</head>
   
<body>
 
<form action="" method="post" enctype="multipart/form-data" name="myform1" id="myform1">
    <h2 for="myfile1">Select files : </h2><input type="file" name="excelFile" id="excelFile" /><br><br>
    <h2 for="fname">First name : </h2><input type="text" id="fname" name="fname"><br><br>
    <h2 for="lname">Last name : </h2><input type="text" id="lname" name="lname"><br><br>
  <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" />
</form>
 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>     
<script type="text/javascript">
$(function(){
       
       
    // เมื่อฟอร์มการเรียกใช้ evnet submit ข้อมูล        
    $("#excelFile").on("change",function(e){
        e.preventDefault(); // ปิดการใช้งาน submit ปกติ เพื่อใช้งานผ่าน ajax
           
        // เตรียมข้อมูล form สำหรับส่งด้วย  FormData Object
       var formData = new FormData($("#myform1")[0]);
   
        // ส่งค่าแบบ POST ไปยังไฟล์ read_excel.php รูปแบบ ajax แบบเต็ม
        $.ajax({
            url: 'read_excel.php',
            type: 'POST',
            data: formData,
            /*async: false,*/
            cache: false,
            contentType: false,
            processData: false
        }).done(function(data){
                console.log(data);  // ทดสอบแสดงค่า  ดูผ่านหน้า console
/*              การใช้งาน console log เพื่อ debug javascript ใน chrome firefox และ ie 
                http://www.ninenik.com/content.php?arti_id=692 via @ninenik         */
                $("#fname").val(data.A2);
                $("#lname").val(data.B2);
        });     
   
    });
       
       
});
</script>
</body>
</html>