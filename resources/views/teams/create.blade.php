<x-app-layout>

    <div class="max-w-2xl mx-auto p-6">

        <h1 class="text-2xl font-bold mb-6">
            Создать команду
        </h1>

        <form action="{{ route('teams.store') }}" method="POST">

            @csrf

            <input
                type="text"
                name="name"
                placeholder="Название команды"
                class="w-full border rounded-lg p-3 mb-4"
            >

            <button
                type="submit"
                class="bg-[#282840] text-[#FFFFFF] px-5 py-3 rounded-lg"
            >
                Создать
            </button>

        </form>

    </div>

</x-app-layout>

