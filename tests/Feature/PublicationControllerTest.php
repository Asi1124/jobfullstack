<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Publication;

class PublicationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_publications_with_pagination()
    {
        Publication::factory()->count(15)->create();

        $response = $this->getJson('/api/');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta'
            ]);
    }

    /** @test */
    public function it_shows_a_publication_with_specified_fields()
    {
        $publication = Publication::factory()->create();

        $response = $this->getJson('/api/publications/' . $publication->id . '?fields=title,description');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['title', 'description']
            ]);
    }

    /** @test */
    public function it_returns_error_for_nonexistent_publication()
    {
        $response = $this->getJson('/api/publications/999');

        $response->assertStatus(500)
            ->assertJson([
                'error' => 'Ошибка при поиске: No query results for model [App\\Models\\Publication] 999'
            ]);
    }

    /** @test */
    public function it_creates_a_publication_successfully()
    {
        $data = [
            'title' => 'Test Publication',
            'description' => 'This is a test publication.',
            'photos' => ['http://example.com/photo1.jpg', 'http://example.com/photo2.jpg', 'http://example.com/photo3.jpg'],
            'price' => 99.99,
        ];

        $response = $this->postJson('/api/publications', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'status'
            ]);

        $this->assertDatabaseHas('publications', [
            'title' => 'Test Publication',
            'description' => 'This is a test publication.',
            'price' => 99.99,
        ]);
    }

    /** @test */
    public function it_validates_required_fields_for_publication()
    {
        $response = $this->postJson('/api/publications', []);

        $response->assertStatus(422);
    }

    /** @test */
    public function it_returns_error_for_invalid_photo_urls()
    {
        $data = [
            'title' => 'Test Publication',
            'description' => 'This is a test publication.',
            'photos' => ['invalid-url'],
            'price' => 99.99,
        ];

        $response = $this->postJson('/api/publications', $data);

        $response->assertStatus(422);
    }

}

