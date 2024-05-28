@extends('layouts.inst_conv_mov')
@section('title', 'Registro Instituciones')

@section('content')
@if (auth()->user()->rol_id == '1' or auth()->user()->rol_id =='2' or auth()->user()->rol_id =='6')
    <form method="POST" action="{{ route('instituciones.store_nac') }}" class="form-inst border border-2 rounded-3 shadow-lg" enctype="multipart/form-data">
        @csrf
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center">Registro Institución/Entidad Nacional</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10 ">
                <input type="text" class="form-control border border-dark " placeholder="* Nombre de la institución o entidad..." id="instentnameNac" name="instentnameNac" value="{{ old('instentnameNac') }}">
                @error('instentnameNac')
                    <span style="color: red">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10 ">
                <input type="text" class="form-control border border-dark" placeholder="* Departamento, Ciudad o Municipio..." id="dtpcitymunNac" name="dtpcitymunNac" value="{{ old('dtpcitymunNac') }}">
                @error('dtpcitymunNac')
                    <span style="color: red">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10 ">
                <input type="text" class="form-control border border-dark" placeholder="Número NIT..." id="nitNac" name="nitNac" value="{{ old('nitNac') }}">
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10 ">
                <input type="text" class="form-control border border-dark" placeholder="Representante legal u otro" id="representante" name="representante" value="{{ old('representante') }}">
                @error('representante')
                    <span style="color: red">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10 ">
                <input type="number" class="form-control border border-dark" placeholder="Telefono..." id="telefonoNac" name="telefonoNac" value="{{ old('telefonoNac') }}">
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10 ">
                <input type="email" class="form-control border border-dark" placeholder="* Email..." id="emailNac" name="emailNac" value="{{ old('emailNac') }}">
                @error('emailNac')
                    <span style="color: red">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <h6 class="text-center border rounded-3 titles pt-2 pb-2">Documentación Soporte</h6>
            </div>
        </div>
        <div class="row mt-3">
            <div class="offset-1 col-10 ">
                <input type="file" class="form-control border border-dark " multiple name="inst_docsoporteNac[]" id="inst_docsoporteNac">
                <span for="">* Nota: Se debe ajuntar al menos el RUT y Certificado de existencia y representación legal.</span>
                @error('inst_docsoporteNac')
                    <br><span style="color: red">* {{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="offset-1 col-2">
                <a href="{{ route('login.activites') }}" class="text-danger text-decoration-none">Regresar</a>
            </div>            
            <div class="offset-5 col-3">
                <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Registrar</button>
            </div>
        </div>
    </form>   
@endif
@endsection
