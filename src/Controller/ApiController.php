<?php

namespace App\Controller;

use App\Form\BookType;
use App\HttpClient\ApiHttpClient;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/book/new', name: 'app_book_new')]
    public function new(Request $request, ApiHttpClient $apiHttpClient)
    {
        // Récupérer les auteurs via l'API Next.js
        try {
            $authors = $apiHttpClient->getAuthors();
        } catch (\Exception $e) {
            $this->addFlash('error', 'Error while fetching authors from the API');
            $authors = [];
        }

        // Créer le formulaire
        $form = $this->createForm(BookType::class, null, [
            'authors' => $authors, // Passer la liste des auteurs au formulaire
        ]);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $title = $book['title'];
            $description = $book['description'];
            $publishedDate = $book['publishedDate'];
            $pages = $book['pages'];
            $author = $book['author'];

            $data = [
                'title' => $title,
                'description' => $description,
                'publishedDate' => $publishedDate,
                'pages' => $pages,
                'authorId' => $author,
            ];

             // Envoyer un POST à votre API Next.js
            try {
                $bookData = $apiHttpClient->addBook($data); // Utilisation de la méthode addBook
    
                // Si le livre a été ajouté avec succès
                $this->addFlash('success', 'Book added successfully!');
                return $this->redirectToRoute('app_books'); // Rediriger vers la page de la liste des livres
            } catch (\Exception $e) {
                // Si une erreur se produit lors de l'ajout du livre
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('app_book_new');
            }
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
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
