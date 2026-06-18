<dialog class="task-comments-modal" id="{{ $commentsModalId }}">
    <div class="task-comments-dialog">
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
                action="{{ route('comments.store', $task, absolute: false) }}"
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
