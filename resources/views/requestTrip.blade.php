@extends('layout/template')

@section('title','Request Trip')

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

<div class="container my-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form id="formTambah" class="my-5" method="POST"">
                @csrf
                <div class="text-center">
                    <p class="display-4 text-success">Request Trip</p>
                    <p>Please Provide the Following Information</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    @php
                         $disable = ""
                    @endphp
                    @livewire('province-request')
                    <div class="d-flex flex-row form-floating mb-3 w-100">
                        <div class="form-control me-2" id="guest" style="width: 90%" >
                            <input type="range" min="2" max="20" oninput="num.value = this.value" name="total_guest" class="w-100">
                        </div>
                        <label for="guest">Number of Guest</label>
                          <output class="form-control" style="width: 10%"  id="num">2</output>
                      </div>
                    <div class="d-flex flex-row mb-3 w-100">
                        <div class="form-floating me-1 w-100">
                            <input type="date" id="startdate"  class="form-control" name="start_date">
                            <label for="startdate">Start Date</label>
                        </div>
                        <div class="form-floating ms-1 w-100">
                            <input type="date" id="enddate" class="form-control" name="end_date">
                            <label for="enddate">End Date</label>
                        </div>
                    </div>
                    <div class="form-floating w-100">
                        <textarea class="form-control mb-3" id="additional" style="height: 100px"
                            placeholder="Enter Trip Plan" name="trip_plan" required></textarea>
                        <label for="additional">Trip Plan or Additional Information</label>
                    </div>

                    <div class="form-floating w-100 me-1 mb-3">
                        <div class="form-floating mb-3">
                            <input class="money  form-control mb-3" id="editPrice" type="text" name="price"
                                class="money" />
                            <label for="price">Price</label>
                        </div>
                    </div>

                    <button class="btn btn-success mb-3 w-100" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

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


        $('#formTambah').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '/requestTrip',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert(response.message);
                    $('#formTambah')[0].reset();
                    window.location.href = "/inbox";
                },
                error: function(response) {
                    alert("Error: " + response.message);
                }
            });
        });





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
</script>
<script>
    function updateOutput(value) {
        document.getElementById('num').value = value;
    }
    function updateOutputEdit(value) {
        document.getElementById('max_slot').value = value;
    }
</script>

@endsection
