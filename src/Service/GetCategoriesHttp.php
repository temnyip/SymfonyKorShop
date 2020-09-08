<?php


namespace App\Service;


class GetCategoriesHttp
{
    public function __construct(HttpCategory $clientExtractorService)
    {
     $this->clientExtractorService = $clientExtractorService;
    }

    public function showCategories()
    {
        $content = $this->clientExtractorService->fetchShopsPageInformation();
        preg_match('~<div class="mainsections clearfix">(.*?)</ul></div></div></div><div class="fancybox-overlay2 fancybox-overlay-fixed2">~is', $content, $a);
        $innerContent = $a[0];

        $rows = preg_split('~<li class="section"~', $innerContent);
        array_shift($rows);
        preg_match_all('~<li class="section"(.*?)<span style="color:#000;">~is', $innerContent, $rows);
        $data = [];
        foreach ($rows[0] as $rowContent) {
            $row = [];
            preg_match('~</a><a class="parent" href=".+" title=".+">(.*?)<span style="color:#000;">~is', $rowContent, $a);
            $row['title'] = $a[1];
            preg_match('~<a class="parent" href="(.*?)" title="~is', $rowContent, $a);
            $row['uri'] = 'https://korshop.ru' . $a[1];
            $data[] = $row;
        }

        return $data;
    }
}