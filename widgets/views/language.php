<?php

/* @var $this yii\web\View */
/* @var $language string */
/* @var $languages array */

use yii\helpers\Html;

echo Html::beginForm(Yii::$app->request->url, 'post', ['class' => 'navbar-form navbar-left'])
. Html::dropDownList('language', $language, $languages,
    ['class' => 'form-control language-select']
)
. Html::endForm();


