@extends('layouts.app')
@section('title', 'Документация - TaskUP')

@push('styles')
    @vite('resources/css/documentation.css')
    @vite('resources/css/project-shell.css')
@endpush

@section('content')
    @php
        $documents = $project->documents->values();
        $mainDocuments = $documents->where('category', 'main');
        $extraDocuments = $documents->where('category', 'additional');
    @endphp

    <div class="documentation-page project-shell">
        @include('projects.partials.sidebar')

        <section class="documentation-workspace project-shell-workspace">
            @include('projects.partials.topbar', ['icon' => 'fa-solid fa-file-lines', 'title' => 'Документация'])

            <div class="documentation-content">
                <section class="document-group">
                    <div class="document-group-title">
                        <span><i class="fa-solid fa-bullseye"></i> Основное</span>
                        <span class="group-actions"><i class="fa-solid fa-chevron-down"></i> <i class="fa-solid fa-ellipsis"></i></span>
                    </div>

                    @foreach($mainDocuments as $document)
                        <details class="document-card">
                            <summary>
                                <span># {{ $document->title }}</span>
                                @include('projects.partials.document-actions', ['document' => $document])
                            </summary>
                            <div class="document-body">
                                <time datetime="{{ $document->updated_at->toDateString() }}">
                                    {{ $document->updated_at->format('d.m.y') }}
                                </time>
                                <div class="document-text">
                                    {!! nl2br(e($document->content ?: 'Документ пока не заполнен.')) !!}
                                </div>
                                <div class="document-meta">
                                    <span class="document-author-avatar">
                                        {{ mb_substr($document->updater?->name ?? auth()->user()->name, 0, 1) }}
                                    </span>
                                    <span><strong>Автор:</strong> {{ $document->updater?->name ?? auth()->user()->name }}</span>
                                </div>
                            </div>
                        </details>
                    @endforeach

                    <button type="button" class="add-topic-button" onclick="document.getElementById('create-document-modal').showModal()">
                        <i class="fa-solid fa-plus"></i>
                        <span>Добавить тему</span>
                    </button>
                </section>

                <section class="document-group document-group-extra">
                    <div class="document-group-title">
                        <span><i class="fa-solid fa-flag"></i> Доп. информация</span>
                        <span class="group-actions"><i class="fa-solid fa-chevron-down"></i> <i class="fa-solid fa-ellipsis"></i></span>
                    </div>

                    @foreach($extraDocuments as $document)
                        <details class="document-card">
                            <summary>
                                <span># {{ $document->title }}</span>
                                @include('projects.partials.document-actions', ['document' => $document])
                            </summary>
                            <div class="document-body">
                                <time datetime="{{ $document->updated_at->toDateString() }}">{{ $document->updated_at->format('d.m.y') }}</time>
                                <div class="document-text">{!! nl2br(e($document->content ?: 'Документ пока не заполнен.')) !!}</div>
                                <div class="document-meta">
                                    <span class="document-author-avatar">{{ mb_substr($document->updater?->name ?? auth()->user()->name, 0, 1) }}</span>
                                    <span><strong>Автор:</strong> {{ $document->updater?->name ?? auth()->user()->name }}</span>
                                </div>
                            </div>
                        </details>
                    @endforeach

                    <button type="button" class="add-topic-button" onclick="document.getElementById('create-document-modal').showModal()">
                        <i class="fa-solid fa-plus"></i>
                        <span>Добавить тему</span>
                    </button>
                </section>
            </div>

            <dialog class="document-modal" id="create-document-modal">
                <form
                    class="document-modal-form"
                    action="{{ route('documents.store', $project) }}"
                    method="POST"
                    data-prevent-double-submit
                >
                    @csrf
                    <input type="hidden" name="request_token" value="{{ (string) \Illuminate\Support\Str::uuid() }}">

                    <div class="document-modal-header">
                        <h2>Создать тему</h2>
                        <button
                            type="button"
                            class="document-modal-close"
                            aria-label="Закрыть"
                            onclick="document.getElementById('create-document-modal').close()"
                        >
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <label>
                        <span>Название темы</span>
                        <input type="text" name="title" placeholder="Введите название" required>
                    </label>

                    <label>
                        <span>Категория</span>
                        <select name="category" required>
                            <option value="main">Основное</option>
                            <option value="additional">Дополнительное</option>
                        </select>
                    </label>

                    <label>
                        <span>Описание</span>
                        <textarea name="content" rows="5" placeholder="Добавьте описание темы"></textarea>
                    </label>

                    <div class="document-modal-actions">
                        <button
                            type="button"
                            class="document-modal-cancel"
                            onclick="document.getElementById('create-document-modal').close()"
                        >
                            Отмена
                        </button>
                        <button type="submit" class="document-modal-submit">Создать</button>
                    </div>
                </form>
            </dialog>

            @foreach($documents as $document)
                @include('projects.partials.edit-document-modal', ['document' => $document])
            @endforeach
        </section>
    </div>
@endsection
