<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;

class ArticleCrudTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.articles.index'));
        $response->assertStatus(200);
    }

    public function test_create_form_returns_200(): void
    {
        $response = $this->actingAs($this->user)->get(route('admin.articles.create'));
        $response->assertStatus(200);
    }

    public function test_store_creates_article(): void
    {
        $data = [
            'category' => 'Cerita',
            'meta' => '5 menit baca',
            'title' => 'Test Article',
            'excerpt' => 'A test excerpt',
            'date' => '2026-01-15',
            'image_src' => '/images/test.webp',
            'image_alt' => 'Test image',
            'content' => "First paragraph\n\nSecond paragraph",
        ];

        $response = $this->actingAs($this->user)->post(route('admin.articles.store'), $data);
        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseHas('articles', ['title' => 'Test Article']);
    }

    public function test_edit_form_returns_200(): void
    {
        $article = Article::factory()->create();
        $response = $this->actingAs($this->user)->get(route('admin.articles.edit', $article));
        $response->assertStatus(200);
    }

    public function test_update_modifies_article(): void
    {
        $article = Article::factory()->create(['title' => 'Original']);

        $response = $this->actingAs($this->user)->put(route('admin.articles.update', $article), [
            'category' => 'Cerita',
            'meta' => '5 menit baca',
            'title' => 'Updated Title',
            'excerpt' => 'Updated excerpt',
            'date' => '2026-01-15',
            'image_src' => '/images/test.webp',
            'image_alt' => 'Test',
            'content' => 'Content',
        ]);

        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseHas('articles', ['id' => $article->id, 'title' => 'Updated Title']);
    }

    public function test_destroy_deletes_article(): void
    {
        $article = Article::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('admin.articles.destroy', $article));
        $response->assertRedirect(route('admin.articles.index'));
        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    public function test_search_filters_by_title(): void
    {
        Article::factory()->create(['title' => 'Coffee Story']);
        Article::factory()->create(['title' => 'Book Review']);

        $response = $this->actingAs($this->user)->get(route('admin.articles.index', ['q' => 'Coffee']));
        $response->assertSee('Coffee Story');
        $response->assertDontSee('Book Review');
    }
}
