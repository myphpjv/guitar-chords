<?php

/**  @var $this \yii\web\View */

use app\widgets\GeneratorWidget;

$this->title = Yii::t('app', 'Guitar chord generator');
$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::$app->params[Yii::$app->language . '-meta_description']
]);
?>
<h1 class="header-title"><?= Yii::t('app', 'Chord generator') ?></h1>
<?= GeneratorWidget::widget() ?>
<div class="generator-desc">
    <?= $this->render('descriptions/_generator_desc_' . Yii::$app->language) ?>
</div>

