<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">

        @include('projects.partials.nav')

        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-3">
                Аналитика проекта
            </h1>

            <p class="text-[#C2C2D4]">
                {{ $project->title }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="border rounded-xl p-5">
                <p class="text-sm text-[#8C8CA3] mb-2">Всего задач</p>
                <p class="text-2xl font-bold">{{ $project->tasks->count() }}</p>
            </div>

            <div class="border rounded-xl p-5">
                <p class="text-sm text-[#8C8CA3] mb-2">В работе</p>
                <p class="text-2xl font-bold">{{ $project->tasks->where('status', 'in_progress')->count() }}</p>
            </div>

            <div class="border rounded-xl p-5">
                <p class="text-sm text-[#8C8CA3] mb-2">Завершено</p>
                <p class="text-2xl font-bold">{{ $project->tasks->where('status', 'done')->count() }}</p>
            </div>
        </div>

    </div>

</x-app-layout>

