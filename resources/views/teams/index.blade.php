<x-app-layout>

    <div class="max-w-4xl mx-auto p-6">

        <div class="flex justify-between items-center mb-6">

            <h1 class="text-2xl font-bold">
                Мои команды
            </h1>

            <a
                href="{{ route('teams.create') }}"
                class="bg-[#282840] text-[#FFFFFF] px-4 py-2 rounded-lg"
            >
                Создать команду
            </a>

        </div>

        <div class="space-y-4">

            @foreach($teams as $team)

                <div class="border rounded-xl p-5">

                    <h2 class="text-xl font-semibold mb-3">
                        {{ $team->name }}
                    </h2>

                    <a
                        href="{{ route('projects.index', $team) }}"
                        class="text-[#20E6C3]"
                    >
                        Открыть проекты
                    </a>

                </div>

            @endforeach

        </div>

    </div>

</x-app-layout>

