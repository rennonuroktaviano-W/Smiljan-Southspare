<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class SiteSettingController extends Controller
{
    public function index(): View
    {
        $sections = SiteSetting::allSections();

        $data = collect($sections)->mapWithKeys(function ($meta, $key) {
            $setting = SiteSetting::where('section', $key)->first();

            return [$key => array_merge($meta, [
                'exists' => $setting !== null,
                'updated' => $setting?->updated_at?->diffForHumans(),
            ])];
        });

        return view('admin.settings.index', ['sections' => $data]);
    }

    public function edit(string $section): View
    {
        $sections = SiteSetting::allSections();

        if (! isset($sections[$section])) {
            abort(404);
        }

        $setting = SiteSetting::where('section', $section)->first();
        $value = $setting?->value ?? config("site.{$section}", []);

        return view('admin.settings.edit', [
            'section' => $section,
            'meta' => $sections[$section],
            'value' => $value,
        ]);
    }

    public function update(Request $request, string $section): RedirectResponse
    {
        $sections = SiteSetting::allSections();

        if (! isset($sections[$section])) {
            abort(404);
        }

        $value = $this->validated($request, $section);

        SiteSetting::set($section, $value);

        activity()
            ->event('settings_updated')
            ->withProperties(['section' => $section])
            ->log('Pengaturan "'.$sections[$section]['label'].'" diperbarui');

        return redirect()->route('admin.settings.edit', $section)
            ->with('ok', 'Pengaturan "'.$sections[$section]['label'].'" berhasil disimpan.');
    }

    private function validated(Request $request, string $section): array
    {
        $rules = match ($section) {
            'brand' => [
                'name' => ['required', 'string', 'max:100'],
                'sub' => ['required', 'string', 'max:100'],
                'area' => ['required', 'string', 'max:100'],
                'coords' => ['required', 'string', 'max:100'],
                'manifesto' => ['required', 'string', 'max:200'],
            ],
            'address' => [
                'lines' => ['required', 'array', 'min:1', 'max:5'],
                'lines.*' => ['required', 'string', 'max:200'],
                'maps_url' => ['required', 'url', 'max:500'],
            ],
            'hours' => [
                'open' => ['required', 'string', 'max:10'],
                'close' => ['required', 'string', 'max:10'],
                'timezone' => ['required', 'string', 'max:50'],
            ],
            'social' => [
                'instagram' => ['nullable', 'url', 'max:500'],
                'maps' => ['nullable', 'url', 'max:500'],
                'contact' => ['nullable', 'string', 'max:500'],
            ],
            'nav' => [
                'items' => ['required', 'array', 'min:1', 'max:10'],
                'items.*.label' => ['required', 'string', 'max:50'],
                'items.*.href' => ['required', 'string', 'max:200'],
            ],
            'hero' => [
                'eyebrow' => ['required', 'string', 'max:200'],
                'label' => ['required', 'string', 'max:200'],
                'lines' => ['required', 'array', 'min:1', 'max:6'],
                'lines.*' => ['required', 'string', 'max:100'],
                'copy' => ['required', 'string', 'max:500'],
                'scroll' => ['required', 'string', 'max:200'],
                'image.src' => ['required', 'string', 'max:255'],
                'image.alt' => ['required', 'string', 'max:200'],
                'mono' => ['required', 'string', 'max:100'],
            ],
            'manifesto' => [
                'index' => ['required', 'string', 'max:10'],
                'label' => ['required', 'string', 'max:100'],
                'en' => ['required', 'string', 'max:100'],
                'title' => ['required', 'array', 'min:1', 'max:5'],
                'title.*' => ['required', 'string', 'max:100'],
                'copy' => ['required', 'string', 'max:500'],
                'accent.id' => ['required', 'string', 'max:200'],
                'accent.en' => ['required', 'string', 'max:200'],
            ],
            'space' => [
                'index' => ['required', 'string', 'max:10'],
                'label' => ['required', 'string', 'max:100'],
                'en' => ['required', 'string', 'max:100'],
                'title' => ['required', 'array', 'min:1', 'max:5'],
                'title.*' => ['required', 'string', 'max:100'],
                'copy' => ['required', 'string', 'max:500'],
                'items' => ['required', 'array', 'min:1', 'max:10'],
                'items.*.n' => ['required', 'string', 'max:10'],
                'items.*.caption' => ['required', 'string', 'max:100'],
                'items.*.en' => ['required', 'string', 'max:100'],
                'items.*.src' => ['required', 'string', 'max:255'],
                'items.*.alt' => ['required', 'string', 'max:200'],
            ],
            'coffee' => [
                'index' => ['required', 'string', 'max:10'],
                'label' => ['required', 'string', 'max:100'],
                'en' => ['required', 'string', 'max:100'],
                'title' => ['required', 'array', 'min:1', 'max:5'],
                'title.*' => ['required', 'string', 'max:100'],
                'copy' => ['required', 'string', 'max:500'],
                'image.src' => ['required', 'string', 'max:255'],
                'image.alt' => ['required', 'string', 'max:200'],
            ],
            'coffee_philosophy' => [
                'quote' => ['required', 'string', 'max:300'],
                'sub' => ['required', 'string', 'max:300'],
                'mono' => ['required', 'string', 'max:100'],
                'image.src' => ['required', 'string', 'max:255'],
                'image.alt' => ['required', 'string', 'max:200'],
            ],
            'books' => [
                'index' => ['required', 'string', 'max:10'],
                'label' => ['required', 'string', 'max:100'],
                'en' => ['required', 'string', 'max:100'],
                'title' => ['required', 'array', 'min:1', 'max:5'],
                'title.*' => ['required', 'string', 'max:100'],
                'copy' => ['required', 'string', 'max:500'],
                'image.src' => ['required', 'string', 'max:255'],
                'image.alt' => ['required', 'string', 'max:200'],
                'marquee' => ['required', 'array', 'min:1', 'max:20'],
                'marquee.*' => ['required', 'string', 'max:50'],
            ],
            'community' => [
                'index' => ['required', 'string', 'max:10'],
                'label' => ['required', 'string', 'max:100'],
                'en' => ['required', 'string', 'max:100'],
                'title' => ['required', 'array', 'min:1', 'max:5'],
                'title.*' => ['required', 'string', 'max:100'],
                'copy' => ['required', 'string', 'max:500'],
                'image.src' => ['required', 'string', 'max:255'],
                'image.alt' => ['required', 'string', 'max:200'],
            ],
            'journal' => [
                'index' => ['required', 'string', 'max:10'],
                'label' => ['required', 'string', 'max:100'],
                'en' => ['required', 'string', 'max:100'],
                'title' => ['required', 'array', 'min:1', 'max:5'],
                'title.*' => ['required', 'string', 'max:100'],
            ],
            'quote' => [
                'en' => ['required', 'string', 'max:300'],
                'lines' => ['required', 'array', 'min:1', 'max:10'],
                'lines.*.text' => ['required', 'string', 'max:200'],
                'lines.*.italic' => ['required', 'boolean'],
            ],
            'visit' => [
                'index' => ['required', 'string', 'max:10'],
                'label' => ['required', 'string', 'max:100'],
                'en' => ['required', 'string', 'max:100'],
                'title' => ['required', 'array', 'min:1', 'max:5'],
                'title.*' => ['required', 'string', 'max:100'],
                'copy' => ['required', 'string', 'max:500'],
                'hours_label' => ['required', 'string', 'max:200'],
                'cta' => ['required', 'string', 'max:200'],
                'transport' => ['required', 'string', 'max:200'],
                'image.src' => ['required', 'string', 'max:255'],
                'image.alt' => ['required', 'string', 'max:200'],
            ],
            'about' => [
                'index' => ['required', 'string', 'max:10'],
                'label' => ['required', 'string', 'max:100'],
                'en' => ['required', 'string', 'max:100'],
                'title' => ['required', 'array', 'min:1', 'max:5'],
                'title.*' => ['required', 'string', 'max:100'],
                'copy' => ['required', 'string', 'max:1000'],
                'story.label' => ['required', 'string', 'max:200'],
                'story.copy' => ['required', 'string', 'max:1000'],
                'story.points' => ['required', 'array', 'min:1', 'max:10'],
                'story.points.*' => ['required', 'string', 'max:300'],
                'values' => ['required', 'array', 'min:1', 'max:10'],
                'values.*.n' => ['required', 'string', 'max:10'],
                'values.*.name' => ['required', 'string', 'max:100'],
                'values.*.copy' => ['required', 'string', 'max:300'],
                'image.src' => ['required', 'string', 'max:255'],
                'image.alt' => ['required', 'string', 'max:200'],
            ],
            'contact' => [
                'index' => ['required', 'string', 'max:10'],
                'label' => ['required', 'string', 'max:100'],
                'en' => ['required', 'string', 'max:100'],
                'title' => ['required', 'array', 'min:1', 'max:5'],
                'title.*' => ['required', 'string', 'max:100'],
                'copy' => ['required', 'string', 'max:500'],
                'items' => ['required', 'array', 'min:1', 'max:10'],
                'items.*.label' => ['required', 'string', 'max:50'],
                'items.*.value' => ['required', 'string', 'max:200'],
                'items.*.href' => ['required', 'string', 'max:500'],
                'note' => ['required', 'string', 'max:300'],
            ],
            'footer' => [
                'tagline' => ['required', 'string', 'max:200'],
                'links' => ['required', 'array', 'min:1', 'max:10'],
                'links.*.label' => ['required', 'string', 'max:50'],
                'links.*.href' => ['required', 'string', 'max:500'],
            ],
            'status' => [
                'open_now' => ['required', 'string', 'max:50'],
                'closed' => ['required', 'string', 'max:50'],
                'opens_at' => ['required', 'string', 'max:50'],
            ],
            default => [],
        };

        return $request->validate($rules);
    }
}
