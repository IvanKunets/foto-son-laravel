@php
    use Illuminate\Support\Facades\Storage;

    $name = trim((string) $review->author_name);
    $parts = preg_split('/\s+/u', $name, -1, PREG_SPLIT_NO_EMPTY);
    if (count($parts) >= 2) {
        $initials = mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1));
    } elseif ($name !== '') {
        $initials = mb_strtoupper(mb_substr($name, 0, 1));
    } else {
        $initials = '?';
    }
    $avatarOk = filled($review->avatar) && Storage::disk('public')->exists($review->avatar);
@endphp
@if ($avatarOk)
    <span class="review-card__avatar review-card__avatar--photo" aria-hidden="true">
        <img
            src="{{ Storage::url($review->avatar) }}"
            alt=""
            class="review-card__avatar-img"
            width="48"
            height="48"
        >
    </span>
@else
    <span class="review-card__avatar" aria-hidden="true">{{ $initials }}</span>
@endif
