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
?>

<div class="chords-diagram">
    <div class="chords-select" data-url="<?= Yii::$app->urlManager->createUrl(['/site/fingers']) ?>">
        <div class="list-inline list-tones">
            <ul>
                <?php $i = 0 ?>
                <?php foreach ($tones as $toneKey => $toneValue): ?>
                    <?php $class = ($toneKey == $selectedToneId) ? 'class="selected"' : '' ?>
                    <li <?= $class ?> data-value="<?= $toneKey ?>"><?= $toneValue ?></li>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="list-inline list-types">
            <ul>
                <?php $i = 0 ?>
                <?php foreach ($types as $typeKey => $typeValue): ?>
                    <?php $class = ($typeKey == $selectedTypeId) ? 'class="selected"' : '' ?>
                    <li <?= $class ?> data-value="<?= $typeKey ?>"><?= $typeValue ?></li>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="list-inline list-fingerings">
            <ul>
                <?php foreach ($fingerings as $fingerKey => $fingerValue): ?>
                    <?php $class = $fingerKey == $selectedFingeringId ? 'class="selected"' : '' ?>
                    <li <?= $class ?> data-value="<?= $fingerKey ?>"><?= $fingerValue ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="chord-image-wrap">
        <div id="chord-image" data-chord="<?= Yii::t('app', 'Chord') ?>">
            <img src="<?= $model->getImageUrl() ?>"
                 alt="<?= $imageTitle ?>"
                 title="<?= $imageTitle ?>">
        </div>
        <div id="chord-link-wrap">
            <div class="switch-chord" data-url="<?= Yii::$app->urlManager->createUrl(['/site/set-fingering']) ?>">
                <button class="switch-chord-btn chord-prev btn btn-chord">
                    <i class="fa fa-angle-left left-arrow"></i>
                    <?= Yii::t('app', 'Prev'); ?>
                </button>
                <button class="switch-chord-btn chord-next btn btn-chord">
                    <?= Yii::t('app', 'Next'); ?>
                    <i class="fa fa-angle-right right-arrow"></i>
                </button>
            </div>
            <div class="ui action input">
                <input type="text" class="form-control" id="chord-link" value="<?= $model->getImageUrl() ?>">
            </div>
            <div class="chord-buttons-wrap">
                <button class="copy-chord-url btn btn-chord" data-content="<?= Yii::t('app', 'Copied') ?>">
                    <?= Yii::t('app', 'Copy URL'); ?>
                </button>
                <a href="#" download="image.png" class="btn btn-chord download-image">
                    <?= Yii::t('app', 'Download') ?>
                    <?= mb_strtolower(Yii::t('app', 'Image')) ?>
                </a>
            </div>
        </div>
    </div>
</div>
