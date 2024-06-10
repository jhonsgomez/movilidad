@extends('layouts.inst_conv_mov')

@section('title','Registro de usuario')

@section('content')
    <form method="POST" action="{{ route('users.store') }}" style="width: 50% ;" class="my-4 border border-2 rounded-3 shadow-lg">
        @csrf
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center">Registro de Usuario</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <input type="text" name="documento" id="documento" class="form-control" placeholder="* Documento de identidad..." value="{{ old('documento') }}">
                @error('documento')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="* Primer nombre..." value="{{ old('first_name') }}">
                @error('first_name')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <input type="text" name="second_name" id="second_name" class="form-control" placeholder="Segundo nombre..." value="{{ old('second_name') }}">
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="* Apellido(s)..." value="{{ old('last_name') }}">
                @error('last_name')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <select name="rol" id="rol" class="form-select">
                    <option value="" selected>-- * Seleccione un rol --</option>
                    @foreach ($roles as $item)
                        <option value="{{ $item->id }}" {{ old('rol') == $item->id ? 'selected': '' }}>{{ $item->rol_name }}</option>
                    @endforeach
                </select>
                @error('rol')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <input type="email" name="email" id="email" class="form-control" placeholder="* Email..." value="{{ old('email') }}">
                @error('email')
                    <span class="text-danger">*{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="* Contraseña..." pattern="^[A-Z](?=.*\d)(?=.*?[#?!@$%^&*-])(?=.*[A-Z])(?=.*[a-z])\S{8,16}$">
                    <div class="input-group-append">
                        <button id="show_password" class="btn btn-primary" type="button" onclick="mostrarPassword()"><i class="bi bi-eye-slash icon"></i></button>
                    </div>
                </div>
                @error('password')
                    <span class="text-danger">*{{ $message }}<br></span>    
                @enderror  
                <small class="text-muted">
                    La contraseña debe tener:
                    {{-- La constraseña debe tener 1 mayúscula, 1 minúscula, 1 número, 1 carácter especial(#?!@$%^&*-) y tener una longitud entre 8 y 16 caracteres: --}}
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
                <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Registrar</button>
            </div>
        </div>
    </form>
@endsection