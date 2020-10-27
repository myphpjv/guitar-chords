<?php

namespace app\components;

use Yii;

class Request extends \yii\web\Request
{
    private $langUrl;

    /**
     * Возвращает ссылку без языка
     *
     * @return bool|string|string[]|null
     * @throws \yii\base\InvalidConfigException
     */
    public function getLangUrl()
    {
        $this->langUrl = $this->getUrl();
        $urlList = explode('/', $this->getUrl());
        $langUrl = isset($urlList[1]) ? $urlList[1] : null;

        if ($langUrl !== null && in_array($langUrl, array_keys(Yii::$app->params['languages']))) {
            $url = preg_replace("/^\/$langUrl/", '', $this->langUrl);
            return $url;
        }
        return $this->langUrl;
    }

    /**
     * Переопределяем метод для того, чтобы он использовал URL без метки языка.
     * Это позволит использовать обычные правила в UrlManager.
     *
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    protected function resolvePathInfo()
    {
        $pathInfo = $this->getLangUrl();

        if (($pos = strpos($pathInfo, '?')) !== false) {
            $pathInfo = substr($pathInfo, 0, $pos);
        }

        $pathInfo = urldecode($pathInfo);

        $scriptUrl = $this->getScriptUrl();
        $baseUrl = $this->getBaseUrl();
        if (strpos($pathInfo, $scriptUrl) === 0) {
            $pathInfo = substr($pathInfo, strlen($scriptUrl));
        } elseif ($baseUrl === '' || strpos($pathInfo, $baseUrl) === 0) {
            $pathInfo = substr($pathInfo, strlen($baseUrl));
        } elseif (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], $scriptUrl) === 0) {
            $pathInfo = substr($_SERVER['PHP_SELF'], strlen($scriptUrl));
        } else {
            throw new InvalidConfigException('Ошибка определения адреса страницы.');
        }

        if (isset($pathInfo[0]) && $pathInfo[0] === '/') {
            $pathInfo = substr($pathInfo, 1);
        }
        return (string)$pathInfo;
    }
}