<?php


namespace App\Service\Product;


use DateTime;

class BuildingArrayProducts
{
    /**
     * @var GetHtmlPage
     */
    private $getHtmlPage;

    public function __construct(GetHtmlPage $getHtmlPage)
    {

        $this->getHtmlPage = $getHtmlPage;
    }

    public function parserKorShopPage($url)
    {
        $content = $this->getHtmlPage->fetchProductsPageInformation($url);
        preg_match('~<div class="showcase clearfix" id="showcaseview">(.*?)<div class="ajaxpages showcase">~is', $content, $a);
        $innerContent = $a[0];
        $rows = preg_split('~<div class="js-element~', $innerContent);
        array_shift($rows);
        preg_match_all('~<div class="js-element.*?</i>В избранное</a></div></div></div></div>~is', $innerContent, $rows);

        $data = [];
        foreach ($rows[0] as $rowContent) {
            $row = [];
            preg_match('~<div class="name"><a href=".+" title=".+">(.*?)</a></div>\s*<div class="sku">~is', $rowContent, $a);
            $row['title'] = $a[1];
            preg_match('~<span class="price gen price_pdv_BASE">(.*?).</span>~is', $rowContent, $a);
            $row['price'] = $a[1];
            preg_match('~<img class="js_picture_glass" data-src=".+" src="(.*?)" alt=".+" title=".+" /><div class="glass_lupa">~is', $rowContent, $a);
            $row['images'] = 'https://korshop.ru' . $a[1];
            preg_match('~<div class="name"><a href="(.*?)"~is', $rowContent, $a);
            $row['url'] = 'https://korshop.ru' . $a[1];
// берем данные из карточки
            $cardContent = $this->getHtmlPage->fetchProductsPageInformation($row['url']);

            if (preg_match('~<div class="exp_date">\s*<b>Срок годности:</b>\s*(.*?)\s*</div>\s*<div class="previewtext" itemprop="description">~is', $cardContent, $a)) {
                $endsDate = $a[1];
                if ($date = DateTime::createFromFormat('d.m.Y', $endsDate)) {
                    $transformDate = $date->format('Y-m-d');
                    $row['endsDate'] = $transformDate;
                } else {
                    $row['endsDate'] = '-';
                }
            } else {
                $row['endsDate'] = '-';
            }
            if (preg_match('~<div class="previewtext" itemprop="description"><p>\s*(.*?)\s*</p>~is', $cardContent, $a)) {
                $row['description'] = $a[1];
            } else {
                $row['description'] = 'Описание отсутствует';
            }
            $data[] = $row;
        }
        return $data;
    }

}