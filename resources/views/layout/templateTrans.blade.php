<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@500;600&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

<!-- DataTables Bootstrap 5 Responsive Extension CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">

<!-- DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<!-- DataTables Bootstrap 5 JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Responsive Extension JS -->
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<!-- DataTables Responsive Bootstrap 5 JS -->
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{config('midtrans.client_key')}}">
    </script>
    <script src="{{ asset('js/jquery.mask.js') }}"></script>
 @livewireStyles
    <title>@yield('title')</title>
    <style>
        .hover-underline-animation {
          display: inline-block;
          position: relative;
        }

        .hover-underline-animation:after {
          content: '';
          position: absolute;
          width: 100%;
          transform: scaleX(0);
          height: 2px;
          bottom: 0;
          left: 0;
          background-color: white;
          transform-origin: bottom right;
          transition: transform 0.25s ease-out;
        }

        .hover-underline-animation:hover:after {
          transform: scaleX(1);
          transform-origin: bottom left;
        }

        .square-container {
          position: relative;
        }

        .square-container::after {
          content: "";
          display: block;
          padding-bottom: 100%;
        }

        .square {
          position: absolute;
          width: 100%;
          height: 100%;
          object-fit: cover;
        }

        .navbar-toggler:focus {
            outline: none;
            box-shadow: none; /* Optional: Remove any box-shadow effect */
        }

        </style>
</head>
<body style="font-family: 'Roboto', sans-serif; font-size: 14px;">

    <header >
        @yield('content')
    </header>



    @include('layout/footer')

    @livewireScripts
    <div class="pubble-app" data-app-id="122541" data-app-identifier="122541"></div>
<script type="text/javascript" src="https://cdn.chatify.com/javascript/loader.js" defer></script>
</body>
</html>
