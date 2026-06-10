<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Создать проект
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="team_id" class="block text-sm font-medium text-gray-700">Команда</label>
                            <select name="team_id" id="team_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Выберите команду</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Название проекта</label>
                            <input type="text" name="title" id="title" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                            <textarea name="description" id="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('projects.index') }}" 
                               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                                Отмена
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                                Создать проект
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>