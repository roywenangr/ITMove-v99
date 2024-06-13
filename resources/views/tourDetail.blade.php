@extends('layout/template')

@section('title','Tour Detail')

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
    .holder {
        display: flex;
        overflow-x: auto;
        overflow-y: hidden;
    }

    .holder::-webkit-scrollbar {
        display: none;
    }

    .slides {
        display: none;
    }

    .prev,
    .next {
        cursor: pointer;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    .column {
        float: left;
    }

    .slide-thumbnail {
        opacity: 0.6;
        cursor: pointer;
    }

    .active,
    .slide-thumbnail:hover {
        opacity: 1;
    }

    .fixed-height {
        height: 600px;
        /* Sesuaikan dengan tinggi yang diinginkan */
        object-fit: cover;
        /* Ini akan menjaga rasio aspek gambar */
    }

    @media (max-width: 767px) {
        .fixed-height {
            height: 300px;
        }
    }
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
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-decoration-none" href="#">{{
                            $tour->province->province_name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $tour->tour_title }}</li>
                </ol>
            </nav>

            <div class="row">
                <div class="col">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <!-- Tempatkan item carousel di sini -->
                            @foreach($tour->tourPlace as $index => $tp)
                            <div class="carousel-item @if($index === 0) active @endif">
                                <img src="{{ asset('images/destination/'.$tp->place->place_image) }}"
                                    class="d-block w-100 img-fluid fixed-height" alt="{{ $tp->place->place_image }}">
                            </div>
                            @endforeach
                            <!-- Item carousel lainnya -->
                        </div>
                        <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>

                    <div class="d-flex justify-content-center mt-3 mb-2">
                        <!-- Tempatkan thumbnail di sini -->
                        @foreach($tour->tourPlace as $index => $tp)
                        <img class="slide-thumbnail me-2 @if($index === 0) active @endif" width="50" height="50"
                            src="{{ asset('images/destination/'.$tp->place->place_image) }}" alt="nama-tempat">
                        @endforeach
                        <!-- Thumbnail lainnya -->
                    </div>
                </div>
            </div>
        </div>

        <form class="col-md-4" action="/checkout/alone" method="POST">
            @csrf
            <!-- Konten formulir -->
            @if($tour->start_date < date('Y-m-d', strtotime('tomorrow')))
                <div class="alert alert-danger mt-2">
                     Tour not available.
                </div>
            @endif

    <h2 class="font-weight-bold">{{ $tour->tour_title }}</h2>
    <div class="d-flex justify-content-between mt-2">
        <h3 class="text-success font-weight-bold">Rp{{ number_format($tour->price, 2, ',', '.') }}</h3>
        <!-- Kontrol untuk jumlah -->
        @if(!Auth::user() or (Auth::user() and !Auth::user()->is_admin))
        <div class="d-flex flex-row align-items-center">
            <a class="btn minus bg-light text-center align-self-center" style="font-size: 18px; width:35px">-</a>
            <input class="num text-center border-0 mx-2" style="font-size: 18px; width: 25px" name="qty" value="1">
            <a class="btn plus bg-light text-center align-self-center" style="font-size: 18px; width:35px">+</a>
        </div>
        @endif
    </div>
    <p class="text-danger mb-3 mt-2">Remaining slot(s): {{ $stock }}</p>

    <div class="d-flex flex-row align-items-center w-100 ms-0">
        @if(Auth::user() and Auth::user()->is_admin == true)

        <button type="button" class="btn btn-dark btn-edit me-2" style="font-size: 18px"
            data-id="{{$tour->id}}">Edit</button>

        <button type="button" class="btn btn-danger btn-delete text-white" style="background-color:crimson; font-size: 18px" data-id="{{$tour->id}}">Hapus</button>
            {{-- <a type="button" class="btn text-white deleteTour" value="{{$tour->id}}" href="/deleteTour/{{ $tour->id }}"
            style="background-color:crimson; font-size: 18px">Delete</a> --}}
        @else
        @if($tour->start_date < date('Y-m-d', strtotime('tomorrow')))
           @php $disabled = 'disabled'; @endphp
        @endif
        <button {{$disabled}} type="button" value="{{$tour->id}}" class="btn text-white bg-secondary me-2 addCart"
            style="font-size: 18px" {{ $disabled  }}>Add to Cart</button>

        <button type="submit" class="btn text-white" name="id" value="{{$tour->id}}"
            style="background-color: #3DA43A; font-size: 18px" {{ $disabled  }}>Purchase</button>
        @endif
    </div>

    <div class="mt-4">
        <p class="font-weight-bold" style="font-size: 18px;">Description</p>
        <p class="mb-1" style="font-size: 16px;">
            <b>Date: {{ date('l, d F Y', strtotime($tour->start_date)) }} - {{ date('l, d F Y',
                strtotime($tour->end_date)) }}</b>
        </p>
        <p style="font-size: 16px;">{{ $tour->description }}</p>
    </div>

    <div class="mt-2">
        <p class="mb-3 font-weight-bold" style="font-size: 18px;">Category</p>
        <div class="row mb-3 m-0">
            <!-- Kategori tour -->
            @foreach($tour->tourCategory as $cat)
            <p class="px-2 py-1 rounded me-2 mb-0 col-1"
                style="font-size: 16px; width: fit-content; border: solid 1px black">{{ $cat->category->category_name }}
            </p>
            @endforeach
        </div>
    </div>
    </form>
</div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <p class="font-weight-bold" style="font-size: 18px;">Highlights</p>
        <p class="ms-4 mb-0" style="font-size: 16px;">{!! nl2br($tour->highlights) !!}</p>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <p class="font-weight-bold" style="font-size: 18px;">What's included</p>
        <p class="ms-4 mb-0" style="font-size: 16px;">{!! nl2br($tour->include) !!}</p>
    </div>
</div>

<!-- Bagian "What's not included" -->
<div class="bg-light pb-5">
    <div class="container">
        <p class="font-weight-bold" style="font-size: 18px;">What's not included</p>
        <p class="ms-4 mb-0" style="font-size: 16px;">{!! nl2br($tour->not_include) !!}</p>
    </div>
</div>

<div class="py-5">
    <div class="container">
        <p class="font-weight-bold" style="font-size: 18px;">Itinerary</p>
        <p class="ms-4 mb-0" style="font-size: 16px;">{!! nl2br($tour->itinerary) !!}</p>
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
    var manageTourUrl = "{{ route('manage.tour') }}";
</script>
<script>
    $(document).ready(function(){

        $('.money').mask('000.000.000.000.000', {reverse: true});

        $('.money').on('input', function() {
            var value = $(this).val();

            // Memeriksa apakah "Rp" sudah ada di awal. Jika tidak, tambahkan.
            if (!value.startsWith('Rp')) {
                $(this).val('Rp' + value);
            }
        });

        $('.btn-edit').on('click', function() {
        var id = $(this).data('id');
        console.log(id);
            // Mengambil data dari server
            $.ajax({
                url: '/admin/tour/getData/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Isi data ke dalam form modal
                    $('#editId').val(id);
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
                    // dan seterusnya untuk field lainnya...

                    updateOutputEdit(data.max_slot);

                    // Tampilkan modal
                    $('#editModal').modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
         });
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#editId').val();
        console.log(id);
        var formData = new FormData(this);
        formData.append('_method', 'PUT');

        $.ajax({
            url: '/admin/tour/updateData/' + id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                alert(response.message);
                $('#editModal').modal('hide');
                window.location.reload();
            },
            error: function(response) {
                alert("Error: " + response.message);
            }
        });
    });

    $(document).on('click', '.btn-delete', function() {
        var dataId = $(this).data('id'); // Mendapatkan ID dari data-id attribute
        if (confirm("Anda yakin ingin menghapus data?")) {
            $.ajax({
                url: '/admin/tour/' + dataId, // Menggunakan dataId
                type: 'DELETE',
                success: function(response) {
                    alert(response.message);
                    window.location.href = manageTourUrl; // Redirect ke URL manage tour
                },
                error: function(xhr, status, error) {
                    alert("Error: " + xhr.responseText);
                }
            });
        }
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

<script>
    $('.plus').click(function () {
		if ($(this).prev().val() < {{$stock}}) {
    	    $(this).prev().val(+$(this).prev().val() + 1);
	    }
    });
    $('.minus').click(function () {
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
        }
    });

    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("slides");
        var dots = document.getElementsByClassName("slide-thumbnail");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}

        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace("active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
    }
</script>

<script>
    $('.addCart').on('click',function(){
        if(!'{{Auth::user()}}') {
            window.location = "{{ route('login') }}";
        } else{
            console.log('masuk');
            var tourid = $(this).val();
            var qty = $('.num').val();

            $.ajax({
                type: "post",
                data: {_method: 'POST', _token: "{{ csrf_token() }}"},
                url: "/cart/add/" + tourid + "/" + qty,
                success: function (html) {
                    location.reload();
                }
            })
        };
    })
    $('.deleteTour').on('click',function(){
        var tourid = $(this).val();
        $.ajax({
            type: "post",
            data: {_method: 'DELETE', _token: "{{ csrf_token() }}"},
            url: "/deleteTour/" + tourid,
            success: function (html) {
                window.location = '/tour';
             }
        })
    });
</script>

@endsection
