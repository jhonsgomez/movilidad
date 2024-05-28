@extends('layouts.inst_conv_mov')
@section('title', 'Registro Movilidad Saliente Nacional')

@section('content')
    <form action="{{ route('movilidadNacSal.store') }}" method="POST" class="border border-2 rounded-3 shadow-lg" style="width: 70%">
        @csrf
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori">Movilidad Saliente Nacional</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <select  class="form-select border border-dark" name="mns_adminstudoc" id="mns_adminstudoc" onchange="activateDegreeMNS()">
                    <option value="" selected>-- Tipo de persona --</option>
                    <option value="Administrativo" {{ old('mns_adminstudoc') == "Administrativo" ? 'selected': '' }}>Administrativo</option>
                    <option value="Estudiante" {{ old('mns_adminstudoc') == "Estudiante" ? 'selected': '' }}>Estudiante</option>
                    <option value="Docente" {{ old('mns_adminstudoc') == "Docente" ? 'selected': '' }}>Docente</option>
                </select>
                @error('mns_adminstudoc')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-5">
                <select class="form-select border border-dark" name="mns_instent" id="mns_instent">
                    <option value="" selected>-- Institución o Entidad destino --</option>
                    @foreach ($instEnt as $item)
                        <option value="{{ $item->id }}" {{ old('mns_instent') == $item->id ? 'selected': '' }}>{{ $item->nombre }}</option>
                    @endforeach
                </select>
                @error('mns_instent')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-2">
                <select class="form-select border border-dark" name="mns_activo" id="mns_activo">
                    <option value="" selected>-- Activo en la INST/ENT --</option>
                    <option value="Sí" {{ old('mns_activo') == "Sí" ? 'selected': '' }}>Sí</option>
                    <option value="No" {{ old('mns_activo') == "No" ? 'selected': '' }}>No</option>
                </select>
                @error('mns_activo')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="col">
                <div class="row mt-1">
                    <div class="offset-1 col-2">
                        <select class="form-select border border-dark" name="mns_colInd" id="mns_colInd" required onchange="activateIndColMovNacSal()">
                            <option value="" selected>-- * Colectivo o Individual --</option>
                            <option value="colaborativo" {{ old('mns_colInd') == "colaborativo" ? 'selected': '' }}>Colectivo</option>
                            <option value="individual" {{ old('mns_colInd') == "individual" ? 'selected': '' }}>Individual</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Nombre completo..." title="Solo se habilitará para Individual" disabled name="mns_fullname" id="mns_fullname" value="{{ old('mns_fullname') }}" >
                        @error('mns_fullname')
                            <span class="text-danger">* {{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control border border-dark" placeholder="Cantidad..." title="Solo se habilitará para Colectivo" disabled name="mns_cantidad" id="mns_cantidad" value="{{ old('mns_cantidad') }}">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Titulos obtenidos..." disabled title="Solo se habilitará para Docentes" name="mns_titulos" id="mns_titulos" value="{{ old('mns_titulos') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <label for="" class="mb-1">* Fecha de la movilidad: </label>
                <input type="date" class="form-control border border-dark" name="mns_fecha" id="mns_fecha" value="{{ old('mns_fecha') }}">
                @error('mns_fecha')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-3">
                <label for="" class="mb-1">* Vigencia de la movilidad: </label>
                <input type="date" class="form-control border border-dark" name="mns_vigencia" id="mns_vigencia" value="{{ old('mns_vigencia') }}">
                @error('mns_vigencia')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-4">
                <input type="text" class="form-control border border-dark" placeholder="Sede o regional" name="mns_sedereg" id="mns_sedereg" value="{{ old('mns_sedereg') }}">
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-5">
                <textarea class="form-control border border-dark" placeholder="Breve objeto..." name="mns_objeto" id="mns_objeto" onkeyup="countCharsOb(this);" maxlength="600">{{ old('mns_objeto') }}</textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumOb">0/600</span>
                </div>
            </div>
            <div class="col-5">
                <textarea class="form-control border border-dark" placeholder="Resultado" name="mns_result" id="mns_result" onkeyup="countCharsAl(this);" maxlength="600">{{ old('mns_result') }}</textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumAl">0/600</span>
                </div>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="offset-1 col-2">
                <a href="https://unidadestecno-my.sharepoint.com/:f:/g/personal/movinal_correo_uts_edu_co/Eu9HzGQnLXFAhjstiRJDPKYBjbgOsjLkDr8dcGHfLRcBYQ?e=mmHqTr" class="btn btn-outline-success" target="_blank">Cargue de Evidencias</a>
                <br><br>

                <a href="{{ route('login.activites') }}" class="text-danger text-decoration-none">Regresar</a>
            </div>
            <div class="offset-5 col-3">
                <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Registrar</button>
            </div>
        </div>
    </form>
@endsection