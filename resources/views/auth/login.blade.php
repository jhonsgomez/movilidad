@extends('layouts.app')
@section('title','Login')

@section('login')
    <form class="form border rounded shadow-lg" method="POST">
        @csrf
        <img src="{{asset('images/index/header_login.jpg')}}" alt="" class="img-fluid m-0 rounded-top">
        <h3 class="text-center my-4" style="text-shadow: 0px 0px 7px gray;">Iniciar Sesión</h3>
        <div class="form-group m-4">
            <input type="text" class="form-control" placeholder="Email..." id="email" name="email" value="{{ old('email') }}">
        </div>
        <div class="form-group m-4">
            <input type="password" class="form-control" placeholder="Password..." id="password" name="password">
            @error('message')
                <p class="text-danger">{{$message}}</p>
            @enderror
        </div>
        <div class="row m-4 justify-content-center">
            <div class="col-5 d-flex align-items-center">
                <a href="{{ route('activites.guest') }}" class="link-secondary">Invitado <i class="bi bi-question-circle"></i></a>
            </div>
            <div class="col-4">
                <button type="submit" class="btn py-2"><i class="bi bi-box-arrow-right"></i>&nbsp;Ingresar</button>
            </div>
        </div>
    </form>
@endsection