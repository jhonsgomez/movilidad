@extends('layouts.inst_conv_mov')
@section('title', 'Registro Movilidades')

@section('content')
@if (auth()->user()->rol_id == '1' or auth()->user()->rol_id == "2" or auth()->user()->rol_id == "6")
    <form method="POST" class="form-conv-nac border border-2 rounded-3 shadow-lg mt-5 mb-5" action="{{ route('movilidades_nac.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori">Registro Movilidad Nacional</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1">
                <label for="" class="mb-1">* Documento:</label>
                <input type="number" name="documento" id="documento" class="w-md-auto w-100 form-control border border-dark" value="{{ old('documento') }}">
                @error('documento')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
                <label for="" class="mb-1">* Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="w-md-auto w-100 form-control border border-dark" value="{{ old('nombre') }}">
                @error('nombre')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <label for="" class="mb-1">* Tipo de persona:</label>
                <select class="form-select border-dark" name="est_pro" id="est_pro">
                    <option value="" selected>-- Tipo de persona --</option>
                    <option value="0" {{ old('est_pro') == "0" ? 'selected': '' }}>Estudiante</option>
                    <option value="1" {{ old('est_pro') == "1" ? 'selected': '' }}>Profesor</option>
                </select>
                @error('est_pro')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <label for="" class="mb-1">* Entidad de origen:</label>
                <select class="form-select border-dark" name="inst_ent_nacs" id="inst_ent_nacs">
                    <option value="" selected>-- Entidad de origen --</option>
                    @foreach ($instituciones as $institucion)
                        <option value="{{ $institucion->id }}" {{ old('inst_ent_nacs') == $institucion->id ? 'selected': '' }}> {{ strtoupper($institucion->nombre) }}</option>
                    @endforeach
                </select>
                @error('inst_ent_nacs')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1">
                <label for="" class="mb-1">* País:</label>
                <input type="text" name="pais" id="pais" class="w-md-auto w-100 form-control border border-dark" value="Colombia" readonly>
                @error('pais')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
                <label for="" class="mb-1">* Objeto:</label>
                <input type="text" name="objeto" id="objeto" class="w-md-auto w-100 form-control border border-dark" value="{{ old('objeto') }}">
                @error('objeto')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1">
                <label for="" class="mb-1">* Resultados:</label>
                <input type="text" name="resultados" id="resultados" class="w-md-auto w-100 form-control border border-dark" value="{{ old('resultados') }}">
                @error('resultados')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
                <label for="" class="mb-1">* Modalidad:</label>
                <select class="w-md-auto w-100 form-select border-dark" name="pres_virt" id="pres_virt">
                    <option value="" selected>-- Tipo de modalidad --</option>
                    <option value="0" {{ old('pres_virt') == "0" ? 'selected': '' }}>Presencial</option>
                    <option value="1" {{ old('pres_virt') == "1" ? 'selected': '' }}>Virtual</option>
                </select>
                @error('pres_virt')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1 col-10">
                <label for="" class="mb-1">* Tipo:</label>
                <select class="form-select border-dark" name="ent_sal" id="ent_sal">
                    <option value="" selected>-- Tipo de movilidad --</option>
                    <option value="0" {{ old('ent_sal') == "0" ? 'selected': '' }}>Entrante</option>
                    <option value="1" {{ old('ent_sal') == "1" ? 'selected': '' }}>Saliente</option>
                </select>
                @error('ent_sal')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <input type="hidden" name="nac_ext" id="nac_ext" value="0">
        <div class="row mt-4">
            <div class="col-md-5 col-10 offset-1 mb-mb-0 mb-4">
                <label for="" class="mb-1">* Fecha de inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control border border-dark" value="{{ old('fecha_inicio') }}">
                @error('fecha_inicio')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col-md-5 col-10 offset-md-0 offset-1">
                <label for="" class="mb-1">* Fecha final:</label>
                <input type="date" name="fecha_final" id="fecha_final" class="form-control border border-dark" value="{{ old('fecha_final') }}">
                @error('fecha_final')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-10">
                <label for="" class="mb-1">* Documentación de soporte:</label>
                <input type="file" class="form-control border border-dark " multiple name="doc_soporte[]" id="doc_soporte" >
                <span for="">* Nota: Se debe cargar al menos un archivo.<br></span>
                @error('doc_soporte')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4 mb-5">
            <div class="offset-1 col-2">
                <a  href="{{ route('login.activites') }}" class="text-decoration-none text-danger">Regresar</a>
            </div>
            <div class="offset-5 col-3">
                <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Registrar</button>
            </div>
        </div>
    </form>
@endif
@endsection