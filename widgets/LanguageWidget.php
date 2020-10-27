<?php

namespace app\widgets;

use Yii;

class LanguageWidget extends \yii\base\Widget
{
    public function run()
    {
        return $this->render('language', [
            'languages' => Yii::$app->params['languages'],
            'language' => \Yii::$app->language,
        ]);
    }
}