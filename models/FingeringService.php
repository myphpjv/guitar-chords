<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Сервис модель для работы с классом "Fingering"
 *
 * @property int $fingeringId
 * @property Fingering $fingeringModel
 * @property string $chordName
 */
class FingeringService
{
    const IMAGE_DIR = '/uploads/';
    public $fingeringId;
    public $fingeringModel;
    public $chordName;

    /**
     * FingeringService constructor. $id - Fingering id
     *
     * @param int|null $id
     */
    public function __construct($id = null)
    {
        if ($id && ($model = Fingering::findOne($id)) !== null) {
            $this->fingeringId = $model->id;
        } else {
            $cookies = Yii::$app->request->cookies;
            $this->fingeringId = $cookies->getValue(Yii::$app->params['fingeringCookieName'], Fingering::DEFAULT_FINGERING_ID);
        }
        $this->fingeringModel = Fingering::findOne($this->fingeringId);
        $this->chordName = $this->getToneAndTypeName();
    }

    /**
     * Вовращает выбранный пользователем id тона аккорда
     *
     * @return int|null
     */
    public function getSelectedToneId()
    {
        return !empty($this->fingeringModel) ? $this->fingeringModel->tone_id : null;
    }

    /**
     * Вовращает выбранный пользователем id типа аккорда
     *
     * @return int|null
     */
    public function getSelectedTypeId()
    {
        return !empty($this->fingeringModel) ? $this->fingeringModel->type_id : null;
    }

    /**
     * Возвращает аппликатуру выбранного аккорда
     *
     * @return array
     */
    public function getFingerings()
    {
        $models = Fingering::find()
            ->where(['tone_id' => $this->getSelectedToneId(), 'type_id' => $this->getSelectedTypeId()])
            ->orderBy('sort')
            ->asArray()
            ->all();
        return ArrayHelper::map($models, 'id', 'frets');
    }

    /**
     * Возвращает название аккорда
     *
     * @return string
     */
    public function getToneAndTypeName()
    {
        if(!$this->fingeringModel) {
            return null;
        }
        return $this->fingeringModel->getToneName() . '' .  $this->fingeringModel->getTypeName();
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return Yii::$app->urlManager->createAbsoluteUrl(self::IMAGE_DIR . $this->fingeringId . '.png');
    }

}