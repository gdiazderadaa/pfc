<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $id
 * @property string $login
 * @property string $email
 * @property integer $rol_id
 * @property string $password
 *
 * @property Incidencia[] $incidencias
 * @property Incidencia[] $incidencias0
 * @property Informe[] $informes
 * @property Rol $rol
 */
class Usuario extends \yii\db\ActiveRecord
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
            [['login', 'email', 'rol_id', 'password'], 'required'],
            [['rol_id'], 'integer'],
            [['login', 'email'], 'string', 'max' => 128],
            [['password'], 'string', 'max' => 32]
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
            'email' => 'Email',
            'rol_id' => 'Rol ID',
            'password' => 'Password',
        ];
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
