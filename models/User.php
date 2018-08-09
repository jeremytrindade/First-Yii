<?php

namespace app\models;

use Yii;
use yi\base\Model;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\Security;

class User extends ActiveRecord implements IdentityInterface
{
    public $password_repeat;
    public static function tableName()
    {
        return '{{%tbl_user}}';
    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return[
            // name, email, subject and body are required
            [['full_name', 'email', 'username', 'password', 'password_repeat'],'required'],
            // email has to be valid email address
            ['email', 'email'],
            // Compare passwords
            ['password_repeat', 'compare', 'compareAttribute'=>'password'],
        ];
    }

    /**
     * Trouve une identité à partir de l'identifiant donné.
     *
     * @param string|i%nt $id l'identifiant à rechercher
     * @return IdentityInterface|null l'objet identité qui correspond à l'identifiant donné
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Trouve une identité à partir du jeton donné
     *
     * @param string $token le jeton à rechercher
     * @return IdentityInterface|null l'objet identité qui correspond au jeton donné
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string l'identifiant de l'utilisateur courant
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string la clé d'authentification de l'utilisateur courant
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validatePassword($password){
        return $this->password === md5($password);
    }

    public static function findByUsername($username){
        return User::findOne(['username' => $username]);
    }
    /**
     * @param string $authKey
     * @return bool si la clé d'authentification est valide pour l'utilisateur courant
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    public function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            if(isset($this->password)){
                $this->password=md5($this->password);
                return parent::beforeSave($insert);
            }
        }
        return true;
    }
    public function getJob(){
        return $this->hasMany(Job::className(),['user_id'=>'id']);
    }
}