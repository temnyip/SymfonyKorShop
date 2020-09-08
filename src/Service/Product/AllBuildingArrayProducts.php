<?php


namespace App\Service\Product;


class AllBuildingArrayProducts
{
    /**
     * @var BuildingArrayProducts
     */
    private $buildingArrayProducts;

    public function __construct(BuildingArrayProducts $buildingArrayProducts)
    {
        $this->buildingArrayProducts = $buildingArrayProducts;
    }

    public function getAllProducts($url, $fromPage = 1, $maxPage = false)
    {
        $dataAll = [];
        $page = $fromPage;
        while (true) {
            if ($page == 1) {
                $urlCurrent = $url;
            } else {
                if (strpos($url, '?')) {
                    $urlCurrent = str_replace('?', '?PAGEN 2=' . $page . '&', $url);
                } else {
                    $urlCurrent = $url . '?PAGEN 2=' . $page;
                }
            }
            $data = $this->buildingArrayProducts->parserKorShopPage($url);
            if (!count($data)) {
                break;
            }
            $dataAll = array_merge($dataAll, $data);
            if ($maxPage && $page == $maxPage) {
                break;
            }
            $page++;
        }
        return $dataAll;
    }
}