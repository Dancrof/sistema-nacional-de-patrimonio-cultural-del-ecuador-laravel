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
                                @foreach ($artwork->images as $index => $image)
                                    <button type="button" class="gallery-trigger overflow-hidden rounded-xl border border-slate-200 bg-white text-left shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow-lg" data-index="{{ $index }}" data-image="{{ Storage::url($image->image_path) }}" data-caption="{{ e($image->caption ?? $artwork->title) }}" aria-label="Ampliar imagen de {{ $artwork->title }}">
                                        <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->alt_text ?? $image->caption ?? $artwork->title }}" class="h-48 w-full object-cover">
                                        @if ($image->caption)
                                            <p class="px-3 py-2 text-sm text-slate-600">{{ $image->caption }}</p>
                                        @endif
                                    </button>
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

                    @if ($artwork->videos->isNotEmpty())
                        <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <h2 class="text-lg font-semibold text-slate-800">Videos</h2>
                            <div class="mt-4 space-y-4">
                                @foreach ($artwork->videos as $video)
                                    @php
                                        $videoUrl = trim((string) ($video->video_url ?? ''));
                                        $videoProvider = strtolower((string) ($video->provider ?? ''));
                                        $videoEmbedUrl = null;

                                        if ($videoProvider === 'youtube' || str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
                                            $videoId = null;
                                            if (preg_match('/(?:v=|vi=)([A-Za-z0-9_-]{11})/', $videoUrl, $matches)) {
                                                $videoId = $matches[1];
                                            } elseif (preg_match('/youtu\.be\/([A-Za-z0-9_-]{11})/', $videoUrl, $matches)) {
                                                $videoId = $matches[1];
                                            }

                                            if ($videoId) {
                                                $videoEmbedUrl = 'https://www.youtube.com/embed/' . $videoId;
                                            }
                                        } elseif ($videoProvider === 'vimeo' || str_contains($videoUrl, 'vimeo.com')) {
                                            $videoId = null;
                                            if (preg_match('/vimeo\.com\/(?:video\/)?([0-9]+)/', $videoUrl, $matches)) {
                                                $videoId = $matches[1];
                                            }

                                            if ($videoId) {
                                                $videoEmbedUrl = 'https://player.vimeo.com/video/' . $videoId;
                                            }
                                        }
                                    @endphp

                                    @if ($videoEmbedUrl)
                                        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
                                            <div class="aspect-video">
                                                <iframe
                                                    src="{{ $videoEmbedUrl }}"
                                                    class="h-full w-full"
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                    allowfullscreen
                                                    loading="lazy"
                                                    referrerpolicy="strict-origin-when-cross-origin"
                                                    title="{{ $video->title ?: 'Video de la obra' }}">
                                                </iframe>
                                            </div>
                                            @if ($video->title)
                                                <p class="px-4 py-3 text-sm text-slate-700">{{ $video->title }}</p>
                                            @endif
                                        </div>
                                    @elseif ($videoUrl)
                                        <div class="rounded-xl border border-slate-200 bg-white p-4">
                                            <p class="text-sm font-medium text-slate-800">{{ $video->title ?: 'Ver video' }}</p>
                                            <a href="{{ $videoUrl }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex text-sm text-indigo-600 hover:text-indigo-500">Abrir video</a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($artwork->latitude && $artwork->longitude)
                        @php
                            $mapLat = (float) $artwork->latitude;
                            $mapLng = (float) $artwork->longitude;
                            $googleMapsEmbedUrl = 'https://www.google.com/maps?q=' . $mapLat . ',' . $mapLng . '&z=14&output=embed';
                        @endphp
                        <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <h2 class="text-lg font-semibold text-slate-800">Ubicación</h2>
                            <div class="mt-3 overflow-hidden rounded-xl border border-slate-200 bg-white">
                                <iframe
                                    src="{{ $googleMapsEmbedUrl }}"
                                    width="100%"
                                    height="280"
                                    style="border:0;"
                                    allowfullscreen=""
                                    loading="lazy"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    title="Ubicación de {{ $artwork->title }}">
                                </iframe>
                            </div>
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

    <div id="gallery-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/80 p-4 backdrop-blur-sm transition-opacity duration-300" aria-hidden="true">
        <div class="relative w-full max-w-5xl overflow-hidden rounded-3xl border border-white/10 bg-white/95 shadow-[0_30px_80px_rgba(15,23,42,0.45)]">
            <button type="button" id="gallery-close" class="absolute right-4 top-4 z-20 flex h-10 w-10 items-center justify-center rounded-full bg-slate-900/70 text-2xl font-light text-white transition hover:scale-105 hover:bg-slate-800" aria-label="Cerrar vista ampliada">
                &times;
            </button>

            <button type="button" id="gallery-prev" class="absolute left-4 top-1/2 z-20 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-slate-900/70 text-2xl text-white transition hover:scale-105 hover:bg-slate-800" aria-label="Imagen anterior">
                &#8592;
            </button>

            <button type="button" id="gallery-next" class="absolute right-4 top-1/2 z-20 flex h-12 w-12 -translate-y-1/2 items-center justify-center rounded-full bg-slate-900/70 text-2xl text-white transition hover:scale-105 hover:bg-slate-800" aria-label="Imagen siguiente">
                &#8594;
            </button>

            <div class="overflow-hidden bg-slate-100">
                <img id="gallery-modal-image" src="" alt="" class="max-h-[78vh] w-full object-contain transition duration-300 ease-out">
            </div>
            <div class="border-t border-slate-200 bg-white px-5 py-3">
                <p id="gallery-modal-caption" class="text-sm text-slate-700"></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('gallery-modal');
            const modalImage = document.getElementById('gallery-modal-image');
            const modalCaption = document.getElementById('gallery-modal-caption');
            const closeButton = document.getElementById('gallery-close');
            const prevButton = document.getElementById('gallery-prev');
            const nextButton = document.getElementById('gallery-next');
            const triggers = Array.from(document.querySelectorAll('.gallery-trigger'));

            if (!modal || !modalImage || !modalCaption || !closeButton || !prevButton || !nextButton) {
                return;
            }

            let currentIndex = 0;

            const openModal = (index) => {
                if (index < 0) index = triggers.length - 1;
                if (index >= triggers.length) index = 0;

                currentIndex = index;
                const trigger = triggers[currentIndex];
                if (!trigger) return;

                const imageSrc = trigger.dataset.image;
                const caption = trigger.dataset.caption || '';

                modalImage.src = imageSrc;
                modalImage.alt = caption || 'Imagen ampliada';
                modalCaption.textContent = caption || '';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.setAttribute('aria-hidden', 'false');
                document.body.classList.add('overflow-hidden');
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modal.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('overflow-hidden');
            };

            triggers.forEach((trigger) => {
                trigger.addEventListener('click', function () {
                    openModal(Number(this.dataset.index || 0));
                });
            });

            closeButton.addEventListener('click', closeModal);
            prevButton.addEventListener('click', () => openModal(currentIndex - 1));
            nextButton.addEventListener('click', () => openModal(currentIndex + 1));

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (modal.classList.contains('hidden')) return;

                if (event.key === 'Escape') {
                    closeModal();
                }

                if (event.key === 'ArrowLeft') {
                    openModal(currentIndex - 1);
                }

                if (event.key === 'ArrowRight') {
                    openModal(currentIndex + 1);
                }
            });
        });
    </script>
</body>
</html>
