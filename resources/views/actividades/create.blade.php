@extends('layouts.inst_conv_mov')
@section('title', 'Registro Actividades')

@section('content')
@if (auth()->user()->rol_id == "2" or auth()->user()->rol_id == "6")
    <form method="POST" class="form-conv-nac border border-2 rounded-3 shadow-lg mt-5 mb-5" action="{{ route('actividades.store', $movilidad->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori">Modalidad de [{{ $movilidad->nombre }}]</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1">
                <label for="" class="mb-1">* Tipo:</label>
                <select class="form-select border-dark" name="tipo" id="tipo">
                    <option value="" selected>-- Tipo de actividad --</option>
                    <option value="Clase Espejo" {{ old('tipo') == "Clase Espejo" ? 'selected': '' }}>Clase Espejo</option>
                    <option value="Webinar" {{ old('tipo') == "Webinar" ? 'selected': '' }}>Webinar</option>
                    <option value="Seminario" {{ old('tipo') == "Seminario" ? 'selected': '' }}>Seminario</option>
                    <option value="Foros" {{ old('tipo') == "Foros" ? 'selected': '' }}>Foros</option>
                    <option value="Capacitación" {{ old('tipo') == "Capacitación" ? 'selected': '' }}>Capacitación</option>
                    <option value="Congreso" {{ old('tipo') == "Congreso" ? 'selected': '' }}>Congreso</option>
                    <option value="Otra" {{ old('tipo') == "Otra" ? 'selected': '' }}>Otra</option>
                </select>
                @error('tipo')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
                <label for="" class="mb-1">* Descripción:</label>
                <input type="text" name="descripcion_tipo" id="descripcion_tipo" class="w-md-auto w-100 form-control border border-dark" value="{{ old('descripcion_tipo') }}">
                @error('descripcion_tipo')
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
                <label for="" class="mb-1">* Responsable:</label>
                <input type="text" name="responsable" id="responsable" class="w-md-auto w-100 form-control border border-dark" value="{{ old('responsable') }}">
                @error('responsable')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
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
                <label for="" class="mb-1">* Tipo de persona:</label>
                <select class="w-md-auto w-100 form-select border-dark" name="tipo_empleado" id="tipo_empleado">
                    <option value="" selected>-- Tipo de persona --</option>
                    <option value="Administrativo" {{ old('tipo_empleado') == "Administrativo" ? 'selected': '' }}>Administrativo</option>
                    <option value="Docente" {{ old('tipo_empleado') == "Docente" ? 'selected': '' }}>Docente</option>
                    <option value="Estudiante" {{ old('tipo_empleado') == "Estudiante" ? 'selected': '' }}>Estudiante</option>
                    <option value="Otro" {{ old('tipo_empleado') == "Otro" ? 'selected': '' }}>Otro</option>
                </select>
                @error('tipo_empleado')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1">
                <label for="" class="mb-1">* Descripcion de persona:</label>
                <input type="text" placeholder="(Ejemplo: Director de la ori... etc)" name="descripcion_tipo_empleado" id="descripcion_tipo_empleado" class="w-md-auto w-100 form-control border border-dark" value="{{ old('descripcion_tipo_empleado') }}">
                @error('descripcion_tipo_empleado')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
                <label for="" class="mb-1">* País:</label>
                <input type="text" name="pais" id="pais" class="w-md-auto w-100 form-control border border-dark" value="{{ old('pais') }}">
                @error('pais')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col offset-1">
                <label for="" class="mb-1">* Duración Actividad:</label>
                <input type="number" placeholder="Número de horas, dias, semanas, meses etc" name="duracion" id="duracion" class="w-md-auto w-100 form-control border border-dark" value="{{ old('duracion') }}">
                @error('duracion')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
            <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
                <label for="" class="mb-1">Tipo de duración: </label>
                <select name="type_duracion" class="form-select border-dark" id="type_duracion" required>
                    <option value="" selected>-- * Tipo de duración --</option>
                    <option value="Horas">Horas</option>
                    <option value="Dias">Días</option>
                    <option value="Semanas">Semanas</option>
                    <option value="Meses">Meses</option>
                </select>
                @error('type_duracion')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row my-4">
            <div class="col offset-1 col-10">
                <label for="" class="mb-1">* Institución:</label>
                @if($movilidad->nac_ext == 0)
                <select class="form-select border-dark" name="inst_ent_nacs" id="inst_ent_nacs">
                    <option value="" selected>-- Institución --</option>
                    @foreach ($instituciones as $institucion)
                        <option value="{{ $institucion->id }}" {{ old('inst_ent_nac') == $institucion->id ? 'selected': '' }}>{{ strtoupper($institucion->nombre) }}</option>
                    @endforeach
                </select>
                @error('inst_ent_nacs')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
                @else
                <select class="form-select border-dark" name="inst_ent_ints" id="inst_ent_ints">
                    <option value="" selected>-- Institución --</option>
                    @foreach ($instituciones as $institucion)
                        <option value="{{ $institucion->id }}" {{ old('inst_ent_int') == $institucion->id ? 'selected': '' }}>{{ strtoupper($institucion->nombre) }}</option>
                    @endforeach
                </select>
                @error('inst_ent_ints')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
                @endif   
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-10">
                <label for="" class="mb-1">Documentación de soporte (solo si se requiere):</label>
                <input type="file" class="form-control border border-dark " multiple name="doc_soporte[]" id="doc_soporte" >
                @error('doc_soporte')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <input type="hidden" name="movilidad" id="movilidad" value="{{ $movilidad->id }}">
        <div class="row mt-4 mb-5">
            <div class="offset-1 col-2">
                @if ($movilidad->nac_ext == 0)
                    <a href="{{ route('movilidades_nac.index') }}" class="text-decoration-none text-danger">Regresar</a>
                @else
                    <a href="{{ route('movilidades_int.index') }}" class="text-decoration-none text-danger">Regresar</a>
                @endif
            </div>
            <div class="offset-5 col-3">
                <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Registrar</button>
            </div>
        </div>
    </form>
@endif
@endsection