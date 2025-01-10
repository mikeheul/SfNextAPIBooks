<?php

namespace App\HttpClient;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiHttpClient extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpc)
    {
        $this->httpClient = $httpc;
    }

    public function getBooks()
    {
        $response = $this->httpClient->request('GET', "/api/book", [
            'verify_peer' => false
        ]);

        return $response->toArray();
    }

    public function getBook(string $id)
    {
        $response = $this->httpClient->request('GET', "/api/book/$id", [
            'verify_peer' => false
        ]);

        return $response->toArray();
    }
    
    public function getAuthors()
    {
        $response = $this->httpClient->request('GET', "/api/author", [
            'verify_peer' => false
        ]);
        
        return $response->toArray();
    }

    public function getAuthor(string $id)
    {
        $response = $this->httpClient->request('GET', "/api/author/$id", [
            'verify_peer' => false
        ]);

        return $response->toArray();
    }
}