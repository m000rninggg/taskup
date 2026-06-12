@extends('layouts.app')
@section('title', 'Проекты - TaskUP')

@push('styles')
    @vite('resources/css/dashboard.css')
@endpush

@section('content')

<img src="{{ asset('images/background_img.png') }}" class="bg-img dashboard-bg-img" alt="">

<div class="container dashboard-container">
    <section>
        <h3>Ваши проекты ({{ $projects->count() }}):</h3>
        <div class="project-grid">

            @forelse($projects as $project)
                <div class="project-block">
                    <h4>{{ $project->title }}</h4>
                    <p>{{ \Illuminate\Support\Str::limit($project->description, 300) ?: 'Нет описания' }}</p>
                    <p class="project-meta">Команда: {{ $project->team->name }} | Задач: {{ $project->tasks->count() }}</p>
                </div>
                <div class="tools-bar">
                    <a class="tool-look" href="{{ route('projects.tasks', $project) }}">
                        <img src="{{ asset('images/look.svg') }}" alt="icon">
                        <p>Просмотреть</p>
                    </a>
                    <a class="tool-edit" href="{{ route('projects.tasks', $project) }}">
                        <img src="{{ asset('images/edit.svg') }}" alt="icon">
                        <p>Редактировать</p>
                    </a>
                    <div class="tool-delete">
                        <img src="{{ asset('images/delete.svg') }}" alt="icon">
                    </div>
                </div>
            @empty
                <div class="project-block">
                    <h4>Проекты не найдены</h4>
                    <p>Создайте первый проект или попросите добавить вас в команду, к которой он привязан.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection

