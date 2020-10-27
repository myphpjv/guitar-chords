<?php

namespace app\controllers;

use app\models\Fingering;
use app\components\Sitemap;
use app\models\FingeringService;
use app\components\FrontController;
use Yii;
use yii\web\Response;

class SiteController extends FrontController
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Главная страница
     *
     * @return string
     */
    public function actionGenerator()
    {
        return $this->render('generator');
    }

    /**
     * Страница одного аккорда
     *
     * @param int $id
     * @return string
     */
    public function actionChord($id)
    {
        $model = new FingeringService($id);
        return $this->render('chord', [
            'chordId' => $id,
            'chordName' => $model->getToneAndTypeName(),
        ]);
    }

    /**
     * Страница всех аккордов
     *
     * @param null|int $id
     * @return string|Response
     */
    public function actionChords($id = null)
    {
        if (isset($_REQUEST['id'])) {
            if (!empty($_REQUEST['id'])) {
                $url = Yii::$app->urlManager->createUrl(['site/chords', 'id' => $_REQUEST['id']]);
            } else {
                $url = Yii::$app->urlManager->createUrl(['site/chords']);
            }
            return $this->redirect($url);
        }

        return $this->render('chords', [
            'chords' => Fingering::getFingerings($id),
            'prompt' => !empty($id) ? Yii::t('app', 'Select all') : Yii::t('app', 'Select tone')
        ]);
    }

    /**
     * Возвращает аппликатуры аккорда
     *
     * @param int $toneId
     * @param int $typeId
     * @return array
     */
    public function actionFingers($toneId, $typeId)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Fingering::getFingeringsByToneAndType($toneId, $typeId);
    }

    /**
     * Создает куку с последним выбранным аккордом
     *
     * @param $id
     * @return bool|void
     */
    public function actionSetFingering($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Fingering::findOne($id);
        if ($model) {
            $cookies = Yii::$app->response->cookies;
            return $cookies->add(new \yii\web\Cookie([
                'name' => Yii::$app->params['fingeringCookieName'],
                'value' => $model->id,
            ]));
        }
        return false;
    }

    /**
     * Создает sitemap
     */
    public function actionSitemap()
    {
        $siteMap = new Sitemap();
        $siteMap->generate();
    }
}
