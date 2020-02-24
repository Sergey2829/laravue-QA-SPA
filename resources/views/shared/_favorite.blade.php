<a title="Click to mark as favorite question (Click again to undo)"
   class="favorite mt-3 {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
   onclick="event.preventDefault(); document.getElementById('favorite-{{ $name }}-{{ $model->id }}').submit()"
>
    <i class="fa fa-star fa-2x"></i>
    <span class="favorites-count">{{ $model->favorites_count }}</span>
    <form id="favorite-question-{{ $model->id }}" action="/questions/{{ $model->id }}/favorites" method="POST" style="display: none">
        @csrf
        @if($model->is_favorited)
            @method('delete')
        @endif
    </form>
</a>
