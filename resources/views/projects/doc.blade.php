<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">

        @include('projects.partials.nav')

        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-3">
                Документы проекта
            </h1>

            <p class="text-[#C2C2D4]">
                {{ $project->title }}
            </p>
        </div>

        <div class="space-y-4">
            @forelse($project->documents as $document)
                <div class="border rounded-xl p-5">
                    <h2 class="text-xl font-semibold mb-2">{{ $document->title }}</h2>
                    <p class="text-[#C2C2D4] mb-3">{{ $document->content ?: 'Документ пока пуст.' }}</p>
                    <p class="text-sm text-[#8C8CA3]">
                        Обновлено: {{ $document->updated_at->format('d.m.Y H:i') }}
                    </p>
                </div>
            @empty
                <div class="border rounded-xl p-5 text-[#C2C2D4]">
                    Документы пока не добавлены.
                </div>
            @endforelse
        </div>

    </div>

</x-app-layout>

