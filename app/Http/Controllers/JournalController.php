<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class JournalController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $articles = collect(config('site.journal.articles'));

        return view('journal.index', ['articles' => $articles]);
    }

    public function show(string $slug): \Illuminate\Contracts\View\View
    {
        $articles = collect(config('site.journal.articles'));
        $article = $articles->firstWhere('slug', $slug);

        abort_if(! $article, 404);

        return view('journal.show', [
            'article' => $article,
            'previous' => $this->neighbor($articles, $slug, -1),
            'next' => $this->neighbor($articles, $slug, 1),
        ]);
    }

    private function neighbor(Collection $articles, string $slug, int $offset): ?array
    {
        $index = $articles->search(fn ($item) => $item['slug'] === $slug);

        return $articles->get($index + $offset);
    }
}
