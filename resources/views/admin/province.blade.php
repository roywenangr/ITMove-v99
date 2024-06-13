@extends('layout/template')

@section('title','Management Destination')
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
<div class="container my-5">
    <div class="text-center">
        <p style="font-family: Comfortaa; font-size: 30px; color: #3DA43A;">Management Province</p>
        <p>Please Provide the Following Information</p>
    </div>
    <div class="row">
        <div class="col-md-6 mb-5">
            <div class="card">
                <div class="card-body">
                    <p style="font-family: Comfortaa; font-size: 20px; color: #3DA43A;"><i class="bi bi-plus-square"></i> ADD Province</p>
                    <form id="formTambah" action="/admin/province" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="provinceName" class="form-label">Nama Provinsi</label>
                            <input type="text" class="form-control" id="provinceName" name="provinceName"
                                placeholder="Nama Provinsi" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="provinceImage" class="form-label">Gambar Provinsi</label>
                            <div class="custom-file">
                                <input type="file" class="form-control" id="provinceImage" name="provinceImage"
                                    required>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-outline-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <p style="font-family: Comfortaa; font-size: 20px; color: #3DA43A;"><i class="bi bi-journal-richtext"></i> List Province</p>
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama Provinsi</th>
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

<!-- Modal Edit Data -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Provinsi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Edit Data di sini -->
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group mb-3">
                        <label for="editName" class="form-label">Nama Provinsi</label>
                        <input type="text" class="form-control" id="editName" name="name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="changeImage">Change Images</label>
                        <input type="checkbox" id="changeImage" name="changeImage">
                    </div>
                    <div id="uploadForm" style="display:none;">
                        <div class="form-group mb-3">
                            <label for="provinceImage" class="form-label">Gambar Provinsi</label>
                            <div class="custom-file">
                                <input type="file" class="form-control" id="provinceImage" name="provinceImage">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    var table = $('#example').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/admin/province/getData",
            "type": "GET"
        },
        "columns": [
            { "data": "name" },
            { "data": "action", "orderable": false, "searchable": false },
            { "data": "id", "visible": false }
        ],
        "order": [[0, 'asc']],
        "pageLength": 5,
        "searching": true,
        "lengthChange": false,
    });

    // Handle submit form tambah data
    $('#formTambah').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '/admin/province',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                $('#formTambah')[0].reset();
                table.ajax.reload();
            },
            error: function(response) {
                alert("Error: " + response.message);
            }
        });
    });

    // Handle klik tombol edit
    $('#example tbody').on('click', '.btn-edit', function() {
        var data = table.row($(this).parents('tr')).data();
        $('#editId').val(data.id);
        $('#editName').val(data.name);
        // Isi data lainnya ke dalam form modal edit jika ada
        $('#editModal').modal('show');
    });

    // Handle submit form edit di dalam modal
    $('#changeImage').change(function() {
        if ($(this).is(':checked')) {
            $('#uploadForm').show();
            $('#provinceImage').attr('required', true);
        } else {
            $('#uploadForm').hide();
            $('#provinceImage').removeAttr('required');
        }
    });

    // Pastikan status form sesuai dengan status awal checkbox
    $('#changeImage').trigger('change');

    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editId').val();
        var formData = new FormData(this);
        formData.append('_method', 'PUT');

        $.ajax({
            url: '/admin/province/updateData/' + id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.success);
                $('#editModal').modal('hide');
                table.ajax.reload();
            },
            error: function(response) {
                alert("Error: " + response.message);
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
            console.log(data.id);
            if (confirm("Anda yakin ingin menghapus data?")) {
                $.ajax({
                    url: '/admin/province/deleteData/' + data.id,
                    type: 'DELETE',
                    success: function(response) {
                        alert(response.success);
                        table.ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + xhr.responseText);
                    }
                });
            }
        });
    });
});
</script>
@endsection
