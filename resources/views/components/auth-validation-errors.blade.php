@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'alert alert-danger']) }}>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li class="list-unstyled">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
