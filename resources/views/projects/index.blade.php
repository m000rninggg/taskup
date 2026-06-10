<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Мои проекты
            </h2>
            <a href="{{ route('projects.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                + Создать проект
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($projects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($projects as $project)
                                <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                    <h3 class="font-bold text-lg mb-2">{{ $project->title }}</h3>
                                    <p class="text-sm text-gray-600 mb-1">Команда: {{ $project->team->name }}</p>
                                    <p class="text-gray-600 text-sm mb-4">
                                        {{ Str::limit($project->description, 100) ?: 'Нет описания' }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500">
                                            Задач: {{ $project->tasks->count() }}
                                        </span>
                                        <a href="{{ route('projects.show', $project) }}" 
                                           class="text-blue-500 hover:text-blue-700 text-sm">
                                            Открыть →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center">Нет проектов. Создайте первый проект!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>