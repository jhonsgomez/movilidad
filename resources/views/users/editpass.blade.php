@extends('layouts.inst_conv_mov')

@section('title', 'Cambio de contraseña')

@section('content')
    <form action="{{ route('password.update', $user) }}" style="width: 30%;" method="POST" class="border border-2 rounded-3 shadow-lg">
        @csrf
        @method('put')
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center">Cambio de contraseña</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <label for=""><label class="fw-bold">Usuario:</label> {{ $user->first_name }} {{ $user->second_name }} {{ $user->last_name }}</label>
            </div>
        </div>
        <div class="row mt-2">
            <div class="offset-1 col-10">
                <label for=""><label class="fw-bold">Email:</label> {{ $user->email }}</label>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="* Nueva contraseña..." required 
                        pattern="^(?=.*\d)(?=.*?[#?!@$%^&*-])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$">
                    <div class="input-group-append">
                        <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"><i class="bi bi-eye-slash icon"></i></button>
                    </div>
                </div>
                <small class="text-muted">
                    La contraseña debe tener:
                    <ul>
                        <li>1 mayúscula.</li>
                        <li>1 minúscula.</li>
                        <li>1 dígito.</li>
                        <li>1 caracter especial (#?!@$%^&*-).</li>
                        <li>Longitud entre 8 y 16 caracteres.</li>
                    </ul>
                </small>    
            </div>
        </div>
        <div class="row mt-2 mb-4">
            <div class="offset-1 col-2">
                <a href="{{ route('users.index') }}" class="text-danger text-decoration-none">Regresar</a>
            </div>            
            <div class="offset-5 col-3">
                <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Actualizar</button>
            </div>
        </div>
    </form>
@endsection