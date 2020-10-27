<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tone".
 *
 * @property int $id
 * @property string $name
 */
class Tone extends \yii\db\ActiveRecord
{
    const DEFAULT_TONE_ID = 10; // Тон A

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tone';
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
    public static function getTonesList()
    {
        $models = self::find()->asArray()->all();
        return ArrayHelper::map($models, 'id', 'name');
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getTones()
    {
        return self::find()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFingerings()
    {
        return $this->hasMany(Fingering::class, ['tone_id' => 'id']);
    }

}
