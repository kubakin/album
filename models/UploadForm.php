<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Images
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function upload($papka,$filename)
    {
        if ($this->validate()) {
            //die(var_dump($this->imageFile));
            $this->imageFile->saveAs('uploads/'.$papka.'/' . $filename . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}