<?php

use yii\helpers\Html;
use app\models\Tone;
use app\models\FingeringService;

/* @var $this yii\web\View */
/* @var $chords [] */
/* @var $prompt string */

$this->title = Yii::t('app', 'Сomplete chord list');

$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::$app->params[Yii::$app->language . '-meta_description_list']
]);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->urlManager->createAbsoluteUrl(['/site/chords'])]);
?>
<h1 class="header-title"><?= $this->title ?></h1>

<?= Html::beginForm(Yii::$app->urlManager->createUrl(['site/chords']), 'get', ['class' => 'form-inline']) ?>
<?= Html::dropDownList('id', Yii::$app->request->get('id'), Tone::getTonesList(),
    ['class' => 'form-control chords-filter', 'prompt' => $prompt]) ?>
<?= Html::endForm() ?>

<div class="total-chords-wrap">
    <?php foreach ($chords as $tone => $types): ?>
        <div class="total-chords-wrap">
            <?php foreach ($types as $type => $chords): ?>
                <?= $tone . $type . ' ' ?>
                <?= Html::tag('i', '', ['class' => 'fa fa-plus-square-o show-chords', 'title' => Yii::t('app', 'Show all')]) ?>
                <ul class="total-chords-list">
                    <?php foreach ($chords['fingers'] as $key => $chord): ?>
                        <?php
                        $url = Yii::$app->urlManager->createUrl(['site/chord', 'id' => $chord['id']]);
                        $num = $key + 1 ?>
                        <?= Html::tag('li',
                            Html::a('Вариант ' . $num, $url, ['target' => '_blank']),
                            [
                                'title' => '<div class="image-tooltip"><img src="' . FingeringService::IMAGE_DIR . $chord['id'] . '.png"><div>',
                                'class' => 'chord-link',
                                'data-toggle' => "tooltip",
                                'data-placement' => "right"
                            ]
                        ) ?>
                    <?php endforeach; ?>
                </ul>
                <div class="clearfix"></div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

</div>
<div class="generator-desc">
    <?= $this->render('descriptions/_chords_desc_' . Yii::$app->language) ?>
</div>

