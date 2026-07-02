<?php
use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/favicon.ico" type="image/x-icon" />
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>

        <link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
        <style>
            body {
                font-family: 'Kanit', sans-serif;
            }

            h1 {
                font-family: 'Kanit', sans-serif;
            }

            h2 {
                font-family: 'Kanit', sans-serif;
            }

            h3 {
                font-family: 'Kanit', sans-serif;
            }

            h4 {
                font-family: 'Kanit', sans-serif;
            }

            h5 {
                font-family: 'Kanit', sans-serif;
            }

            div {
                font-family: 'Kanit', sans-serif;
            }

            /* a {
                color: #009587;
            } */

            h5.thick {
                font-weight: bold;
            }
	 #grad0 {
	  background-image: linear-gradient(to right, pink, cyan);
	}
	#grad1 {
	  background-image: linear-gradient(to right, indigo, cyan);
	}
	#grad001 {
	  background-image: linear-gradient(to right, teal, yellow);
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
<body class="login-page">

<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
