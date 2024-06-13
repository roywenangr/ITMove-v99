@extends('layout/template')

@section('title','Management User')
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
<div class="container mt-5">
    <h2 style="font-family: Comfortaa; font-size: 30px; color: #3DA43A;">User Management System</h2>
    <p>Please Provide the Following Information</p>
    <div class="table-responsive">
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)

                <!-- Contoh data pengguna (seharusnya diisi dengan data dinamis) -->
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phonenumber }}</td>
                    <td><span class="badge {{ $user->email_verified_at ? 'bg-success' : 'bg-danger' }}">
                            {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editUserModal"
                            data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                            data-phonenumber="{{ $user->phonenumber }}"
                            data-verified="{{ $user->email_verified_at ? 'verified' : 'not_verified' }}">Edit</button>
                    </td>
                </tr>

                @endforeach
                <!-- Tambahkan lebih banyak baris pengguna di sini -->
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center">
        {{ $users->links('vendor.pagination.pag') }}
    </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="userId">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="userName">
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="userEmail">
                    </div>
                    <div class="mb-3">
                        <label for="userPhoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phonenumber" id="userPhoneNumber">
                    </div>
                    <div class="mb-3">
                        <label for="userVerification" class="form-label">Verification Status</label>
                        <select class="form-select" name="verified" id="userVerification">
                            <option value="verified">Verified</option>
                            <option value="not_verified">Not Verified</option>
                        </select>
                    </div>
                    <!-- Tambahkan lebih banyak field jika perlu -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.edit-btn').on('click', function() {
        // Ambil data pengguna dari tombol
        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var phonenumber = $(this).data('phonenumber');
        var verified = $(this).data('verified');

        // Isi form dengan data pengguna
        $('#userId').val(id);
        $('#userName').val(name);
        $('#userEmail').val(email);
        $('#userPhoneNumber').val(phonenumber);
        $('#userVerification').val(verified);
    });

    $('#saveChanges').on('click', function(e) {
        e.preventDefault();
        var formData = $('#editUserForm').serialize() + '&_method=PUT';

        $.ajax({
            url: '/admin/userManagement/' + $('#userId').val(),
            method: 'POST',
            data: formData,
            success: function(response) {
                // Tampilkan pesan sukses, misalnya menggunakan alert atau update UI
               alert(response.message);
               window.location.reload();
            },
            error: function(xhr) {
                // Tampilkan error
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '\n'; // Membangun string pesan error
                });
                alert(errorMessage);
            }
        });
    });
});
</script>

@endsection
