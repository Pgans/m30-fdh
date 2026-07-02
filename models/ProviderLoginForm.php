<?php
/**
 * models/ProviderLoginForm.php
 *
 * Model สำหรับ Login ด้วย Provider ID (เลขบัตรประชาชน + PIN)
 */

namespace app\models;

use Yii;
use yii\base\Model;

class ProviderLoginForm extends Model
{
    public $citizen_id;   // เลขบัตรประชาชน 13 หลัก
    public $pin;          // PIN 6 หลัก
    public $rememberMe = false;

    private $_user;

    public function rules()
    {
        return [
            [['citizen_id', 'pin'], 'required'],
            ['citizen_id', 'string', 'length' => 13],
            ['citizen_id', 'match', 'pattern' => '/^\d{13}$/', 'message' => 'เลขบัตรประชาชนต้องเป็นตัวเลข 13 หลัก'],
            ['citizen_id', 'validateCheckDigit'],   // ตรวจ check digit บัตรประชาชน
            ['pin', 'string', 'length' => 6],
            ['pin', 'match', 'pattern' => '/^\d{6}$/', 'message' => 'PIN ต้องเป็นตัวเลข 6 หลัก'],
            ['rememberMe', 'boolean'],
            ['pin', 'validateProviderLogin'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'citizen_id' => 'เลขบัตรประชาชน',
            'pin'        => 'PIN',
            'rememberMe' => 'จดจำการเข้าสู่ระบบ',
        ];
    }

    /**
     * ตรวจสอบ Check Digit ของเลขบัตรประชาชนไทย
     */
    public function validateCheckDigit($attribute)
    {
        $id = $this->$attribute;
        if (strlen($id) !== 13 || !ctype_digit($id)) return;

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $sum += (int)$id[$i] * (13 - $i);
        }
        $checkDigit = (11 - ($sum % 11)) % 10;

        if ($checkDigit != (int)$id[12]) {
            $this->addError($attribute, 'เลขบัตรประชาชนไม่ถูกต้อง');
        }
    }

    /**
     * ตรวจสอบ PIN กับฐานข้อมูล / Provider ID API
     * ปรับ logic ตรงนี้ให้ตรงกับระบบของโรงพยาบาล
     */
    public function validateProviderLogin($attribute, $params)
    {
        if ($this->hasErrors()) return;

        $user = $this->getUser();

        if (!$user) {
            $this->addError('citizen_id', 'ไม่พบข้อมูลผู้ใช้ในระบบ');
            return;
        }

        // ตรวจสอบ PIN — ปรับตามการเก็บ hash ในระบบ
        if (!$this->verifyPin($user)) {
            $this->addError('pin', 'PIN ไม่ถูกต้อง');
        }
    }

    /**
     * ดึงข้อมูล User จาก citizen_id
     * *** ปรับ query ให้ตรงกับ table ของระบบ ***
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            // ตัวอย่าง: ค้นหาจาก table users หรือ provider ของระบบ HIS
            // กรณีใช้ dektrium/yii2-user
            $this->_user = \dektrium\user\models\User::findOne([
                'username' => $this->citizen_id,
            ]);

            // หรือถ้ามี table แยก เช่น provider_users:
            // $this->_user = \app\models\ProviderUser::findOne(['citizen_id' => $this->citizen_id]);
        }
        return $this->_user;
    }

    /**
     * ตรวจสอบ PIN
     * *** ปรับให้ตรงกับวิธีเก็บ PIN ในระบบ ***
     */
    protected function verifyPin($user)
    {
        // กรณี PIN เก็บเป็น hash (แนะนำ)
        // return Yii::$app->security->validatePassword($this->pin, $user->pin_hash);

        // กรณีเรียก Provider ID API ภายนอก
        // return $this->callProviderApi($this->citizen_id, $this->pin);

        // กรณีเทียบตรง (ไม่แนะนำ production)
        return $user->password_hash !== null
            ? Yii::$app->security->validatePassword($this->pin, $user->password_hash)
            : false;
    }

    /**
     * Login เข้าระบบ Yii2
     */
    public function login()
    {
        if (!$this->validate()) return false;

        $user = $this->getUser();
        $duration = $this->rememberMe ? 3600 * 24 * 30 : 0;

        return Yii::$app->user->login($user, $duration);
    }
}
