@extends('layout/template')

@section('title','Inbox')

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
    .inboxes {
        height: 94vh;
    }
    .title-box {
        width: 80%;
        /* Atur lebar elemen sesuai dengan lebar layar */
        white-space: nowrap;
        /* Mencegah teks pindah ke baris baru */
        overflow: hidden;
        /* Sembunyikan teks yang melampaui batas elemen */
        text-overflow: ellipsis;
        /* Tambahkan ellipsis (...) jika teks terpotong */
    }

    .list-group-item.active {
        background-color: #EFF5EE;
        /* Contoh: warna latar biru */
        /* Contoh: warna teks putih */
        color: #000;
        border-color: #e3e3e4;
        /* Contoh: warna border biru */
    }

    @media screen and (max-width: 768px) {
        .inboxes {
            height: 100%;
        }
        .title-box{
            width: 60%;
        }
    }

</style>

<div class="container mt-3 inboxes">
    <div class="text-center">
        <p style="font-family: Comfortaa; font-size: 30px; color: #3DA43A;">Inbox Request Trip</p>
        <p id="header-title-info" style="font-family: Comfortaa; font-size:20px" class="text-center fw-bold"></p>
    </div>
    <div class="row mb-4">
        <!-- Sidebar/Menu -->
        <div class="col-md-4 mb-3">
            <div class="list-group">
                <a href="#" class="list-group-item fw-bold list-group-item-action active" data-type="inbox">
                    <i class="bi bi-archive-fill"></i> All Request Trip
                </a>
                <a href="#" class="list-group-item fw-bold text-warning list-group-item-action" data-type="awaiting">
                    <i class="bi bi-stopwatch-fill"></i> Awaiting Respond
                </a>
                <a href="#" class="list-group-item fw-bold text-success list-group-item-action" data-type="approval">
                    <i class="bi bi-check-circle-fill"></i> Approval Respond
                </a>
                <a href="#" class="list-group-item fw-bold text-danger list-group-item-action" data-type="rejected">
                    <i class="bi bi-x-circle-fill"></i> Rejected Respond
                </a>
            </div>
        </div>

        <!-- Message List -->
        <div class="col-md-8 mb-3">
            <div id="messages" class="list-group mb-3">
                <!-- Message will be generated here -->
            </div>
            <nav aria-label="Page navigation">
                <ul id="pagination" class="pagination justify-content-center">
                    <!-- Pagination will be generated here -->
                </ul>
            </nav>
        </div>
    </div>
</div>


<!-- Your jQuery Script -->
<script>
    $(document).ready(function() {
        var itemsPerPage = 5;
        var currentPage = 1;
        var currentType = 'inbox'; // Default type

        function getStatusIdByType(type) {
            switch(type) {
                case 'inbox': return null;
                case 'awaiting': return 1;
                case 'approval': return 2;
                case 'rejected': return 3;
                default: return null;
            }
        }

        function loadMessages(type, page) {
            var statusId = getStatusIdByType(type);

            $.ajax({
                url: '/api/inbox/all', // Sesuaikan dengan URL API Anda
                type: 'GET',
                success: function(response) {
                    if(response.status === 'success') {
                        $('#messages').empty();
                        var filteredMessages = response.data.filter(function(msg) {
                            return statusId === null || msg.status_id === statusId;
                        });

                        var startIndex = (page - 1) * itemsPerPage;
                        var endIndex = startIndex + itemsPerPage;
                        var messages = filteredMessages.slice(startIndex, endIndex);

                        messages.forEach(function(msg) {
                            let statusText = ""; // Menggunakan let karena statusText akan diubah
                            let badgeClass = ""; // Menggunakan let karena badgeClass akan diubah

                            switch(msg.status_id) {
                                case 1:
                                    statusText = "Waiting";
                                    badgeClass = "text-bg-warning"; // Class untuk warna kuning
                                    break;
                                case 2:
                                    statusText = "Approved";
                                    badgeClass = "text-bg-success"; // Class untuk warna hijau
                                    break;
                                case 3:
                                    statusText = "Rejected";
                                    badgeClass = "text-bg-danger"; // Class untuk warna merah
                                    break;
                                default:
                                    statusText = "Unknown";
                                    badgeClass = "text-bg-secondary"; // Class untuk warna abu-abu
                            }

                            var messageHtml = `
                                        <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1 title-box">${msg.trip_plan}</h5>
                                            <small><i class="bi bi-clock-fill"></i> Start Date: ${msg.start_date}</small>
                                        </div>
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-1"><i class="bi bi-person-vcard-fill"></i> Total Guests: ${msg.total_guest}</p>
                                            <span class="badge ${badgeClass}">${statusText}</span>
                                        </div>
                                        <p class="mb-1 fw-bold"><i class="bi bi-receipt"></i> Invoice :${msg.invoice ? msg.invoice : 'Tidak Tersedia'}</p>
                                        <p class="mb-1"><i class="bi bi-card-text"></i> Note: ${msg.note ? msg.note : 'Tidak ada catatan'}</p>
                                        <small><i class="bi bi-clock-fill"></i> Requested Date: ${msg.request_date}</small>
                                        </a>`;
                            $('#messages').append(messageHtml);
                        });
                        loadPagination(filteredMessages.length, page);
                    }
                },
                error: function(error) {
                    console.log('Error: ', error);
                }
            });
        }

        function loadPagination(totalItems, currentPage) {
            $('#pagination').empty();
            var totalPages = Math.ceil(totalItems / itemsPerPage);
            for (var i = 1; i <= totalPages; i++) {
                var liClass = currentPage === i ? 'page-item active' : 'page-item';
                $('#pagination').append('<li class="' + liClass + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>');
            }
        }

        $('#pagination').on('click', 'a', function(e) {
            e.preventDefault();
            currentPage = $(this).data('page');
            loadMessages(currentType, currentPage);
        });

        $('.list-group-item').on('click', function(e) {
            e.preventDefault();
            currentType = $(this).data('type');
            $('.list-group-item').removeClass('active');
            $(this).addClass('active');
            loadMessages(currentType, 1);

            var titleText = '';
            switch(currentType) {
                case 'inbox':
                    titleText = 'All Request Trip';
                    break;
                case 'awaiting':
                    titleText = 'Awaiting Respond';
                    break;
                case 'approval':
                    titleText = 'Approval Respond';
                    break;
                case 'rejected':
                    titleText = 'Rejected Respond';
                    break;
            }
            $('#header-title-info').text(titleText);
        });

        loadMessages('inbox', 1);
        $('#header-title-info').text('All Request Trip');
    });
</script>
@endsection
