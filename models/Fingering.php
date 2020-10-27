<?php

namespace app\models;

/**
 * This is the model class for table "fingering".
 *
 * @property int $id
 * @property int $tone_id
 * @property int $type_id
 * @property int|null $tune
 * @property string|null $frets
 * @property string|null $fingers
 * @property string|null $code
 * @property int|null $sort
 */
class Fingering extends \yii\db\ActiveRecord
{
    const DEFAULT_FINGERING_ID = 9392;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fingering';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tone_id', 'type_id'], 'required'],
            [['tone_id', 'type_id', 'tune', 'sort'], 'integer'],
            [['frets', 'fingers', 'code'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tone_id' => 'Tone ID',
            'type_id' => 'Type ID',
            'tune' => 'Start Fret',
            'frets' => 'Frets',
            'fingers' => 'Fingers',
            'code' => 'Code',
            'sort' => 'Sort',
        ];
    }

    /**
     * Возвращает аппликатуры аккордов по тону и типу
     *
     * @param int $toneId
     * @param int $typeId
     * @return array
     */
    public static function getFingeringsByToneAndType($toneId, $typeId)
    {
        $models = Fingering::find()
            ->where(['tone_id' => $toneId, 'type_id' => $typeId])
            ->orderBy('sort')
            ->all();

        $result = [];
        foreach ($models as $model) {
            $result[] = ['id' => $model->id, 'frets' => $model->frets];
        }
        return $result;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTone()
    {
        return $this->hasOne(Tone::className(), ['id' => 'tone_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    /**
     * @return string|null
     */
    public function getToneName()
    {
        return !empty($this->tone) ? $this->tone->name : null;
    }

    /**
     * @return string|null
     */
    public function getTypeName()
    {
        return !empty($this->type) ? $this->type->name : null;
    }

    /**
     * Возвращает аппликатуры аккордов
     *
     * @param int|null $toneId
     * @return array
     */
    public static function getFingerings($toneId = null)
    {
        $query = Fingering::find()->joinWith(['tone', 'type']);
        if ($toneId) {
            $query->andWhere([Fingering::tableName() . '.tone_id' => $toneId]);
        }
        $models = $query->asArray()->all();
        $chords = [];
        foreach ($models as $model) {
            $toneName = $model['tone']['name'];
            $typeName = $model['type']['name'];
            $chords[$toneName][$typeName]['fingers'][] = ['id' => $model['id'], 'frets' => $model['frets']];
        }
        return $chords;
    }

}
