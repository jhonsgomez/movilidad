@extends('layouts.inst_conv_mov')
@section('title', 'ORI UTS - Registrar Movilidad')

@section('content')
<form method="POST" class="form-movilidades form-conv-nac border border-2 rounded-3 shadow-lg mt-5 mb-5"
    action="{{ route('movilidades.save') }}" enctype="multipart/form-data">
    @csrf
    <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            @if ($nivel == 0)
                <h4 class="text-center" id="ori">Registrar Movilidad Nacional</h4>
            @else
                <h4 class="text-center" id="ori">Registrar Movilidad Internacional</h4>
            @endif
        </div>
    </div>

    <input type="hidden" name="nac_ext" id="nac_ext" value="{{ $nivel }}">

    <div class="row mt-4">
        <div class="col offset-1">
            <label for="myCheckbox" class="mb-3">
                ¿Tiene convenio asociado?
                <input type="checkbox" id="myCheckbox">
            </label>
        </div>
        <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
            <select class="form-select border-dark" name="convenio_id" id="convenio_id" style="display: none;">
                <option value="" disabled selected>-- Seleccione un convenio --</option>
                @foreach ($convenios as $convenio)
                    <option value="{{ $convenio->id }}" {{ old('convenio_id') == $convenio->id ? 'selected' : '' }}>
                        {{ ucfirst(strtolower($convenio->tipo)) }} | UTS - {{ strtoupper($convenio->institucion) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col offset-1">
            <label for="" class="mb-1">* Tipo:</label>
            <select class="form-select border-dark" name="ent_sal" id="ent_sal">
                <option value="" selected>-- Tipo de movilidad --</option>
                <option value="0" {{ old('ent_sal') == "0" ? 'selected' : '' }}>Entrante</option>
                <option value="1" {{ old('ent_sal') == "1" ? 'selected' : '' }}>Saliente</option>
            </select>
            @error('ent_sal')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
        <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
            <label for="" class="mb-1">* Documento:</label>
            <input type="number" name="documento" id="documento" class="w-md-auto w-100 form-control border border-dark"
                value="{{ old('documento') }}">
            @error('documento')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row mt-4">
        <div class="col offset-1">
            <label for="" class="mb-1">* Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="w-md-auto w-100 form-control border border-dark"
                value="{{ old('nombre') }}">
            @error('nombre')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
        <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
            <label for="" class="mb-1">* Tipo de persona:</label>
            <select class="form-select border-dark" name="tipo_persona" id="tipo_persona">
                <option value="" selected>-- Tipo de persona --</option>
                <option value="Estudiante" {{ old('tipo_persona') == "Estudiante" ? 'selected' : '' }}>Estudiante</option>
                <option value="Profesor" {{ old('tipo_persona') == "Profesor" ? 'selected' : '' }}>Profesor</option>
                <option value="Administrativo" {{ old('tipo_persona') == "Administrativo" ? 'selected' : '' }}>
                    Administrativo</option>
            </select>
            @error('tipo_persona')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row mt-4">
        <div class="col offset-1">
            <label for="" class="mb-1">* País:</label>
            <input type="text" name="pais" id="pais" class="w-md-auto w-100 form-control border border-dark"
                value="{{ old('pais') }}">
            @error('pais')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
        <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
            <label for="" class="mb-1">* Tipo:</label>
            <select class="form-select border-dark" name="actividad" id="actividad">
                <option value="" selected>-- Tipo de actividad --</option>
                <option value="Clase Espejo" {{ old('actividad') == "Clase Espejo" ? 'selected' : '' }}>Clase Espejo
                </option>
                <option value="Webinar" {{ old('actividad') == "Webinar" ? 'selected' : '' }}>Webinar</option>
                <option value="Seminario" {{ old('actividad') == "Seminario" ? 'selected' : '' }}>Seminario</option>
                <option value="Foros" {{ old('actividad') == "Foros" ? 'selected' : '' }}>Foros</option>
                <option value="Capacitación" {{ old('actividad') == "Capacitación" ? 'selected' : '' }}>Capacitación
                </option>
                <option value="Congreso" {{ old('actividad') == "Congreso" ? 'selected' : '' }}>Congreso</option>
                <option value="Otra" {{ old('actividad') == "Otra" ? 'selected' : '' }}>Otra</option>
            </select>
            @error('actividad')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="row mt-4">
        <div class="offset-1 col">
            <label for="" class="mb-1">* Modalidad:</label>
            <select class="w-md-auto w-100 form-select border-dark" name="pres_virt" id="pres_virt">
                <option value="" selected>-- Tipo de modalidad --</option>
                <option value="0" {{ old('pres_virt') == "0" ? 'selected' : '' }}>Presencial</option>
                <option value="1" {{ old('pres_virt') == "1" ? 'selected' : '' }}>Virtual</option>
            </select>
            @error('pres_virt')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
        <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
            <label for="" class="mb-1">* ¿Dónde se realizó?</label>
            <input type="text" name="entidad" id="entidad" class="w-md-auto w-100 form-control border border-dark"
                value="{{ old('entidad') }}">
            @error('entidad')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="row mt-4">
        <div class="offset-1 col-10">
            <label for="" class="mb-1">* Descripción:</label>
            <textarea class="form-control border border-dark" placeholder="Descripción de la actividad... "
                id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
    </div>



    <div class="row mt-4">
        <div class="col offset-1">
            <label for="" class="mb-1">* Objeto:</label>
            <textarea class="form-control border border-dark" placeholder="Objeto de la movilidad... " id="objeto"
                name="objeto">{{ old('objeto') }}</textarea>
            @error('objeto')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
        <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
            <label for="" class="mb-1">* Resultados:</label>
            <textarea class="form-control border border-dark" placeholder="Resultados de la movilidad... "
                id="resultados" name="resultados">{{ old('resultados') }}</textarea>
            @error('resultados')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="row mt-4">
        <div class="col offset-1">
            <label for="" class="mb-1">Responsable:</label>
            <input type="text" name="responsable" id="responsable"
                class="w-md-auto w-100 form-control border border-dark" value="{{ old('responsable') }}">
            @error('responsable')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
        <div class="col offset-md-0 offset-1" style="margin-right: 8% !important; margin-left: 1.5% !important;">
            <label for="" class="mb-1">* Fecha de inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control border border-dark"
                value="{{ old('fecha_inicio') }}">
            @error('fecha_inicio')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-10 offset-1">
            <label for="" class="mb-1">* Fecha final:</label>
            <input type="date" name="fecha_final" id="fecha_final" class="form-control border border-dark"
                value="{{ old('fecha_final') }}">
            @error('fecha_final')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-10 offset-1">
            <label for="" class="mb-1">Documentación de soporte:</label>
            <input type="file" class="form-control border border-dark " multiple name="doc_soporte[]" id="doc_soporte">
            @error('doc_soporte')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <div class="offset-1 col-2">
            <a href="{{ route('login.activites') }}" class="text-decoration-none text-danger">Regresar</a>
        </div>
        <div class="offset-5 col-3">
            <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Registrar</button>
        </div>
    </div>
</form>

<script>
    const checkbox = document.getElementById('myCheckbox');
    const select = document.getElementById('convenio_id');

    checkbox.addEventListener('change', function () {
        if (checkbox.checked) {
            select.style.display = 'inline-block';
            select.required = true;
        } else {
            select.style.display = 'none';
            select.required = false;
            select.value = "";
        }
    });
</script>
@endsection