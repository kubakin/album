<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Images".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $caption
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'caption', 'path', 'whoadd','picname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'caption' => 'Caption',
        ];
    }
    public function getOnlymy() {
        return Images::findOne('adm');
    }
  
    
}
