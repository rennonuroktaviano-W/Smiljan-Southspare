<?php

namespace Tests\Feature;

use App\Models\Article;
use Tests\TestCase;

class JournalTest extends TestCase
{
    public function test_journal_index_returns_200(): void
    {
        $response = $this->get('/jurnal');
        $response->assertStatus(200);
    }

    public function test_journal_index_shows_published_articles(): void
    {
        $article = Article::factory()->create(['published' => true]);

        $response = $this->get('/jurnal');
        $response->assertSee($article->title);
    }

    public function test_journal_index_hides_draft_articles(): void
    {
        $article = Article::factory()->draft()->create();

        $response = $this->get('/jurnal');
        $response->assertDontSee($article->title);
    }

    public function test_journal_show_returns_200(): void
    {
        $article = Article::factory()->create(['slug' => 'test-article']);

        $response = $this->get('/jurnal/test-article');
        $response->assertStatus(200);
    }

    public function test_journal_show_returns_404_for_draft(): void
    {
        Article::factory()->draft()->create(['slug' => 'draft-article']);

        $response = $this->get('/jurnal/draft-article');
        $response->assertStatus(404);
    }
}
