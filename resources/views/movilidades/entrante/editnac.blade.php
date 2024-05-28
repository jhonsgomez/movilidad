@extends('layouts.inst_conv_mov')
@section('title', 'Edicion Movilidad Entrante Nacional')

@section('content')
    <form method="POST"  action="{{ route('movilidadNacEnt.update', $movnaent ) }}"  class="border border-2 rounded-3 shadow-lg" style="width: 70%">
        @csrf
        @method('PUT')
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori"> Edicion de Movilidad Entrante Nacional</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <select  class="form-select border border-dark" name="mne_adminstudoc" id="mne_adminstudoc" onchange="activateDegreeMNE()">
                    <option value="" selected>-- * Tipo de persona --</option>
                    <option value="Administrativo" {{ $movnaent->tipoPersona == "Administrativo" ? "selected": ""}}>Administrativo</option>
                    <option value="Estudiante" {{ $movnaent->tipoPersona == "Estudiante" ? "selected": ""}}>Estudiante</option>
                    <option value="Docente" {{ $movnaent->tipoPersona == "Docente" ? "selected": ""}}>Docente</option>
                </select>
                @error('mne_adminstudoc')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-5">
                <select class="form-select border border-dark" name="mne_instent" id="mne_instent ">
                    <option value="" selected>-- * Institución o Entidad origen --</option>
                    @foreach ($instEnt as $item)
                    <option value="{{ $item->id }}" {{ $movnaent->instEnt_id == $item->id ? 'selected' : '' }}> {{ $item->nombre }}</option>
                @endforeach
                </select>
                @error('mne_instent')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-2">
                <select class="form-select border border-dark" name="mne_activo" id="mne_activo">
                    <option value="" selected>-- * Activo en la INST/ENT --</option>
                    <option value="Sí" {{ $movnaent->activo == "Sí" ? "selected": ""}}>Sí</option>
                    <option value="No" {{ $movnaent->activo == "No" ? "selected": ""}}>No</option>
                </select>
                @error('mne_activo')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="row mt-2">
                    <div class="offset-1 col-2">
                        <select class="form-select border border-dark" name="mne_colInd" id="mne_colInd" required onchange="activateIndColMovNacEnt()">
                            <option value="" selected>-- * Colectivo o Individual --</option>
                            <option value="Colaborativo" {{ $movnaent->colInd == "Colaborativo" ? "selected": ""}}>Colectivo</option>
                            <option value="Individual" {{ $movnaent->colInd == "Individual" ? 'selected': '' }}>Individual</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Nombre completo..." title="Solo se habilitará para Individual" disabled name="mne_fullname" id="mne_fullname" value="{{ $movnaent->fullname }}" >
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control border border-dark" placeholder="Cantidad..." title="Solo se habilitará para Colectivo" disabled name="mne_cantidad" id="mne_cantidad" value="{{ $movnaent->cantidad }}">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Titulos obtenidos..." title="Solo se habilitará para Docentes" disabled name="mne_titulos" id="mne_titulos" value="{{  $movnaent-> titulosOb}}" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <label for="" class="mb-1">* Fecha de la movilidad: </label>
                <input type="date" class="form-control border border-dark" name="mne_fecha" id="mne_fecha" value="{{  $movnaent->fecha }}">
                @error('mne_fecha')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-3">
                <label for="" class="mb-1">* Vigencia de la movilidad: </label>
                <input type="date" class="form-control border border-dark" name="mne_vigencia" id="mne_vigencia" value="{{  $movnaent->vigencia }}">
                @error('mne_vigencia')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-4">
                <input type="text" class="form-control border border-dark" placeholder="Sede o regional" name="mne_sedereg" id="mne_sedereg"  value="{{  $movnaent->sedeReg }}"  >
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-5">
                <textarea class="form-control border border-dark" placeholder="Breve objeto..." name="mne_objeto" id="mne_objeto" onkeyup="countCharsOb(this);" maxlength="600">{{  $movnaent->objeto  }}</textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumOb">0/600</span>
                </div>
            </div>
            <div class="col-5">
                <textarea class="form-control border border-dark" placeholder="Resultado" name="mne_result" id="mne_result" onkeyup="countCharsAl(this);" maxlength="600">{{  $movnaent->resultado  }}</textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumAl">0/600</span>
                </div>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="offset-1 col-2">
                <a href="{{ route('movilidades_ent_nac.index') }}" class="text-danger text-decoration-none">Regresar</a>
            </div>
            <div class="offset-5 col-3">
                <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Registrar</button>
            </div>
        </div>
    </form>
@endsection