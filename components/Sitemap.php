<?php


namespace app\components;

use app\models\Fingering;
use app\models\Tone;

class Sitemap
{
    public $sitemapsFiles = [];

    public function generate()
    {
        $this->createSitemapWithCommonUrls();
        $this->createSitemapWithChordUrls();
        $this->createSitemapWithSitemaps();
    }

    /**
     * Создает sitemap со ссылками на все sitemap
     */
    public function createSitemapWithSitemaps()
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        $sitemapIndex = $dom->createElement("sitemapindex");
        $sitemapIndexAttribute = $dom->createAttribute('xmlns');
        $sitemapIndexAttribute->value = 'http://www.sitemaps.org/schemas/sitemap/0.9';
        $sitemapIndex->appendChild($sitemapIndexAttribute);

        if(!empty($this->sitemapsFiles)) {
            foreach ($this->sitemapsFiles as $sitemapFile) {
                $sitemap = $dom->createElement('sitemap');
                $loc = $dom->createElement('loc', \Yii::$app->urlManager->createAbsoluteUrl(['/' . $sitemapFile]));
                $lastMod = $dom->createElement('lastmod', $this->getModified(time()));
                $sitemap->appendChild($loc);
                $sitemap->appendChild($lastMod);
                $sitemapIndex->appendChild($sitemap);
            }
        }

        $dom->appendChild($sitemapIndex);
        file_put_contents(\Yii::getAlias('@webroot') . '/sitemap.xml', $dom->saveXML());
    }

    /**
     * Создает sitemap с общими ссылками
     */
    public function createSitemapWithCommonUrls()
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $urlSetAttribute = $dom->createAttribute('xmlns');
        $urlSetAttribute->value = 'http://www.sitemaps.org/schemas/sitemap/0.9';
        $urlSet = $dom->createElement("urlset");
        foreach (['en', 'ru'] as $lang) {
            \Yii::$app->language = $lang;
            $urlSet->appendChild($urlSetAttribute);
            $urlSet->appendChild($this->getChild($dom, \Yii::$app->urlManager->createAbsoluteUrl(['/']), time()));
            $urlSet->appendChild($this->getChild($dom, \Yii::$app->urlManager->createAbsoluteUrl(['/chords']), time()));
        }
        $dom->appendChild($urlSet);
        $sitemap = "sitemap-common.xml";
        $this->sitemapsFiles[] = $sitemap;
        file_put_contents(\Yii::getAlias('@webroot') . '/' . $sitemap, $dom->saveXML());
    }

    /**
     * Создает файлы sitemap со ссылками на аккорды
     *
     * @return bool
     */
    public function createSitemapWithChordUrls()
    {
        $tones = Tone::getTones();
        foreach (['en', 'ru'] as $lang) {
            \Yii::$app->language = $lang;
            foreach ($tones as $tone) {
                $dom = new \DOMDocument('1.0', 'utf-8');
                $dom->preserveWhiteSpace = false;
                $dom->formatOutput = true;

                $urlSet = $dom->createElement("urlset");
                $urlSetAttribute = $dom->createAttribute('xmlns');
                $urlSetAttribute->value = 'http://www.sitemaps.org/schemas/sitemap/0.9';
                $urlSet->appendChild($urlSetAttribute);

                $fingerings = Fingering::find()->where(['tone_id' => $tone->id])->asArray()->all();
                foreach ($fingerings as $fingering) {
                    $url = \Yii::$app->urlManager->createAbsoluteUrl(['site/chord', 'id' => $fingering['id']]);
                    $urlSet->appendChild($this->getChild($dom, $url, time()));
                }
                $dom->appendChild($urlSet);
                $chordName = strtolower(str_replace('#', '_sharp', $tone->name));
                $sitemap = "sitemap-" . $chordName . "_" . $lang . ".xml";
                $this->sitemapsFiles[] = $sitemap;
                file_put_contents(\Yii::getAlias('@webroot') . '/' . $sitemap, $dom->saveXML());
            }
        }
    }

    /**
     * @param \DOMDocument $dom
     * @param string $link
     * @param string $modified
     * @return \DOMElement
     */
    protected function getChild(\DOMDocument $dom, $link, $modified)
    {
        $url = $dom->createElement('url');
        $loc = $dom->createElement('loc', $link);

        $url->appendChild($loc);
        $lastMod = $dom->createElement('lastmod', $this->getModified($modified));
        $url->appendChild($lastMod);

        $freq = $dom->createElement('changefreq', 'weekly');
        $url->appendChild($freq);

        return $url;
    }

    /**
     * @param string $modified
     * @return false|string
     */
    protected function getModified($modified)
    {
        return !empty($modified) ? date('Y-m-d', $modified) : date('Y-m-d', time());
    }
}