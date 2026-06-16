<article class="task-card">
    @php
        $creator = $task->creator ?? $task->assignedUser;
        $editModalId = 'edit-task-' . $task->id;
        $menuId = 'task-menu-' . $task->id;
        $commentsModalId = 'task-comments-' . $task->id;
    @endphp

    <div class="task-card-header">
        <h4>
            <span class="task-dot task-dot-{{ $task->status }}"></span>
            {{ $task->title }}
        </h4>

        <div class="task-actions">
            <button
                type="button"
                class="task-edit-btn"
                aria-label="Действия с задачей"
                aria-expanded="false"
                aria-controls="{{ $menuId }}"
                data-task-menu-toggle
            >
                <i class="fa-solid fa-ellipsis"></i>
            </button>

            <div class="task-actions-menu" id="{{ $menuId }}" hidden>
                <button
                    type="button"
                    class="task-menu-item"
                    onclick="document.getElementById('{{ $editModalId }}').showModal()"
                >
                    <i class="fa-regular fa-pen-to-square"></i>
                    <span>Редактировать</span>
                </button>

                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="task-menu-item task-menu-delete"
                        onclick="return confirm('Удалить эту задачу?')"
                    >
                        <i class="fa-regular fa-trash-can"></i>
                        <span>Удалить</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <p class="task-description">
        {{ $task->description ?: 'Описание не добавлено' }}
    </p>

    <div class="task-card-footer">
        <span class="task-author-wrap">
            <span class="task-author">
                {{ mb_substr($creator?->name ?? '?', 0, 1) }}
            </span>
            <span class="task-author-name">
                {{ $creator?->name ?? 'Не указан' }}
            </span>
        </span>

        <button
            type="button"
            class="comments-btn"
            onclick="document.getElementById('{{ $commentsModalId }}').showModal()"
        >
            <i class="fa-regular fa-comment"></i>
            <span>{{ $task->comments->count() }}</span>
        </button>
    </div>

    @if($task->deadline)
        <p class="task-deadline">
            <i class="fa-regular fa-calendar"></i>
            {{ \Illuminate\Support\Carbon::parse($task->deadline)->translatedFormat('j F') }}
        </p>
    @endif

</article>

<dialog class="task-comments-modal" id="{{ $commentsModalId }}">
    <div class="task-comments-dialog">
        <div class="task-comments-close-form">
            <button
                type="button"
                class="task-comments-close"
                aria-label="Закрыть"
                data-dialog-close
                onclick="this.closest('dialog').close()"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <header class="task-comments-header">
            <span class="task-comments-author-avatar">
                {{ mb_substr($creator?->name ?? '?', 0, 1) }}
            </span>
            <div>
                <strong>{{ $creator?->name ?? 'Не указан' }}</strong>
                <span>Автор задачи</span>
            </div>
        </header>

        <section class="task-comments-details">
            <div class="task-comments-title-row">
                <h2>{{ $task->title }}</h2>
                <span class="task-comments-status task-status-{{ $task->status }}">
                    {{ $task->status === 'todo' ? 'Идея' : ($task->status === 'in_progress' ? 'В разработке' : ($task->status === 'testing' ? 'В тесте' : 'Готово')) }}
                </span>
            </div>

            <p>{{ $task->description ?: 'Описание не добавлено' }}</p>

            <div class="task-comments-meta">
                <span>
                    <i class="fa-regular fa-calendar"></i>
                    {{ $task->deadline
                        ? \Illuminate\Support\Carbon::parse($task->deadline)->translatedFormat('j F Y')
                        : 'Срок не указан' }}
                </span>
            </div>
        </section>

        <section class="task-comments-section">
            <h3>Комментарии <span>{{ $task->comments->count() }}</span></h3>

            <form
                action="{{ route('comments.store', $task) }}"
                method="POST"
                class="task-comment-form"
                data-prevent-double-submit
            >
                @csrf
                <textarea
                    name="content"
                    rows="3"
                    maxlength="2000"
                    placeholder="Напишите комментарий..."
                    required
                ></textarea>
                <button type="submit" aria-label="Отправить комментарий" title="Отправить">
                    <i class="fa-regular fa-paper-plane"></i>
                </button>
            </form>

            <div class="task-comments-list">
                @forelse($task->comments->sortBy('created_at') as $comment)
                    <article class="task-comment">
                        <div class="task-comment-head">
                            <span class="task-comment-avatar">
                                {{ mb_substr($comment->user->name, 0, 1) }}
                            </span>
                            <div class="task-comment-content">
                                <div class="task-comment-meta">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <time datetime="{{ $comment->created_at->toIso8601String() }}">
                                        {{ $comment->created_at->format('d.m.Y H:i') }}
                                    </time>
                                </div>
                            </div>
                        </div>
                        <p>{{ $comment->content }}</p>
                    </article>
                @empty
                    <p class="task-comments-empty">Комментариев пока нет.</p>
                @endforelse
            </div>
        </section>
    </div>
</dialog>
