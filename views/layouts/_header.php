<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\LanguageWidget;

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
?>

<nav class="navbar navbar-inverse navbar-custom">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-navbar-collapse" aria-expanded="false">
                <span class="sr-only"><?= Yii::t('app', 'Menu') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Yii::$app->urlManager->createUrl(['/']) ?>"><?= Yii::$app->name ?></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <?= LanguageWidget::widget(); ?>
            <ul class="nav navbar-nav">
                <li>
                    <?php if ($controller == 'site' && $action == 'chords'): ?>
                        <span class="menu-item-current"><?= Yii::t('app', 'Сomplete chord list') ?></span>
                    <?php else: ?>
                        <a href="<?= Yii::$app->urlManager->createUrl(['site/chords']) ?>">
                            <?= Yii::t('app', 'Сomplete chord list') ?>
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
