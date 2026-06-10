<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">

        <div class="mb-8">

            <h1 class="text-3xl font-bold mb-3">
                {{ $project->title }}
            </h1>

            <p class="text-gray-600">
                {{ $project->description }}
            </p>

        </div>

        <div class="border rounded-2xl p-6 mb-8">

            <h2 class="text-xl font-semibold mb-4">
                Создать задачу
            </h2>

            <form
                action="{{ route('tasks.store', $project) }}"
                method="POST"
            >

                @csrf

                <input
                    type="text"
                    name="title"
                    placeholder="Название задачи"
                    class="w-full border rounded-lg p-3 mb-4"
                >

                <textarea
                    name="description"
                    placeholder="Описание задачи"
                    class="w-full border rounded-lg p-3 mb-4"
                ></textarea>

                <button
                    type="submit"
                    class="bg-black text-white px-5 py-3 rounded-lg"
                >
                    Создать задачу
                </button>

            </form>

        </div>

        <div>

            <h2 class="text-2xl font-bold mb-5">
                Задачи
            </h2>

            <div class="space-y-4">

                @foreach($project->tasks as $task)

                    <div class="border rounded-xl p-5">

                        <div class="flex justify-between items-center mb-3">

                            <h3 class="text-xl font-semibold">
                                {{ $task->title }}
                            </h3>

                            <span class="text-sm border px-3 py-1 rounded-full">
                                {{ $task->status }}
                            </span>

                        </div>

                        <p class="text-gray-600">
                            {{ $task->description }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</x-app-layout>