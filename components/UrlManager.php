<?php

namespace app\components;

use Yii;

class UrlManager extends \yii\web\UrlManager
{

    /**
     * Добавляет язык в ссылку
     *
     * @param array|string $params
     * @return string
     */
    public function createUrl($params)
    {
        $url = parent::createUrl($params);
        $currentLang = Yii::$app->language;
        $defaultLang = Yii::$app->params['defaultLanguage'];

        if($currentLang === $defaultLang || $this->isException($url)) {
            return $url;
        }

        if($currentLang !== $defaultLang && $url === '/') {
            return '/' . $currentLang;
        }

        return '/' . $currentLang . $url;
    }

    /**
     * Проверяет ссылку, в который не нужно добавлять язык
     *
     * @param $url
     * @return bool
     */
    public function isException($url)
    {
        $lastChars = substr($url, -3);
        if (strpos($url, 'uploads') !== false && in_array($lastChars, ['jpg', 'png', 'gif'])) {
            return true;
        }
        if (strpos($url, 'sitemap') !== false) {
            return true;
        }
        return false;
    }

}