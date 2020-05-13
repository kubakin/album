<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property string $login
 * @property string|null $password
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login'], 'required'],
            [['password'], 'string', 'max' => 255],
            [['login'], 'string', 'max' => 16],
            [['login'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'login' => 'Login',
            'password' => 'Password',
        ];
    }
    public static function findByUsername($username)
    {
       
            return User::findOne($username);
         
    }
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
   //     return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->login;
    }
    
    
    public function getAuthKey()
    {
      //  return $this->login;
    }

    public function validateAuthKey($authKey)
    {
      //  return $this->authKey === $authKey;
    }


}
