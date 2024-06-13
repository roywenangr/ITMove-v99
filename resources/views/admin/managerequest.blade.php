@extends('layout/template')

@section('title','About Us')
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
    <div class="text-center mb-3">
        <div class="fw-bold" style="font-size: 30px; color: #3DA43A;">Manage Inbox Request</div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <p style="font-family: Comfortaa; font-size: 20px; color: #3DA43A;"><i
                            class="bi bi-journal-richtext"></i> List Request</p>

                    <div style="overflow-y: scroll; width:100%;">
                        <table id="dataTabel" class="table table-striped" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Tour Title</th>
                                    <th>Destination</th>
                                    <th>Price</th>
                                    <th>Request Date</td>
                                    <th>Start Date</th>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Destination</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Edit Data di sini -->
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Isi Form di sini -->
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                       <p style="font-size: 20px;">Name : <span id="name"></span></p>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" name="note" id="note" rows="3">Silakahan klik pesan ini untuk membayar</textarea>
                        <small>ini pesan untuk default approve </small>
                    </div>
                      <div class="mb-3 d-flex justify-content-between">
                        <button id="approve" type="button" class="btn btn-success">Approve</button>
                        <button id="rejected" type="button" class="btn btn-danger">Rejected</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

    var table = $('#dataTabel').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/api/admin/inbox/all",
            "type": "GET"
        },
        "columns": [
            { "data": "name", "orderable": false, },
            { "data": "destination"},
            { "data": "max_price"},
            { "data": "request_date"},
            { "data": "start_date"},
            { "data": "status"},
            { "data": "action", "orderable": false, "searchable": false },
            { "data": "id", "visible": false },
        ],
        "order": [[0, 'asc']],
        "pageLength": 10,
        "searching": true,
        "lengthChange": false,
    });


    $('#dataTabel tbody').on('click', '.btn-respond', function() {
        var data = table.row($(this).parents('tr')).data();

        $('#id').val(data.id);
        $('#name').text(data.name);
        // Isi data lainnya ke dalam form modal edit jika ada
        $('#editModal').modal('show');
    });


    $('#approve').on('click', function(e) {
        e.preventDefault();
        var formData = $('#editForm').serialize();

        $.ajax({
            url: '/api/admin/inbox/status/approve',
            method: 'POST',
            data: formData,
            success: function(response) {
                // Tampilkan pesan sukses, misalnya menggunakan alert atau update UI
                $('#editModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                // Tampilkan pesan error, misalnya menggunakan alert atau update UI
                console.log(xhr.responseText);
            }
        });
    });

});

</script>

@endsection
