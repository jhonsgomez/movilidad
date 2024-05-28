<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    {{-- DT css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
    {{-- DT JS --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>  
    <script src="//cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>  
    {{-- BT style --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    {{-- CSS own --}}
    <link rel="stylesheet" href="{{ asset('css/guest.css') }}">
    {{-- Icon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/icon_.png') }}">
</head>


<body style="background: url('{{asset('images/index/background.jpeg')}}')">
    <div class="container-fluid b-g">
        <div class="row ">
            <div class="col">
                    <div class="row">
                        <div class="col">        
                            <div class="abs-center-act">
                            @yield('act_content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/dTables.js') }}"></script>
</html>