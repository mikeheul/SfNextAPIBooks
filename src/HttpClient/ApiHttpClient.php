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

    public function addBook(array $data)
    {
        try {
            $response = $this->httpClient->request('POST', 'http://localhost:3000/api/book', [
                'json' => $data,  // Les données du livre
            ]);

            // Vérifier si la requête a réussi
            if ($response->getStatusCode() === 201) {
                return $response->toArray(); // Retourner les données du livre créé
            }

            // Si le code de statut n'est pas 201, on lance une exception
            throw new \Exception('Error adding book to database.');
        } catch (\Exception $e) {
            // Gérer l'exception si la requête échoue (erreur réseau, API hors ligne, etc.)
            throw new \Exception('An error occurred while adding the book. Please try again later.');
        }
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