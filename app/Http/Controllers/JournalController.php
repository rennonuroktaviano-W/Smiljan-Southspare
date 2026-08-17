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
        $article = Article::published()->where('slug', $slug)->firstOrFail();

        return view('journal.show', [
            'article' => $article,
            'previous' => $this->neighbor($slug, -1),
            'next' => $this->neighbor($slug, 1),
        ]);
    }

    private function published(): Collection
    {
        return Article::published()->orderBy('date', 'desc')->orderBy('sort_order')->get();
    }

    private function neighbor(string $slug, int $offset): ?Article
    {
        $current = Article::published()->where('slug', $slug)->first();

        if (! $current) {
            return null;
        }

        $query = Article::published();

        if ($offset === -1) {
            return $query->where('date', '>', $current->date)
                ->orWhere(fn ($q) => $q->where('date', $current->date)->where('sort_order', '>', $current->sort_order))
                ->orderBy('date')
                ->orderBy('sort_order')
                ->first();
        }

        return $query->where('date', '<', $current->date)
            ->orWhere(fn ($q) => $q->where('date', $current->date)->where('sort_order', '<', $current->sort_order))
            ->orderBy('date', 'desc')
            ->orderBy('sort_order', 'desc')
            ->first();
    }
}
