@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-danger']) }}>
        <ul class="mb-0">
            <li class="list-unstyled">{{ $status }}</li>
        </ul>
    </div>
@endif
