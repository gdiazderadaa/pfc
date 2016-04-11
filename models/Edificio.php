<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "edificio".
 *
 * @property string $id
 * @property string $nombre 
 * @property string $localidad
 * @property string $imagen
 * @property string $imagen_servidor
 *
 * @property PlantaEdificio[] $plantasEdificio
 */
class Edificio extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'edificio';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Building');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Buildings');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'localidad'], 'required'],
            [['nombre', 'localidad'], 'string'],
            [['imagen', 'imagen_servidor'], 'file', 'extensions'=>'jpg, gif, png'],
            [['imagen', 'imagen_servidor'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Name'),
            'localidad' => Yii::t('app', 'Address'),
            'planta_edificio_id' => Yii::t('app','Floor'),
            'imagen' => Yii::t('app', 'Image'),
            'imagen_servidor' => Yii::t('app', 'Image'),
        ];
    }
    
    
    /**
     * fetch stored image file name with complete path 
     * @return string
     */
    public function getImageFile() 
    {
        return isset($this->imagen_servidor) ? Yii::$app->params['uploadPath'] . $this->imagen_servidor : null;
    }


    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $ruta_imagen = isset($this->imagen_servidor) ? $this->imagen_servidor : '';
        return Yii::$app->params['uploadUrl'] . $ruta_imagen;
    }


    /**
    * Process upload of image
    *
    * @return mixed the uploaded image instance
    */
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'imagen');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
        $this->imagen = $image->name;
        $ext = end((explode(".", $image->name)));

        // generate a unique file name
        $this->imagen_servidor = Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $image;
    }


    /**
    * Process deletion of image
    *
    * @return boolean the status of deletion
    */
    public function deleteImage() {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->imagen_servidor = null;
        $this->imagen = null;

        return true;
    }
    	 
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
    public function getPlantasEdificio() 
    { 
        return $this->hasMany(PlantaEdificio::className(), ['edificio_id' => 'id']); 
    } 
}
