<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    {{-- BT style --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    {{-- CSS own --}}
    <link rel="stylesheet" href="{{ asset('css/style_index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style_activities.css') }}">
    {{-- Icon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/icon_.png') }}">
</head>

<body>
    <div class="container-fluid">
            @if (auth()->check())
            <div class="row justify-content-between align-items-center nav-bar">
                <div class="col-md-2 col-6 mx-md-4 mx-0">
                    <a href="{{ route('login.destroy') }}" class="btn me-5 pt-1 pb-1 ps-3 pe-3"><i class="bi bi-house-door-fill"></i>&nbsp;Regresar</a>
                </div>
            </div>
            <div class="row">
                <div class="col">        
                    <div class="abs-center-act">
                    @yield('act_content')
                </div>
            </div>
            @else
                <div class="abs-center">
                    @yield('login')
                </div>    
            @endif
        
    </div>
    <script src="{{asset('js/index.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                'title': 'Felicidades',
                'text': '{{$message}}',
                'icon': 'success'
            })
        </script>
    @endif
</body>

</html>