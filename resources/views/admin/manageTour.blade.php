@extends('layout/template')

@section('title','Management Tour')
@section('border', 'border-bottom')

@section('logo', '#3DA43A')
@section('cart', 'black')
@section('profile', 'black')
@section('login', 'text-black')
@section('register', 'text-black')
@section('navHome', 'text-black')
@section('navTour', 'text-black')
@section('navReq', 'text-black')
@section('navGuide', 'text-black')
@section('navAbout', 'text-black')
@section('add', 'black')

@section('content')
<style>
    .form-floating>label {
        font-size: 0.85em;
        /* Sesuaikan ukuran font */
        position: absolute;
        top: -5px;
        /* Atur posisi vertikal label */
        left: 10px;
        /* Atur posisi horizontal label */
    }

    .destionation {
        height: 200px;
    }

    @media (min-width: 992px) {
        .modal-lg {
            max-width: 900px;
            /* Example width, adjust as needed */
        }
    }

    @media (max-width: 991px) {
        .modal-dialog {
            width: 100%;
            margin: 0;
            padding: 10px;
        }
    }
</style>

<div class="container my-5">
    <div class="text-center">
        <p style="font-family: Comfortaa; font-size: 30px; color: #3DA43A;">Management Tour</p>
        <p>Please Provide the Following Information</p>
    </div>
    <div class="row">
        <div class="col-md-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <p style="font-family: Comfortaa; font-size: 20px; color: #3DA43A;"><i
                            class="bi bi-plus-square"></i> ADD Tour</p>
                    <form id="formTambah" action="/admin/tour" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3 me-2">
                                    <input type="text" class="form-control" id="title" placeholder="Tour title"
                                        name="title">
                                    <label class="me-2" for="title">Tour Header</label>
                                </div>
                                @livewire('province-form')
                                <div class="form-group mb-3">
                                    <label for="editProvinceId" class="form-label">Nama Destination</label>
                                    <select class="form-select" id="placeSelect" multiple name="place[]">
                                    </select>
                                </div>
                                <div class="form-floating mb-3 me-1">
                                    <textarea class="form-control mb-3" id="additional" style="height: 100px"
                                        placeholder="Enter Desc" name="description"></textarea>
                                    <label for="additional">Description</label>
                                </div>
                                @livewire('category-from')
                                <div class="d-flex flex-row form-floating mb-3">
                                    <div class="form-control me-2" id="guest">
                                        <!-- Tambahkan event 'oninput' untuk memperbarui output -->
                                        <input type="range" value="2" min="2" max="100" name="max_slot" class="w-100"
                                            oninput="updateOutput(this.value)">
                                    </div>
                                    <label for="max_slot">Slot</label>
                                    <output class="form-control" id="num">2</output>
                                    <!-- Set nilai awal yang sama dengan nilai awal slider -->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex flex-row mb-3">
                                    <div class="form-floating col-6 me-1">
                                        <input type="date" id="startdate" class="form-control" name="start_date"
                                            value="">
                                        <label for="startdate">Start Date</label>
                                    </div>
                                    <div class="form-floating col-6 me-1">
                                        <input type="date" id="enddate" class="form-control" name="end_date" value="">
                                        <label for="enddate">End Date</label>
                                    </div>
                                </div>
                                <div class="form-floating">
                                    <textarea class="form-control mb-3" id="additional" style="height: 100px"
                                        placeholder="Enter Trip Plan" name="highlights"></textarea>
                                    <label for="additional">Highlights</label>
                                </div>
                                <div class="form-floating">
                                    <textarea class="form-control mb-3" id="additional" style="height: 100px"
                                        placeholder="Enter Trip Plan" name="include"></textarea>
                                    <label for="additional">Include</label>
                                </div>
                                <div class="form-floating">
                                    <textarea class="form-control mb-3" id="additional" style="height: 100px"
                                        placeholder="Enter Trip Plan" name="not_include"></textarea>
                                    <label for="additional">Not Include</label>
                                </div>
                                <div class="form-floating">
                                    <textarea class="form-control mb-3" id="additional" style="height: 100px"
                                        placeholder="Enter Trip Plan" name="itinerary"></textarea>
                                    <label for="additional">Itinerary</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="money form-control mb-3" type="text" name="price" class="money" />
                                    <label for="price">Price</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-outline-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p style="font-family: Comfortaa; font-size: 20px; color: #3DA43A;"><i
                            class="bi bi-journal-richtext"></i> List Tour</p>

                    <div style="overflow-y: scroll; width:100%;">
                        <table id="getTour" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Tour Title</th>
                                    <th>Destination</th>
                                    <th>Price</th>
                                    <th>Setart Date</th>
                                    <th>end Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Isi data akan diisi oleh DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Provinsi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Edit Data di sini -->
                <form id="editForm" method="post">
                    @csrf
                    <input type="hidden" id="editId" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 me-2">
                                <select class="form-select" id="editIsPublic" name="publish">
                                    <option selected>Open this select menu</option>
                                    <option value="1">Publish</option>
                                    <option value="0">Draft</option>
                                </select>
                                <label for="title">Tour Header</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="editName" placeholder="Tour title"
                                    name="title">
                                <label for="title">Tour Header</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control mb-3" id="editDescription" style="height: 100px"
                                    placeholder="Enter Desc" name="description"></textarea>
                                <label for="additional">Description</label>
                            </div>
                            @livewire('province-place')
                            <div class="form-group mb-3">
                                <label for="editProvinceId" class="form-label">Nama Destination</label>
                                <select class="form-select" id="placeSelectEdit" multiple name="place[]" required>

                                </select>
                            </div>
                            @livewire('category-from')
                            <div class="d-flex flex-row form-floating mb-3">
                                <div class="form-control me-2" id="guest">
                                    <!-- Tambahkan event 'oninput' untuk memperbarui output -->
                                    <input type="range" id="editmax_slot" min="2" max="100" name="max_slot"
                                        class="w-100" oninput="updateOutputEdit(this.value)">
                                </div>
                                <label for="max_slot">Slot</label>
                                <output class="form-control" id="max_slot">2</output>
                                <!-- Set nilai awal yang sama dengan nilai awal slider -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-row mb-3">
                                <div class="form-floating col-6 me-1">
                                    <input type="date" id="editStartDate" class="form-control" name="start_date">
                                    <label for="startdate">Start Date</label>
                                </div>
                                <div class="form-floating col-6 me-1">
                                    <input type="date" id="editEndDate" class="form-control" name="end_date">
                                    <label for="enddate">End Date</label>
                                </div>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control mb-3" id="editHighlights" style="height: 100px"
                                    placeholder="Enter Trip Plan" name="highlights"></textarea>
                                <label for="additional">Highlights</label>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control mb-3" id="editInclude" style="height: 100px"
                                    placeholder="Enter Trip Plan" name="include"></textarea>
                                <label for="additional">Include</label>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control mb-3" id="editNotInclude" style="height: 100px"
                                    placeholder="Enter Trip Plan" name="not_include"></textarea>
                                <label for="additional">Not Include</label>
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control mb-3" id="editItinerary" style="height: 100px"
                                    placeholder="Enter Trip Plan" name="itinerary"></textarea>
                                <label for="additional">Itinerary</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="money  form-control mb-3" id="editPrice" type="text" name="price"
                                    class="money" />
                                <label for="price">Price</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function updateOutput(value) {
        document.getElementById('num').value = value;
    }
    function updateOutputEdit(value) {
        document.getElementById('max_slot').value = value;
    }
</script>
<script>
    $(document).ready(function() {

        $('.money').mask('000.000.000.000.000', {reverse: true});

        $('.money').on('input', function() {
            var value = $(this).val();

            // Memeriksa apakah "Rp" sudah ada di awal. Jika tidak, tambahkan.
            if (!value.startsWith('Rp')) {
                $(this).val('Rp' + value);
            }
        });

    var table = $('#getTour').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/tour/getData",
            "type": "GET"
        },
        "columns": [
            { "data": "name", "orderable": false, },
            { "data": "destination"},
            { "data": "price"},
            { "data": "start_date"},
            { "data": "end_date"},
            { "data": "status"},
            { "data": "action", "orderable": false, "searchable": false },
            //hide data
            { "data": "id", "visible": false },
            { "data": "max_slot", "visible": false },
            { "data": "description", "visible": false },
            { "data": "highlights", "visible": false },
            { "data": "include", "visible": false },
            { "data": "not_include", "visible": false },
            { "data": "itinerary", "visible": false },
            { "data": "is_public", "visible": false },
            { "data": "provinsiId", "visible": false },
            { "data" : "destinationId", "visible": false }
        ],
        "order": [[0, 'asc']],
        "pageLength": 5,
        "searching": true,
        "lengthChange": false,
        "responsive": false,
    });

    $(document).on('click', '.btn-remove', function() {
        $(this).closest('.input-group').remove();
    });
    // Handle submit form tambah data
    $('#formTambah').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '/admin/tour',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                if(response.status =='success') {
                    $('#formTambah')[0].reset();
                    table.ajax.reload();
                }
            },
            error: function(response) {
                alert("Error: " + response.message + response.error);
            }
        });
    });

    // Handle klik tombol edit
    $('#example tbody').on('click', '.btn-edit', function() {

        var data = table.row($(this).parents('tr')).data();

        $('#editId').val(data.id);
        $('#editName').val(data.name);
        $('#editDestination').val(data.destination); // Tambahkan field untuk 'destination'
        $('#editStartDate').val(data.start_date); // Tambahkan field untuk 'start_date'
        $('#editEndDate').val(data.end_date); // Tambahkan field untuk 'end_date'
        $('#editPrice').val(data.price); // Tambahkan field untuk 'price'

        // Untuk data tersembunyi, asumsikan Anda memiliki field yang sesuai di form Anda
        $('#editDescription').val(data.description);
        $('#editmax_slot').val(data.max_slot); // Field untuk 'description'
        $('#editHighlights').val(data.highlights); // Field untuk 'highlights'
        $('#editInclude').val(data.include); // Field untuk 'include'
        $('#editNotInclude').val(data.not_include); // Field untuk 'not_include'
        $('#editItinerary').val(data.itinerary); // Field untuk 'itinerary'
        $('#editIsPublic').val(data.is_public); // Field untuk 'is_public
        $('#provinceSelectEdit').val(data.provinsiId); // Field untuk 'provinsiId
        updateOutputEdit(data.max_slot);
        // Isi data lainnya ke dalam form modal edit jika ada
        $('#editModal').modal('show');

        console.log(data.end_date);
    });

    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editId').val();
        console.log(id);
        var formData = new FormData(this);
        formData.append('_method', 'PUT');

        $.ajax({
            url: '/admin/tour/updateData/'+ id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                alert(response.message);
                $('#editModal').modal('hide');
                table.ajax.reload();
            },
            error: function(response) {
                alert("Error: " + response.message);
                console.log(response);
            }
        });
    });

    // Handle klik tombol delete
    $(document).ready(function() {
    // Set CSRF token secara global
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#example tbody').on('click', '.btn-delete', function() {
            var data = table.row($(this).parents('tr')).data();
            if (confirm("Anda yakin ingin menghapus data?")) {
                $.ajax({
                    url: '/admin/tour/' + data.id,
                    type: 'DELETE',
                    success: function(response) {
                        alert(response.message);
                        table.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        $('#provinceSelect').on('change', function() {
            var provinceId = $(this).val();
            $('#placeSelect').empty(); // Bersihkan select tempat

            if (provinceId) {
                $.ajax({
                    url: '/get-places/' + provinceId, // URL ke route Laravel Anda
                    type: 'GET',
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#placeSelect').append('<option value="' + value.id + '">' + value.place_name + '</option>');
                        });
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        $('#provinceSelectEdit').on('change', function() {
            var provinceId = $(this).val();
            $('#placeSelectEdit').empty(); // Bersihkan select tempat

            if (provinceId) {
                $.ajax({
                    url: '/get-places/' + provinceId, // URL ke route Laravel Anda
                    type: 'GET',
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#placeSelectEdit').append('<option value="' + value.id + '">' + value.place_name + '</option>');
                        });
                    }
                });
            }
        });
    });
});
</script>
@endsection
