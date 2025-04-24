<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    public function test_puede_obtener_lista_de_libros()
    {
        Book::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/v1/books');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'isbn', 'published_date', 'author_id']
                ]
            ]);
    }

    public function test_puede_crear_un_autor()
    {
        $authorData = [
            'name' => 'J.K. Rowling',
            'birthdate' => '1965-07-31',
            'nationality' => 'British'
        ];
    
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/v1/authors', $authorData);
    
        $response->assertStatus(201)
            ->assertJsonFragment($authorData); // Cambiado a assertJsonFragment
    
        $this->assertDatabaseHas('authors', $authorData);
    }
    

    public function test_validacion_al_crear_libro()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/v1/books', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'isbn', 'published_date', 'author_id']);
    }

    public function test_isbn_debe_ser_unico()
    {
        $book = Book::factory()->create();
        $author = Author::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/v1/books', [
            'title' => 'Nuevo Libro',
            'isbn' => $book->isbn,
            'published_date' => '2023-01-01',
            'author_id' => $author->id
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['isbn']);
    }

    public function test_puede_ver_un_libro_especifico()
    {
        $book = Book::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/v1/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $book->id,
                    'title' => $book->title
                ]
            ]);
    }

    public function test_puede_actualizar_un_autor()
    {
        $author = Author::factory()->create();
        $updateData = ['name' => 'Nombre Actualizado'];
    
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/v1/authors/{$author->id}", $updateData);
    
        $response->assertStatus(200)
            ->assertJsonFragment($updateData); // Cambiado a assertJsonFragment
    
        $this->assertDatabaseHas('authors', $updateData);
    }

    public function test_libro_tiene_autor()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id]);
    
        $this->assertInstanceOf(Author::class, $book->author);
        $this->assertEquals($author->id, $book->author->id);
    }

    public function test_puede_eliminar_un_libro()
    {
        $book = Book::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/v1/books/{$book->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}