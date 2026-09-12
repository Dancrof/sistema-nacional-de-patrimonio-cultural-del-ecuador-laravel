<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $artwork->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">
    <header class="bg-slate-900 text-white">
        <div class="mx-auto max-w-5xl px-4 py-5">
            <nav class="flex items-center justify-between text-sm text-slate-200">
                <div class="flex items-center gap-4">
                    <a href="{{ route('public.artworks.index') }}" class="font-semibold text-white">Patrimonio</a>
                    <a href="{{ route('public.artworks.index') }}" class="hover:text-white">Catálogo</a>
                </div>
                <a href="{{ route('public.artworks.index') }}" class="rounded-full border border-slate-600 px-3 py-1.5 hover:border-slate-400 hover:text-white">Volver</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-10">
        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <article class="overflow-hidden rounded-3xl bg-white shadow-lg">
            <div class="bg-gradient-to-r from-slate-800 via-sky-700 to-indigo-600 p-8 text-white">
                <p class="text-xs uppercase tracking-[0.25em] text-sky-100">{{ $artwork->category?->name ?? 'Sin categoría' }}</p>
                <h1 class="mt-3 text-3xl font-bold">{{ $artwork->title }}</h1>
                <p class="mt-2 text-sm text-sky-100">{{ $artwork->code }} · {{ $artwork->province?->name }} · {{ $artwork->canton?->name }}</p>
            </div>

            <div class="grid gap-8 p-8 lg:grid-cols-[1.6fr_0.9fr]">
                <div>
                    @if ($artwork->images->isNotEmpty())
                        <div class="mb-8 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <h2 class="text-lg font-semibold text-slate-800">Galería</h2>
                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                @foreach ($artwork->images as $image)
                                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                                        <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->alt_text ?? $image->caption ?? $artwork->title }}" class="h-48 w-full object-cover">
                                        @if ($image->caption)
                                            <p class="px-3 py-2 text-sm text-slate-600">{{ $image->caption }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <p class="text-lg leading-8 text-slate-700">{{ $artwork->description }}</p>

                    @if ($artwork->artists->isNotEmpty())
                        <div class="mt-8">
                            <h2 class="text-lg font-semibold text-slate-800">Artistas</h2>
                            <ul class="mt-3 flex flex-wrap gap-2">
                                @foreach ($artwork->artists as $artist)
                                    <li class="rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-700">{{ $artist->full_name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($artwork->latitude && $artwork->longitude)
                        <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <h2 class="text-lg font-semibold text-slate-800">Ubicación</h2>
                            <div class="mt-3 rounded-xl border border-slate-200 bg-white p-3 text-sm text-slate-700">
                                <p>Latitud: {{ $artwork->latitude }}</p>
                                <p>Longitud: {{ $artwork->longitude }}</p>
                            </div>
                        </div>
                    @endif

                    <section class="mt-10 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                        <h2 class="text-xl font-semibold text-slate-800">Comentarios</h2>

                        @auth
                            <form method="POST" action="{{ route('public.artworks.comments.store', $artwork->slug) }}" class="mt-5 space-y-3">
                                @csrf
                                <textarea name="content" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Escribe tu comentario..."></textarea>
                                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Enviar comentario</button>
                            </form>
                        @else
                            <p class="mt-5 text-sm text-slate-600">Inicia sesión para dejar un comentario.</p>
                        @endauth

                        <div class="mt-6 space-y-4">
                            @forelse ($artwork->comments as $comment)
                                <div class="rounded-xl border border-slate-200 bg-white p-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="font-medium text-slate-800">{{ $comment->user?->name ?? 'Usuario' }}</p>
                                        <span class="text-xs text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mt-2 text-sm leading-6 text-slate-700">{{ $comment->content }}</p>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Aún no hay comentarios para esta obra.</p>
                            @endforelse
                        </div>
                    </section>
                </div>

                <aside class="space-y-4 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Tipo</p>
                        <p class="mt-1 font-medium text-slate-800">{{ $artwork->artworkType?->name ?? 'Sin información' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Estado de conservación</p>
                        <p class="mt-1 font-medium text-slate-800">{{ $artwork->conservationStatus?->name ?? 'Sin información' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Año</p>
                        <p class="mt-1 font-medium text-slate-800">{{ $artwork->creation_year ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Ubicación</p>
                        <p class="mt-1 font-medium text-slate-800">{{ $artwork->province?->name }} / {{ $artwork->canton?->name }} / {{ $artwork->parish?->name ?? 'Sin parroquia' }}</p>
                    </div>
                    <div class="rounded-xl border border-amber-200 bg-amber-50 p-4">
                        <p class="text-xs uppercase tracking-[0.2em] text-amber-700">Valoración</p>
                        <p class="mt-1 text-2xl font-bold text-amber-700">{{ number_format((float) $artwork->average_rating, 1) }}/5</p>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('public.artworks.ratings.store', $artwork->slug) }}" class="space-y-3 rounded-xl border border-slate-200 bg-white p-4">
                            @csrf
                            <label class="block text-sm font-medium text-slate-700">Tu valoración</label>
                            <select name="rating" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} estrella{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                            <textarea name="review" rows="2" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Comentario opcional de la valoración..."></textarea>
                            <button type="submit" class="w-full rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-400">Guardar valoración</button>
                        </form>
                    @else
                        <p class="text-sm text-slate-600">Inicia sesión para valorar esta obra.</p>
                    @endauth
                </aside>
            </div>
        </article>
    </main>
</body>
</html>
