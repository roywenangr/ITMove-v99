<table class="table">
    <thead>
        <tr>
            <th>Nama Provinsi</th>
            <th>Gambar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($provinces as $province)
            <tr>
                <td>{{ $province->name }}</td>
                <td><img src="{{ $province->imagePath }}" width="100"></td>
            </tr>
        @endforeach
    </tbody>
</table>
