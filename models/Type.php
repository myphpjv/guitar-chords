<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "type".
 *
 * @property int $id
 * @property string $name
 */
class Type extends \yii\db\ActiveRecord
{
    const DEFAULT_TYPE_ID = 3; // Тип m

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
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
        ];
    }

    /**
     * @return array
     */
    public static function getTypesList()
    {
        $models = self::find()->asArray()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

}
