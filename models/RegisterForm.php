<?php

namespace app\models;

use phpDocumentor\Reflection\Types\Null_;
use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['username', 'validateLogin']
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
   
    public function validateLogin($attribute, $params)
    {
     //   die('qwe');
        if (!$this->hasErrors()) {
            //die(ctype_alpha($this->username[0]));
          
          if (ctype_alpha($this->username[0])==false) {
            // die('tets');
             $this->addError($attribute, 'должно начинаться с буквы и только латинские');
         }
            $user = User::findOne($this->getUser());
            //die(var_dump($user));
            //die(var_dump($user->login));
            //die(var_dump($user));
            if ($user != null) {
               // die('tets');
                $this->addError($attribute, 'Уже существует');
            }
            if (strlen($this->username) > 16) {
                // die('tets');
                
                 $this->addError($attribute, 'Много символов');
             }
             preg_match_all('/[^\d^\w^_]/',$this->username,$out);
           // die(var_dump(implode($out[0])));
             if (implode($out[0])) {
                
                 $this->addError($attribute, 'Запрещенные символы');
             }
           
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {   
        if ($this->validate()) {
            $user =  new User();   
            $user->login = $this['username'];
            $user->password = md5($this['password']);
            $user->save(); 
            return true;
        }
        return false;
        
    }
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
