<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">

        @include('projects.partials.nav')

        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-3">
                {{ $project->title }}
            </h1>

            <p class="text-[#C2C2D4]">
                {{ $project->description ?: 'Описание проекта пока не добавлено.' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border rounded-xl p-5">
                <p class="text-sm text-[#8C8CA3] mb-2">Команда</p>
                <p class="text-xl font-semibold">{{ $project->team->name }}</p>
            </div>

            <div class="border rounded-xl p-5">
                <p class="text-sm text-[#8C8CA3] mb-2">Задач</p>
                <p class="text-xl font-semibold">{{ $project->tasks->count() }}</p>
            </div>

            <div class="border rounded-xl p-5">
                <p class="text-sm text-[#8C8CA3] mb-2">Создан</p>
                <p class="text-xl font-semibold">{{ $project->created_at->format('d.m.Y') }}</p>
            </div>
        </div>

    </div>

</x-app-layout>

