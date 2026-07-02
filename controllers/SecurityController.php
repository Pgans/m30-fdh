<?php
/**
 * controllers/SecurityController.php
 * สำหรับ Yii2 Basic — extends dektrium SecurityController
 * วางไฟล์ที่: your-app/controllers/SecurityController.php
 */

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use app\models\ProviderLoginForm;
use dektrium\user\controllers\SecurityController as BaseSecurityController;

class SecurityController extends BaseSecurityController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // เพิ่ม verb rule สำหรับ provider-login
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'provider-login' => ['post'],
                'login'          => ['get', 'post'],
                'logout'         => ['post'],
            ],
        ];

        return $behaviors;
    }

    /**
     * POST /index.php?r=user/security/provider-login
     */
    public function actionProviderLogin()
    {
        // ถ้า login อยู่แล้ว redirect ไป home
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ProviderLoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', 'เข้าสู่ระบบสำเร็จ');
            return $this->goBack();
        }

        // กลับหน้า login พร้อม error flash
        $errors = $model->getFirstErrors();
        $errorMsg = !empty($errors)
            ? implode(' | ', array_values($errors))
            : 'เข้าสู่ระบบไม่สำเร็จ กรุณาลองใหม่';

        Yii::$app->session->setFlash('danger', $errorMsg);

        return $this->redirect(['/user/security/login']);
    }
}
