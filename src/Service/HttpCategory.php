<?php


namespace App\Service;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpCategory
{
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchShopsPageInformation()
    {
        $response = $this->client->request(
            'GET', 'https://korshop.ru/catalog/'
        );
        $content = $response->getContent();
        return $content;
    }
}