<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(): View
    {
        return view('admin.articles.index', [
            'articles' => Article::orderBy('date', 'desc')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.form', ['article' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        Article::create($this->validated($request));

        return redirect()->route('admin.articles.index')->with('ok', 'Artikel ditambahkan.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.form', ['article' => $article]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $article->update($this->validated($request));

        return redirect()->route('admin.articles.index')->with('ok', 'Artikel diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('ok', 'Artikel dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'max:60'],
            'meta' => ['required', 'string', 'max:60'],
            'title' => ['required', 'string', 'max:160'],
            'slug' => ['nullable', 'string', 'max:200', 'alpha_dash'],
            'excerpt' => ['required', 'string', 'max:500'],
            'date' => ['required', 'date'],
            'image_src' => ['required', 'string', 'max:255'],
            'image_alt' => ['required', 'string', 'max:160'],
            'content' => ['required', 'string'],
            'published' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = ($data['slug'] ?? null) ?: Str::slug($data['title']);
        $data['content'] = $this->textToBlocks($data['content']);
        $data['published'] = $request->boolean('published');

        return $data;
    }

    private function textToBlocks(string $text): array
    {
        return collect(explode("\n", $text))
            ->map(fn ($line) => trim($line))
            ->filter(fn ($line) => $line !== '')
            ->map(function (string $line): array {
                if (str_starts_with($line, '> ')) {
                    return ['type' => 'q', 'text' => mb_substr($line, 2)];
                }

                return ['type' => 'p', 'text' => $line];
            })
            ->values()
            ->all();
    }

    public static function blocksToText(array $content): string
    {
        return collect($content)->map(function ($block) {
            return $block['type'] === 'q' ? '> '.$block['text'] : $block['text'];
        })->implode("\n");
    }
}
