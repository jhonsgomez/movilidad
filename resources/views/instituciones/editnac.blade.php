@extends('layouts.inst_conv_mov')
@section('title', 'Registro Instituciones')

@section('content')
<form method="POST" action="{{ route('institucion_nac.update', $instNac) }}" class="form-inst border border-2 rounded-3 shadow-lg">
    @csrf
    @method('PUT')
    <div class="row mt-2 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            <h4 class="text-center ">Edición Institución/Entidad Nacional</h4>
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10 ">
            <input type="text" class="form-control border border-dark " placeholder="* Nombre de la institución o entidad..." id="instentnameNac" name="instentnameNac" value="{{ strtoupper($instNac->nombre) }}">
            @error('instentnameNac')
                <span style="color: red">*{{ $message }}</span>    
            @enderror
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10 ">
            <input type="text" class="form-control border border-dark" placeholder="* Departamento, Ciudad o Municipio..." id="dtpcitymunNac" name="dtpcitymunNac" value="{{ ucwords(strtolower($instNac->ciudad)) }}">
            @error('dtpcitymunNac')
                <span style="color: red">*{{ $message }}</span>    
            @enderror
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10 ">
            <input type="text" class="form-control border border-dark" placeholder="Número NIT..." id="nitNac" name="nitNac" value="{{ $instNac->nit }}">
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10 ">
            <input type="text" class="form-control border border-dark" placeholder="Representante legal u otro" id="representante" name="representante" value="{{ ucwords(strtolower($instNac->representante)) }}">
            @error('representante')
                <span style="color: red">*{{ $message }}</span>    
            @enderror
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10 ">
            <input type="number" class="form-control border border-dark" placeholder="Telefono..." id="telefonoNac" name="telefonoNac" value="{{ $instNac->telefono }}">
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10 ">
            <input type="email" class="form-control border border-dark" placeholder="* Email..." id="emailNac" name="emailNac" value="{{ strtolower($instNac->email) }}">
            @error('emailNac')
                <span style="color: red">*{{ $message }}</span>    
            @enderror
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <div class="offset-1 col-2">
            <a href="{{ route('instituciones.show_nac') }}" class="text-danger text-decoration-none">Regresar</a>
        </div>            
        <div class="offset-5 col-3">
            <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Registrar</button>
        </div>
    </div>
</form>   

         
@endsection
