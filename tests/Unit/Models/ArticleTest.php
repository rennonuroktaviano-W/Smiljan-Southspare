<?php

namespace Tests\Unit;

use App\Models\Article;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    public function test_published_scope_filters_unpublished(): void
    {
        Article::factory()->create(['published' => true]);
        Article::factory()->draft()->create();

        $published = Article::published()->count();
        $this->assertEquals(1, $published);
    }

    public function test_slug_is_unique(): void
    {
        Article::factory()->create(['slug' => 'unique-slug']);

        $this->expectException(QueryException::class);
        Article::factory()->create(['slug' => 'unique-slug']);
    }

    public function test_content_is_cast_to_array(): void
    {
        $article = Article::factory()->create([
            'content' => [['type' => 'p', 'text' => 'Hello']],
        ]);

        $this->assertIsArray($article->content);
        $this->assertEquals('Hello', $article->content[0]['text']);
    }
}
