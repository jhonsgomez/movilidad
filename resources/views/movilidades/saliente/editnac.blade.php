@extends('layouts.inst_conv_mov')
@section('title', 'Edicion Movilidad saliente Nacional')

@section('content')
    <form method="POST"  action="{{ route('movilidadNacSal.update', $movnacsal) }}"  class="border border-2 rounded-3 shadow-lg" style="width: 70%">
        @csrf
        @method('PUT')
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori"> Edicion de Movilidad Saliente Nacional</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <select  class="form-select border border-dark" name="mns_adminstudoc" id="mns_adminstudoc" onchange="activateDegreeMNS()">
                    <option value="" selected>-- * Tipo de persona --</option>
                    <option value="Administrativo" {{ $movnacsal->tipoPersona == "Administrativo" ? "selected": ""}}>Administrativo</option>
                    <option value="Estudiante" {{ $movnacsal->tipoPersona == "Estudiante" ? "selected": ""}}>Estudiante</option>
                    <option value="Docente" {{ $movnacsal->tipoPersona == "Docente" ? "selected": ""}}>Docente</option>
                </select>
                @error('mns_adminstudoc')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-5">
                <select class="form-select border border-dark" name="mns_instent" id="mns_instent ">
                    <option value="" selected>-- * Institución o Entidad origen --</option>
                    @foreach ($instEnt as $item)
                    <option value="{{ $item->id }}" {{ $movnacsal->instEnt_id == $item->id ? 'selected' : '' }}> {{ $item->nombre }}</option>
                @endforeach
                </select>
                @error('mns_instent')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-2">
                <select class="form-select border border-dark" name="mns_activo" id="mns_activo">
                    <option value="" selected>-- * Activo en la INST/ENT --</option>
                    <option value="Sí" {{ $movnacsal->activo == "Sí" ? "selected": ""}}>Sí</option>
                    <option value="No" {{ $movnacsal->activo == "No" ? "selected": ""}}>No</option>
                </select>
                @error('mns_activo')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="row mt-2">
                    <div class="offset-1 col-2">
                        <select class="form-select border border-dark" name="mns_colInd" id="mns_colInd" required onchange="activateIndColMovNacSal()">
                            <option value="" selected>-- * Colectivo o Individual --</option>
                            <option value="Colaborativo" {{ $movnacsal->colInd == "Colaborativo" ? "selected": ""}}>Colectivo</option>
                            <option value="Individual" {{ $movnacsal->colInd == "Individual" ? 'selected': '' }}>Individual</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Nombre completo..." title="Solo se habilitará para Individual" disabled name="mns_fullname" id="mns_fullname" value="{{ $movnacsal->fullname }}" >
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control border border-dark" placeholder="Cantidad..." title="Solo se habilitará para Colectivo" disabled name="mns_cantidad" id="mns_cantidad" value="{{ $movnacsal->cantidad }}">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Titulos obtenidos..." title="Solo se habilitará para Docentes" disabled name="mns_titulos" id="mns_titulos" value="{{  $movnacsal->titulosOb}}" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <label for="" class="mb-1">* Fecha de la movilidad: </label>
                <input type="date" class="form-control border border-dark" name="mns_fecha" id="mns_fecha" value="{{  $movnacsal->fecha }}">
                @error('mns_fecha')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-3">
                <label for="" class="mb-1">* Vigencia de la movilidad: </label>
                <input type="date" class="form-control border border-dark" name="mns_vigencia" id="mns_vigencia" value="{{  $movnacsal->vigencia }}">
                @error('mns_vigencia')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-4">
                <input type="text" class="form-control border border-dark" placeholder="Sede o regional" name="mns_sedereg" id="mns_sedereg"  value="{{  $movnacsal->sedeReg }}"  >
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-5">
                <textarea class="form-control border border-dark" placeholder="Breve objeto..." name="mns_objeto" id="mns_objeto" onkeyup="countCharsOb(this);" maxlength="600">{{  $movnacsal->objeto  }}</textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumOb">0/600</span>
                </div>
            </div>
            <div class="col-5">
                <textarea class="form-control border border-dark" placeholder="Resultado" name="mns_result" id="mns_result" onkeyup="countCharsAl(this);" maxlength="600">{{  $movnacsal->resultado  }}</textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumAl">0/600</span>
                </div>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="offset-1 col-2">
                <a href="{{ route('login.activites') }}" class="text-danger text-decoration-none">Regresar</a>
            </div>
            <div class="offset-5 col-3">
                <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Actualizar</button>
            </div>
        </div>
    </form>
@endsection     