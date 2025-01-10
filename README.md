# Symfony Web App - Books and Authors

This is a Symfony project that consumes the API from a Next.js application to display books, authors, and details about them. The data is fetched from the Next.js API endpoints and presented in a user-friendly way.

## Tech Stack
- **Symfony**: A PHP framework for building web applications.
- **Twig**: A templating engine used for rendering the views.
- **HTTP Client**: Symfony's HTTP client component to interact with the Next.js API.

## Getting Started

### Prerequisites
1. PHP (v7.4 or later)
2. Composer
3. Symfony CLI (optional)
4. Access to the Next.js API (ensure the API is running)

### Installation

1. Clone the repository:

```bash
git clone https://github.com/yourusername/symfony-books-authors.git
cd symfony-books-authors
```

2. Install the dependencies:

```bash
composer install
```

3. Configure the `.env` file to point to the Next.js API:

```env
NEXTJS_API_URL=http://localhost:3000/api
```

4. Start the Symfony development server:

```bash
symfony server:start
```

The application will now be running on `http://localhost:8000`.

### Controllers and Views

1. **Books Controller**: The controller fetches the list of books from the Next.js API and displays them.
2. **Authors Controller**: The controller fetches the list of authors from the Next.js API and displays them.
3. **Book Details**: Displays detailed information about a specific book by consuming the corresponding API endpoint.
4. **Author Details**: Displays detailed information about a specific author and their books.

### Routes

- `/books` : Displays a list of all books.
- `/authors` : Displays a list of all authors.
- `/book/{id}` : Displays details about a specific book.
- `/author/{id}` : Displays details about a specific author.

## Example of API consumption

The Symfony controllers use the HTTP client to fetch data from the Next.js API.

Example of a book list request:
```php
use Symfony\Contracts\HttpClient\HttpClientInterface;

public function listBooks(HttpClientInterface $client)
{
    $response = $client->request('GET', $_ENV['NEXTJS_API_URL'].'/books');
    $books = $response->toArray();

    return $this->render('books/index.html.twig', [
        'books' => $books,
    ]);
}
```

### Deployment

To deploy the app to production, you can use platforms like Heroku, Symfony Cloud, or any other PHP hosting service.

1. Build the Symfony app for production:

```bash
composer install --no-dev --optimize-autoloader
```

2. Deploy to your preferred platform.

---

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
