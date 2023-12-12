<?php

namespace common\models;

use Yii;
use common\models\Categoria;
use common\models\Servicios;
use common\models\Fotos;
use common\models\ServiciosArrendamientos;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\Html;
/**
 * This is the model class for table "arrendamiento".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property float $precio
 * @property int $categoria_id
 * @property int $user_id
 *
 * @property Categoria $categoria
 * @property Fotos[] $fotos
 * @property ServiciosArrendamientos[] $serviciosArrendamientos
 * @property User $user
 */
class Arrendamiento extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $categoriasLista;
    public $servicios_ids;
    public $serviciosLista;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arrendamiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'precio', 'categoria_id', 'user_id'], 'required'],
            [['descripcion'], 'string'],
            [['precio'], 'number'],
            [['categoria_id', 'user_id'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 3],
            [['servicios_ids'], 'required'],
            [['servicios_ids'], 'each', 'rule' => ['integer']],  // Asegura que cada ID sea un número entero
            

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'titulo' => Yii::t('app', 'Titulo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'precio' => Yii::t('app', 'Precio'),
            'categoria_id' => Yii::t('app', 'Categoria'),
            'user_id' => Yii::t('app', ''),
            'imageFile' => Yii::t('app', 'Imagenes de la propiedad'),
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[Fotos]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getFotos()
    {
        return $this->hasMany(Fotos::class, ['arrendamiento_id' => 'id']);
    }

    /**
     * Gets query for [[ServiciosArrendamientos]].
     *
     * @return \yii\db\ActiveQuery|ServiciosArrendamientosQuery
     */
    public function getServiciosArrendamientos()
    {
        return $this->hasMany(ServiciosArrendamientos::class, ['arrendamiento_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ArrendamientoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArrendamientoQuery(get_called_class());
    }
    public static function getCategorias()
    {
        $categorias = Categoria::find()->asArray()->all();
        $categoriasLista =  ArrayHelper::map($categorias, 'id', 'nombre');

        return $categoriasLista;
    }
    public static function getServicios()
    {
        $servicios = Servicios::find()->asArray()->all();
        $serviciosLista =  ArrayHelper::map($servicios, 'id', 'nombre');

        return $serviciosLista;
    }

    public function saveImage() {

        Yii::$app->db->transaction(function ($db){
            /**
             * @var $db yii\db\Connection
             */
            foreach ($this->imageFile as $file) {
                /**
                 * @var $file UploadedFile
                 */
                $foto = new Fotos();
                $foto->nombre = uniqid(true) . '.' . $file->extension;
    
                $foto->url = Yii::$app->urlManager->createAbsoluteUrl('/uploads/casas');
                
                $foto->arrendamiento_id = $this->id;
                $foto->save();
    
                if(!$file->saveAs('uploads/casas/' . $foto->nombre)){//La direccion en la que se va guardar la imagen
                    //Si la imagen se guardo en la carpete se inserta en la base de datos
                    $db->transaction->rollBack();
    
                } 
             
            }
        });
        
    }

    public function hasImages()
    {
        return count($this->fotos) > 0;
    }

    public function imageAbsoluteUrls() {
        $urls = [];
        foreach ($this->fotos as $image) {
            $urls[] = $image->absoluteUrl();
        }
        return $urls;
    }

    public function imageConfigs() {
        $configs = [];
        foreach ($this->fotos as $image) {
            $configs[] = [
                'key' => $image->id,
            ];
        }
        return $configs;
    }

    public function loadUploadedImageFiles()
    {
        $this->imageFile = UploadedFile::getInstances($this, 'imageFile');
    }

    public function arrendamientoServicio($servicios_ids) {
        foreach ($servicios_ids as $servicioId) {
            $relacion = new ServiciosArrendamientos();
            $relacion->arrendamiento_id = $this->id;
            $relacion->servicio_id = $servicioId;
            $relacion->save();
        }
    }
    
    
    public function carouselImages()
    {
        return array_map(function ($fotos) {
            return Html::img($fotos->absoluteUrl(), [
                'alt' => $this->titulo,
                'class' => 'project-view__carousel-image'
            ]);
        }, $this->fotos);
    }

    public function getServiciosSeleccionados()
    {
        $serviciosNombres = [];

        foreach ($this->serviciosArrendamientos as $servicioArrendamiento) {
            $serviciosNombres[] = $servicioArrendamiento->servicio->nombre;
        }

        return $serviciosNombres;
    }

    public function serviciosAbsolute()
    {
        return ArrayHelper::getColumn($this->serviciosArrendamientos, 'servicio_id');
    }

    
    
}
