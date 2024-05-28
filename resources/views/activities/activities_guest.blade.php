@extends('layouts.guest')
@section('title', 'Actividades')

@section('act_content')
<form method="POST" name="f" action="{{ route('convGuest.index') }}" class="border border-2 rounded-3 shadow-lg act_form m-5">
    @csrf
    <img src="{{asset('images/index/header_login.jpg')}}" alt="" class="img-fluid m-0 rounded-top">
    <div class="row mt-4 rounded-3">
        <div class="offset-1 col-10">
            <h4 class="text-center" id="die">Convenios Activos</h4>
        </div>
    </div>
    <div class="row">
        <div class="offset-1 col-10">
            <span>En esta sección podra consultar los convenios activos en la institución a la fecha.</span>
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <select class="form-select border-dark w-100" name="guest_Conv" id="guest_Conv" required>
                <option value="" selected> -- Seleccione un convenio --</option>
                <option value="nacional">Convenios Nacionales</option>
                <option value="internacional">Convenios Internacionales</option>
            </select>
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <select class="form-select border-dark w-100" name="guest_type" id="guest_type" required>
                <option value="" selected> -- Tipo de convenio --</option>
                <option value="Practicas">Practicas</option>
                <option value="Marco">Marco</option>
                <option value="Especifico">Específico</option>
                <option value="Interadministrativo">Interadministrativo</option>
            </select>
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <div class="offset-1 col-4">
            <a href="{{ route('login.index') }}" class="btn btn-outline-danger w-100">Regresar</a>
        </div>
        <div class="offset-1 col-5">
            <button type="submit" class="btn1 btn border border-dark btn-success w-100">Siguiente</button>
        </div>
    </div>
</form>
@endsection