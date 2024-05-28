@extends('layouts.inst_conv_mov')
@section('title', 'Registro Movilidad Entrante Nacional')

@section('content')
    <form action="{{ route('movilidadNacEnt.store') }}" method="POST" class="border border-2 rounded-3 shadow-lg" style="width: 70%">
        @csrf
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori">Movilidad Entrante Nacional</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <select  class="form-select border border-dark" name="mne_adminstudoc" id="mne_adminstudoc" onchange="activateDegreeMNE()">
                    <option value="" selected>-- * Tipo de persona --</option>
                    <option value="Administrativo" {{ old('mne_adminstudoc') == "Administrativo" ? 'selected': '' }}>Administrativo</option>
                    <option value="Estudiante" {{ old('mne_adminstudoc') == "Estudiante" ? 'selected': '' }}>Estudiante</option>
                    <option value="Docente" {{ old('mne_adminstudoc') == "Docente" ? 'selected': '' }}>Docente</option>
                </select>
                @error('mne_adminstudoc')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-5">
                <select class="form-select border border-dark" name="mne_instent" id="mne_instent">
                    <option value="" selected>-- * Institución o Entidad origen --</option>
                    @foreach ($instEnt as $item)
                        <option value="{{ $item->id }}" {{ old('mne_instent') == $item->id ? 'selected': '' }}>{{ $item->nombre }}</option>
                    @endforeach
                </select>
                @error('mne_instent')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-2">
                <select class="form-select border border-dark" name="mne_activo" id="mne_activo">
                    <option value="" selected>-- * Activo en la INST/ENT --</option>
                    <option value="Sí" {{ old('mne_activo') == "Sí" ? 'selected': '' }}>Sí</option>
                    <option value="No" {{ old('mne_activo') == "No" ? 'selected': '' }}>No</option>
                </select>
                @error('mne_activo')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="row mt-1">
                    <div class="offset-1 col-2">
                        <select class="form-select border border-dark" name="mne_colInd" id="mne_colInd" required onchange="activateIndColMovNacEnt()">
                            <option value="" selected>-- * Colectivo o Individual --</option>
                            <option value="Colaborativo" {{ old('mne_colInd') == "Colaborativo" ? 'selected': '' }}>Colectivo</option>
                            <option value="Individual" {{ old('mne_colInd') == "Individual" ? 'selected': '' }}>Individual</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Nombre completo..." title="Solo se habilitará para Individual" disabled name="mne_fullname" id="mne_fullname" value="{{ old('mne_fullname') }}" >
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control border border-dark" placeholder="Cantidad..." title="Solo se habilitará para Colectivo" disabled name="mne_cantidad" id="mne_cantidad" value="{{ old('mne_cantidad') }}">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Titulos obtenidos..." disabled title="Solo se habilitará para Docentes" name="mne_titulos" id="mne_titulos" value="{{ old('men_titulos') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <label for="" class="mb-1">* Fecha de la movilidad: </label>
                <input type="date" class="form-control border border-dark"  name="mne_fecha" id="mne_fecha" value="{{ old('mne_fecha') }}">
                @error('mne_fecha')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-3">
                <label for="" class="mb-1">* Vigencia de la movilidad: </label>
                <input type="date" class="form-control border border-dark" placeholder="* Vigencia..."  name="mne_vigencia" id="mne_vigencia" value="{{ old('mne_vigencia') }}">
                @error('mne_vigencia')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-4">
                <input type="text" class="form-control border border-dark" placeholder="Sede o regional" name="mne_sedereg" id="mne_sedereg" value="{{ old('mne_sedereg') }}">
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-5">
                <textarea class="form-control border border-dark" placeholder="Breve objeto..."  name="mne_objeto" id="mne_objeto" onkeyup="countCharsOb(this);" maxlength="600">{{ old('mne_objeto') }}</textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumOb">0/600</span>
                </div>
            </div>
            <div class="col-5">
                <textarea class="form-control border border-dark" placeholder="Resultado" name="mne_result" id="mne_result" onkeyup="countCharsAl(this);" maxlength="600">{{ old('mne_result') }}</textarea>
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