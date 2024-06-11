@extends('layouts.inst_conv_mov')
@section('title', 'Detalles Actividades')

@section('content')
@if (auth()->user()->rol_id == "2" or auth()->user()->rol_id == "6")
    <form method="POST" class="form-conv-nac border border-2 rounded-3 shadow-lg mt-5 mb-5" enctype="multipart/form-data">
        @csrf
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori">Modalidad de [{{ strtoupper($movilidad->nombre) }}]</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col d-flex justify-content-center">
                <a href="{{ route('movilidades.get_asistentes', $actividad->id) }}" class="w-auto btn btn-success">Gestionar Asistencia</a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1">
                <label for="" class="mb-1">* Tipo:</label>
                <input type="text" name="tipo" id="tipo" class="w-md-auto w-100 form-control border border-dark" value="{{ $actividad->tipo }}" readonly>
                @error('tipo')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
                <label for="" class="mb-1">* Descripción:</label>
                <input type="text" name="descripcion_tipo" id="descripcion_tipo" class="w-md-auto w-100 form-control border border-dark" value="{{ ucfirst(strtolower($actividad->descripcion_tipo)) }}" readonly>
                @error('descripcion_tipo')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1">
                <label for="" class="mb-1">* Resultados:</label>
                <input type="text" name="resultados" id="resultados" class="w-md-auto w-100 form-control border border-dark" value="{{ ucfirst(strtolower($actividad->resultados)) }}" readonly>
                @error('resultados')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
                <label for="" class="mb-1">* Responsable:</label>
                <input type="text" name="responsable" id="responsable" class="w-md-auto w-100 form-control border border-dark" value="{{ strtoupper($actividad->responsable) }}" readonly>
                @error('responsable')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1">
                <label for="" class="mb-1">* Documento:</label>
                <input type="number" name="documento" id="documento" class="w-md-auto w-100 form-control border border-dark" value="{{ $actividad->documento }}" readonly>
                @error('documento')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
                <label for="" class="mb-1">* Tipo de persona:</label>
                <input type="text" name="tipo_empleado" id="tipo_empleado" class="w-md-auto w-100 form-control border border-dark" value="{{ $actividad->tipo_empleado }}" readonly>
                @error('tipo_empleado')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1">
                <label for="" class="mb-1">* Descripcion de persona:</label>
                <input type="text" placeholder="(Ejemplo: Director de la ori... etc)" name="descripcion_tipo_empleado" id="descripcion_tipo_empleado" class="w-md-auto w-100 form-control border border-dark" value="{{ ucfirst(strtolower($actividad->descripcion_tipo_empleado)) }}" readonly>
                @error('descripcion_tipo_empleado')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
                <label for="" class="mb-1">* País:</label>
                <input type="text" name="pais" id="pais" class="w-md-auto w-100 form-control border border-dark" value="{{ ucfirst(strtolower($actividad->pais)) }}" readonly>
                @error('pais')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1 col-10">
                <label for="" class="mb-1">* Duración Actividad:</label>
                <input type="text" placeholder="Número de horas, dias, semanas, meses etc" name="duracion" id="duracion" class="form-control border-dark" value="{{ $actividad->duracion }}" readonly>
                @error('duracion')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row my-4">
            <div class="col offset-1 col-10">
                <label for="" class="mb-1">* Institución:</label>
                @if($movilidad->nac_ext == 0)
                <select class="form-control border-dark" name="inst_ent_nacs" id="inst_ent_nacs" disabled>
                    <option value="" selected>-- Institución --</option>
                    @foreach ($instituciones as $institucion)
                        <option value="{{ $institucion->id }}" {{ $actividad->inst_ent_nacs == $institucion->id ? 'selected': '' }}>{{ strtoupper($institucion->nombre) }}</option>
                    @endforeach
                </select>
                @error('inst_ent_nacs')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
                @else
                <select class="form-control border-dark" name="inst_ent_ints" id="inst_ent_ints" disabled>
                    <option value="" selected>-- Institución --</option>
                    @foreach ($instituciones as $institucion)
                        <option value="{{ $institucion->id }}" {{ $actividad->inst_ent_ints == $institucion->id ? 'selected': '' }}>{{ strtoupper($institucion->nombre) }}</option>
                    @endforeach
                </select>
                @error('inst_ent_ints')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
                @endif   
            </div>
        </div>
        <input type="hidden" name="movilidad" id="movilidad" value="{{ $movilidad->id }}" readonly>
        <div class="row">
            <div class="offset-1 col-10">
                <label for="" class="mb-1">Documentación de soporte:</label>
                @if ($actividad->doc_soporte == '')
                    <span><b>No hay documentos</b></span>
                @else
                @foreach (explode(",", $actividad->doc_soporte) as $file)
                    <br> - <a href="{{ url('/download_actividad', $file) }}">{{$file}}</a>
                @endforeach
                @endif
            </div>
        </div>
        <div class="row mt-4 mb-5">
            <div class="offset-1 col-2">
                @if ($movilidad->nac_ext == 0)
                    <a href="{{ route('movilidades_nac.index') }}" class="text-decoration-none text-danger">Regresar</a>
                @else
                    <a href="{{ route('movilidades_int.index') }}" class="text-decoration-none text-danger">Regresar</a>
                @endif
            </div>
        </div>
    </form>
@endif
@endsection