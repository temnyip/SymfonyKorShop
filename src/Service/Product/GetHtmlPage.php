<?php


namespace App\Service\Product;


use Symfony\Component\HttpClient\CachingHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetHtmlPage
{
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchProductsPageInformation($url)
    {
        $response = $this->client->request(
            'GET', $url
        );
        $content = $response->getContent();
        return $content;
    }
}