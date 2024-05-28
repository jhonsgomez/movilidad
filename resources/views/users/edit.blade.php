@extends('layouts.inst_conv_mov')

@section('Registro de usuario')

@section('content')
    <form method="POST" action="{{ route('users.update', $user) }}" style="width: 30% ;" class="border border-2 rounded-3 shadow-lg">
        @csrf
        @method('put')
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center">Actualizar Usuario</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="* Primer nombre..." required value="{{ $user->first_name }}">
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <input type="text" name="second_name" id="second_name" class="form-control" placeholder="Segundo nombre..." value="{{ $user->second_name }}">
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="* Apellido(s)..." required value="{{ $user->last_name }}">
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <select name="rol" id="rol" class="form-select" required>
                    <option value="" selected>-- * Seleccione un rol --</option>
                    @foreach ($roles as $item)
                        <option value="{{ $item->id }}" {{ $user->rol_id == $item->id ? 'selected' : '' }}>{{ $item->rol_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <input type="email" name="email" id="email" class="form-control" placeholder="* Email..." required value="{{ $user->email }}">
                @error('email')
                    <span class="text-danger">Este corre ya existe!</span>
                @enderror
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