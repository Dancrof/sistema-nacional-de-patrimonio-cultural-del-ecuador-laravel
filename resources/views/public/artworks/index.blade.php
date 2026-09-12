<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patrimonio cultural</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-800">
    <header class="bg-slate-900 text-white shadow">
        <div class="mx-auto max-w-6xl px-4 py-4">
            <nav class="mb-4 flex items-center justify-between text-sm text-slate-200">
                <div class="flex items-center gap-3">
                    <a href="{{ route('public.artworks.index') }}" class="font-semibold text-white">Patrimonio</a>
                    <a href="{{ route('public.artworks.index') }}" class="hover:text-white">Catálogo</a>
                </div>
                <a href="{{ route('login') ?? '/' }}" class="rounded-full border border-slate-600 px-3 py-1.5 hover:border-slate-400 hover:text-white">Acceso</a>
            </nav>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.25em] text-slate-300">Patrimonio ecuatoriano</p>
                    <h1 class="text-2xl font-bold">Catálogo de obras</h1>
                </div>
                <form method="GET" action="{{ route('public.artworks.index') }}" class="flex w-full max-w-lg gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título, artista o código" class="w-full rounded-lg border border-slate-600 bg-slate-800 px-4 py-2 text-white placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white hover:bg-indigo-500">Buscar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-10">
        <form method="GET" action="{{ route('public.artworks.index') }}" class="mb-8 grid gap-3 rounded-2xl border border-slate-200 bg-white p-4 md:grid-cols-5">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <select name="province_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Provincia</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" @selected((string) request('province_id') === (string) $province->id)>{{ $province->name }}</option>
                @endforeach
            </select>
            <select name="category_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="artwork_type_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Tipo</option>
                @foreach ($artworkTypes as $type)
                    <option value="{{ $type->id }}" @selected((string) request('artwork_type_id') === (string) $type->id)>{{ $type->name }}</option>
                @endforeach
            </select>
            <select name="conservation_status_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Estado</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}" @selected((string) request('conservation_status_id') === (string) $status->id)>{{ $status->name }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Filtrar</button>
                <a href="{{ route('public.artworks.index') }}" class="flex items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">Limpiar</a>
            </div>
        </form>

        @if ($artworks->count() === 0)
            <div class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center">
                <p class="text-lg font-medium text-slate-600">No se encontraron obras con los criterios actuales.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($artworks as $artwork)
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="bg-gradient-to-r from-indigo-500 via-sky-500 to-cyan-400 p-5 text-white">
                            <p class="text-xs uppercase tracking-[0.2em] text-indigo-100">{{ $artwork->category?->name ?? 'Sin categoría' }}</p>
                            <h2 class="mt-2 text-xl font-bold">{{ $artwork->title }}</h2>
                        </div>
                        <div class="space-y-3 p-5">
                            <p class="text-sm text-slate-600">{{ $artwork->short_description ?: Str::limit($artwork->description, 120) }}</p>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <span class="rounded-full bg-slate-200 px-2 py-1">{{ $artwork->province?->name ?? 'Sin provincia' }}</span>
                                <span class="rounded-full bg-slate-200 px-2 py-1">{{ $artwork->artworkType?->name ?? 'Sin tipo' }}</span>
                            </div>
                            <div class="flex items-center justify-between border-t border-slate-200 pt-3 text-sm text-slate-500">
                                <span>{{ $artwork->code }}</span>
                                <a href="{{ route('public.artworks.show', $artwork->slug) }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Ver detalle</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $artworks->links() }}
            </div>
        @endif
    </main>
</body>
</html>
