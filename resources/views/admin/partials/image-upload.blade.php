<div data-upload class="mt-2">
    <input type="file" name="{{ $name ?? 'image' }}" accept="image/*"
        class="block w-full text-[0.8rem] text-olive file:mr-4 file:py-2 file:px-4 file:border file:border-ink/15 file:bg-bg file:font-mono file:text-[0.7rem] file:uppercase file:tracking-[0.15em] hover:file:bg-ink/5">
    @error($name ?? 'image')
        <p class="mt-1 font-mono text-[0.62rem] uppercase tracking-[0.2em] text-coffee">{{ $message }}</p>
    @enderror
    <div data-upload-preview class="mt-2"></div>
</div>
