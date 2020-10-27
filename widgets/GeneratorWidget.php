<?php


namespace app\widgets;

use app\models\FingeringService;
use app\models\Tone;
use app\models\Type;
use yii\base\Widget;
use Yii;

class GeneratorWidget extends Widget
{
    public $chordId;

    public function run()
    {
        $model = new FingeringService($this->chordId);
        return $this->render('generator', [
            'tones' => Tone::getTonesList(),
            'types' => Type::getTypesList(),
            'fingerings' => $model->getFingerings(),
            'selectedFingeringId' => $model->fingeringId,
            'selectedTypeId' => $model->getSelectedTypeId(),
            'selectedToneId' => $model->getSelectedToneId(),
            'chordName' => $model->getToneAndTypeName(),
            'imageTitle' => Yii::t('app', 'Chord') . ' ' . $model->getToneAndTypeName(),
            'model' => $model
        ]);
    }
}