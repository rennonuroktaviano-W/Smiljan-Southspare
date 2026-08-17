<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class JournalController extends Controller
{
    public function index(): View
    {
        return view('journal.index', [
            'articles' => $this->published(),
        ]);
    }

    public function show(string $slug): View
    {
        $articles = $this->published();
        $article = $articles->firstWhere('slug', $slug);

        abort_if(! $article, 404);

        return view('journal.show', [
            'article' => $article,
            'previous' => $this->neighbor($articles, $slug, -1),
            'next' => $this->neighbor($articles, $slug, 1),
        ]);
    }

    private function published(): Collection
    {
        return Article::published()->orderBy('date', 'desc')->orderBy('sort_order')->get();
    }

    private function neighbor(Collection $articles, string $slug, int $offset): ?Article
    {
        $index = $articles->search(fn ($item) => $item['slug'] === $slug);

        return $articles->get($index + $offset);
    }
}
