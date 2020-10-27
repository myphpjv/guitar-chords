<?php

/**  @var $this \yii\web\View */
/**  @var $tones array */
/**  @var $types array */
/**  @var $fingerings array */
/**  @var $selectedFingeringId int */
/**  @var $selectedToneId int */
/**  @var $selectedTypeId int */
/**  @var $chordName string */
/**  @var $imageTitle string */
/**  @var $chordId int */

/**  @var $model app\models\FingeringService */

use app\widgets\GeneratorWidget;

$this->title = Yii::t('app', 'Chord') . ' ' . $chordName;
$this->registerMetaTag([
    'name' => 'description',
    'content' => Yii::t('app', 'Chord') . ' ' . $chordName . '. ' .
        Yii::$app->params[Yii::$app->language . '-meta_description_single_chord']
]);
?>

<h1 class="header-title"><?= Yii::t('app', 'Chord') . ' ' . $chordName; ?></h1>
<?= GeneratorWidget::widget(['chordId' => $chordId]) ?>
<div class="generator-desc">
    <?= $this->render('descriptions/_single_chord_desc_' . Yii::$app->language, ['chord' => $chordName]) ?>
</div>

