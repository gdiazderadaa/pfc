<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "planta_edificio".
 *
 * @property string $id
 * @property string $nombre
 * @property string $imagen
 * @property string $imagen_servidor
 * @property string $edificio_id 
 * 
 * @property Espacio[] $espacios 
 * @property Edificio $edificio 
 */
class PlantaEdificio extends \yii\db\ActiveRecord
{
    /**
    * @var mixed image the attribute for rendering the file input
    * widget for upload on the form
    */
    public $image;
    
    /**
     * @inheritdoc
     */
    public static function tableName()Name
    {
        return 'planta_edificio';
    }
    
    public static function singularObjectName(){
        return Yii::t('app', 'Floor');
    }
    
    public static function pluralObjectName(){
        return Yii::t('app', 'Floors');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre','edificio_id'], 'required'],
            [['edificio_id'], 'integer'],
            [['nombre'], 'string', 'max' => 64],
            [['imagen', 'imagen_servidor'], 'file', 'extensions'=>'jpg, gif, png'],
            [['imagen', 'imagen_servidor'], 'safe'],
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificio::className(), 'targetAttribute' => ['edificio_id' => 'id']],
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
            'imagen' => Yii::t('app', 'Image'),
            'imagen_servidor' => Yii::t('app', 'Image'),
            'edificio_id' => Yii::t('app', 'Building'),
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
    * Process upload of image from $_FILES produced by a DynamicRelations form
    * which doesn't contain actual ids but unique ids generated by the inline forms
    * @return mixed the uploaded image instance
    */
    public function uploadImageFromDynamicRelations() {
        $post = ArrayHelper::getValue($_POST, 'PlantaEdificio');
        $isNewRecord;

        if (ArrayHelper::keyExists($this->id,$post)) {
            //$imagen = UploadedFile::getInstancesByName("PlantaEdificio[name][".$this->id."]");
            $file = [
                'name' =>  ArrayHelper::getValue($_FILES,['PlantaEdificio','name',$this->id]),
                'type' =>  ArrayHelper::getValue($_FILES,['PlantaEdificio','type',$this->id]),
                'tmp_name' =>  ArrayHelper::getValue($_FILES,['PlantaEdificio','tmp_name',$this->id]),
                'error' =>  ArrayHelper::getValue($_FILES,['PlantaEdificio','error',$this->id]),
                'size' =>  ArrayHelper::getValue($_FILES,['PlantaEdificio','size',$this->id]),
            ];
        } else {
            foreach ($post['new'] as $key => $value) {
                if (ArrayHelper::getValue($value, 'nombre') == $this->nombre){
                    //$imagen = UploadedFile::getInstancesByName("PlantaEdificio[name][new][".$key."]");
                    $file = [
                        'name' =>  ArrayHelper::getValue($_FILES,['PlantaEdificio','name','new',$key]),
                        'type' =>  ArrayHelper::getValue($_FILES,['PlantaEdificio','type','new',$key]),
                        'tmp_name' =>  ArrayHelper::getValue($_FILES,['PlantaEdificio','tmp_name','new',$key]),
                        'error' =>  ArrayHelper::getValue($_FILES,['PlantaEdificio','error','new',$key]),
                        'size' =>  ArrayHelper::getValue($_FILES,['PlantaEdificio','size','new',$key]),
                    ];
                    break;
                }
            }
        }        
     

        if (empty($file) || ArrayHelper::getValue($file,['error','imagen']) != "0") {
            if ($this->imagen == "" && $this->imagen_servidor != "") {
                $this->deleteImage();
                $this->save();      
            }
               
            return false;
        }

        // Delete old image if exists
        $this->deleteImage();

        // store the source file name
        $this->imagen = ArrayHelper::getValue($file,['name','imagen']);
        $ext = end((explode(".", $this->imagen)));

        // generate a unique file name
        $this->imagen_servidor = Yii::$app->security->generateRandomString().".{$ext}";

        $path = $this->getImageFile();
        copy(ArrayHelper::getValue($file,['tmp_name','imagen']), $path);
        $this->save();
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
    public function getEspacios()
    {
        return $this->hasMany(Espacio::className(), ['planta_edificio_id' => 'id']);
    }
    
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEdificio()
    {
        return $this->hasOne(Edificio::className(), ['id' => 'edificio_id']);
    }
    
    
    public function getEdificioList() 
	{	 
        $models = Edificio::find()->asArray()->all();
        return ArrayHelper::map($models,'id', 'nombre');
    }
    
    
    public static function getPlantasByEdificioId($edificioId) 
	{	 
        $models = PlantaEdificio::find()->where(['edificio_id' => $edificioId])->all();
        return ArrayHelper::toArray($models, [
            PlantaEdificio::classname() => [
                'id',
                'name' => 'nombre',
            ],
        ]);
    }
}
