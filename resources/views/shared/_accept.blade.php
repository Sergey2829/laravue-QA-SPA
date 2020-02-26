@can('accept', $model)
    <a title="Mark this answer as best answer"
       class="{{ $model->status }} mt-3"
       onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit()"
    >
        <i class="fa fa-check fa-2x"></i>
    </a>
    <form id="accept-answer-{{ $model->id }}" action="{{ route('answers.accept', $model->id) }}" method="POST" style="display: none">
        @csrf
    </form>
@else
    @if ($model->is_best)
        <a title="The questions author marked this answer as best answer"
           class="{{ $model->status }} mt-3"
        >
            <i class="fa fa-check fa-2x"></i>
        </a>
    @endif
@endcan