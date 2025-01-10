<?php

namespace App\Controller;

use App\HttpClient\ApiHttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    #[Route('/books', name: 'app_books')]
    public function books(ApiHttpClient $apiHttpClient): Response
    {
        $books = $apiHttpClient->getBooks();
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/book/{id}', name: 'app_book_show')]
    public function showBook(string $id, ApiHttpClient $apiHttpClient): Response
    {
        $book = $apiHttpClient->getBook($id);
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
    
    #[Route('/authors', name: 'app_authors')]
    public function authors(ApiHttpClient $apiHttpClient): Response
    {
        $authors = $apiHttpClient->getAuthors();
        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/author/{id}', name: 'app_author_show')]
    public function showAuthor(string $id, ApiHttpClient $apiHttpClient): Response
    {
        $author = $apiHttpClient->getAuthor($id);
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }
}
