<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
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
            ['password', 'validatePasswordLdap'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('app','Incorrect username or password.'));
            }
        }
    }
    
    public function validatePasswordLdap($attribute, $params)
    {
    	if (!$this->hasErrors()) {
    		
    		$conectado_LDAP = ldap_connect('localhost');
    		ldap_set_option($conectado_LDAP, LDAP_OPT_PROTOCOL_VERSION, 3);
    		ldap_set_option($conectado_LDAP, LDAP_OPT_REFERRALS, 0);
    		ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);
    		
    		if ($conectado_LDAP)
    		{
    			try {
    				$autenticado_LDAP_personal = ldap_bind($conectado_LDAP, "cn={$this->username},ou=Personal,dc=ident,dc=uniovi,dc=es", $this->password);
    			    			
    			} catch (yii\base\ErrorException $e) {
    				try {
    					$autenticado_LDAP_alumnos = ldap_bind($conectado_LDAP, "cn={$this->username},ou=Alumnos,dc=ident,dc=uniovi,dc=es", $this->password);
    				} catch (yii\base\ErrorException $e) {
    				}
    			}
    			
    			
    			
    			//$autenticado_LDAP = ldap_bind($conectado_LDAP, "{$this->username}@ident.uniovi.es", $this->password);
    			if (isset($autenticado_LDAP_alumnos) || isset($autenticado_LDAP_personal)) {
    				die("autenticado");
    			}
    			else{
    				die("No autenticado");
    			}
    		}
    		
    		
    		$user = $this->getUserLdap();
    		
    		if (!$user || !Yii::$app->ldap->authenticate($this->username,$this->password)) {
    			$this->addError($attribute, Yii::t('app','Incorrect username or password.'));
    		}
    	}
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }
    
    public function loginLdap()
    {
    	if ($this->validate()) {
    		return Yii::$app->user->login($this->getUserLdap(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    	} else {
    		return false;
    	}
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuario::findByUsername($this->username);
        }

        return $this->_user;
    }
    
    public function getUserLdap()
    {
    	if ($this->_user === false) {
    		$this->_user = Usuario::findIdentity($this->username);
    	}
    
    	return $this->_user;
    }
}
