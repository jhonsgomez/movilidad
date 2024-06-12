<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @yield('css')
    {{-- DT css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
    {{-- DT js --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>  
    <script src="//cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>  
    {{-- BT style --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    {{-- CSS own --}}
    <link rel="stylesheet" href="{{ asset('css/style_inst_conv_mov.css') }}">
    {{-- Icon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/icon_.png') }}">
</head>

<body>
    <div class="container-fluid b-g">
        <div class="row">
            <div class="col">
                <div class="abs-center">
                    @if (auth()->check())
                    
                        @yield('content')
                    @else
                        <div class="abs-center">
                            @yield('login')    
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/dTables.js') }}"></script>
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
    <script src="{{ asset('js/sweetalert.js') }}"></script>
</body>
<script src='{{ asset('js/modal.js')}}'></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>
