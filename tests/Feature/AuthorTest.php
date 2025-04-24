<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
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

    public function test_puede_obtener_lista_de_autores()
    {
        Author::factory()->count(3)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/v1/authors');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'birthdate', 'nationality']
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
            ->assertJson($authorData);

        $this->assertDatabaseHas('authors', $authorData);
    }

    public function test_validacion_al_crear_autor()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/v1/authors', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'birthdate', 'nationality']);
    }

    public function test_puede_ver_un_autor_especifico()
    {
        $author = Author::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson("/api/v1/authors/{$author->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $author->id,
                    'name' => $author->name
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
            ->assertJson($updateData);

        $this->assertDatabaseHas('authors', $updateData);
    }

    public function test_puede_eliminar_un_autor()
    {
        $author = Author::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/v1/authors/{$author->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}