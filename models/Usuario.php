<?php

namespace app\models;

use Yii;

use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


/**
 * This is the model class for table "usuario".
 *
 * @property integer $id
 * @property string $login
 * @property integer $rol_id
 *
 * @property Incidencia[] $incidencias
 * @property Incidencia[] $incidencias0
 * @property Informe[] $informes
 * @property Rol $rol
 */
class Usuario extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Usuario');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Usuarios');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'rol_id'], 'required'],
            [['rol_id'], 'integer'],
            [['login'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'rol_id' => 'Rol',
        ];
    }


    /**
     * @inheritdoc
     */
	public static function findIdentity($id)
	{
	    $new_identity = new Usuario();	
    
	    if ( $user_ldap_info = Yii::$app->ldap->users()->find($id) ) {
	        $new_identity->setId ( $user_ldap_info->samaccountname [0] );
	        $new_identity->setEmail ( $user_ldap_info->mail[0] );
	        $new_identity->setUsername ( $user_ldap_info->givenname [0] );
	    }

	    
	    //print all informations of the user object
	    echo '<pre>';
	    echo var_dump($new_identity);
	    echo '</pre>';
	    die;

	    return $new_identity;
	}
    
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = NULL)
    {
    	throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
    	return $this->getPrimaryKey();
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
    	throw new NotSupportedException('"getAuthKey" is not implemented.');
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
    	throw new NotSupportedException('"validateAuthKey" is not implemented.');
    }
    
    public function setEmail($email)
    {
    	$this->email = $email;
    }
    
    public function setUsername($username)
    {
    	$this->username = $username;
    }
    
    public function setId($id)
    {
    	$this->id = $id;
    }
    
    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
    	return static::findOne(['login' => $username]);
    }
    
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidencias()
    {
        return $this->hasMany(Incidencia::className(), ['creador_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIncidencias0()
    {
        return $this->hasMany(Incidencia::className(), ['tecnico_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformes()
    {
        return $this->hasMany(Informe::className(), ['creador_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'rol_id']);
    }
}
