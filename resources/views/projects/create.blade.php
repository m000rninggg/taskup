<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#FFFFFF] leading-tight">
            Создать проект
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#242236] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-[#FFFFFF]">
                    <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="team_id" class="block text-sm font-medium text-[#C2C2D4]">Команда</label>
                            <select name="team_id" id="team_id" required
                                    class="mt-1 block w-full rounded-md border-[#2D2B3E] shadow-sm focus:border-[#20E6C3] focus:ring-[#20E6C3]">
                                <option value="">Выберите команду</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="title" class="block text-sm font-medium text-[#C2C2D4]">Название проекта</label>
                            <input type="text" name="title" id="title" required
                                   class="mt-1 block w-full rounded-md border-[#2D2B3E] shadow-sm focus:border-[#20E6C3] focus:ring-[#20E6C3]">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-[#C2C2D4]">Описание</label>
                            <textarea name="description" id="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-[#2D2B3E] shadow-sm focus:border-[#20E6C3] focus:ring-[#20E6C3]"></textarea>
                        </div>

                        <div class="flex justify-end gap-2">
                            <a href="{{ route('projects.index') }}" 
                               class="bg-[#282840] text-[#FFFFFF] px-4 py-2 rounded-md hover:bg-[#339989]">
                                Отмена
                            </a>
                            <button type="submit" 
                                    class="bg-[#282840] text-[#FFFFFF] px-4 py-2 rounded-md hover:bg-[#339989]">
                                Создать проект
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

