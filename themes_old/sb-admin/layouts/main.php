<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use app\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <meta name="description" content="">
    <meta name="author" content="">

    <title>รพ.ม่วงสามสิบ</title>

    <!-- Custom fonts for this template-->
    <link href="myassets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="myassets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="myassets/vendor/jquery/jquery.min.js"></script>
    <script src="myassets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="myassets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="myassets/js/sb-admin-2.min.js"></script>

    <?php $this->head() ?>
    <style>
           
	 #grad0 {
	  background-image: linear-gradient(to right, pink, cyan);
	}
	#grad1 {
	  background-image: linear-gradient(to right, indigo, cyan);
	}
    #grad8 {
	  background-image: linear-gradient(to right, violet, cyan);
	}
    #grad81 {
	  background-image: linear-gradient(to right, violet, yellow);
	}
	#grad001 {
	  background-image: linear-gradient(to right, teal, yellow);
	}
    #grad002 {
	  background-image: linear-gradient(to right, orange, yellow);
	}
    #grad003 {
	  background-image: linear-gradient(to right, brown, yellow);
	}
    #grad3 {
	  background-image: linear-gradient(to right, teal, cyan);
	}
    #grad31 {
	  background-image: linear-gradient(to right, green, cyan);
	}
	#grad4 {
	  background-image: linear-gradient(to right, red,orange,yellow,green,blue,indigo,violet);
	}
	#grad2 {
	  background-image: linear-gradient(to right, cyan, yellow);
	}
	#grad5 {
	  background-image: linear-gradient(180deg, red, yellow);
	}
	#grad6 {
	  background-image: linear-gradient(180deg, violet, cyan);
	}
	#grad7 {
	  background-image: linear-gradient(180deg, blue, cyan);
	}
	#grad01 {
	  background-image: linear-gradient(to right, green , cyan);
	}
	#grad {
	  background: red; /* For browsers that do not support gradients */
	  background: -webkit-linear-gradient(left,rgba(255,0,0,0),rgba(255,0,0,1)); /*Safari 5.1-6*/
	  background: -o-linear-gradient(right,rgba(255,0,0,0),rgba(255,0,0,1)); /*Opera 11.1-12*/
	  background: -moz-linear-gradient(right,rgba(255,0,0,0),rgba(255,0,0,1)); /*Fx 3.6-15*/
	  background: linear-gradient(to right, rgba(255,0,0,0), rgba(255,0,0,1)); /*Standard*/
	}
	#grad11 {
		height: 55px;
		background: -webkit-linear-gradient(left, red, orange, yellow, green, blue, indigo, violet); /* For Safari 5.1 to 6.0 */
		background: -o-linear-gradient(left, red, orange, yellow, green, blue, indigo, violet); /* For Opera 11.1 to 12.0 */
		background: -moz-linear-gradient(left, red, orange, yellow, green, blue, indigo, violet); /* For Fx 3.6 to 15 */
		background: linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet); /* Standard syntax (must be last) */
	}
    .table-hover tbody tr:hover{
    background-color: #f7c0ba;
    }
	 .table-hover1 tbody tr:hover{
    background-color: #CCE9FB;
    }
	 .table-hover2 tbody tr:hover{
    background-color: #B3F7CE;
    }

</style>
</head>

<body id="page-top">
    <?php $this->beginBody() ?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        require __DIR__ . "/_sidebar.php";
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <?php
            require __DIR__ . "/_nav_head.php";
            ?>

            <?php
            require __DIR__ . "/_footer.php";
            ?>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
