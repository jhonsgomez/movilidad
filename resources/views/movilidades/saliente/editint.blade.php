@extends('layouts.inst_conv_mov')
@section('title', 'Edicion Movilidad saliente Internacional')

@section('content')
    <form method="POST"  action="{{ route('movilidadIntSal.update',  $movintsal) }}"  class="border border-2 rounded-3 shadow-lg" style="width: 70%">
        @csrf
        @method('PUT')
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori"> Edicion de Movilidad Saliente Internacional</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <select  class="form-select border border-dark" name="mis_adminstudoc" id="mis_adminstudoc" onchange="activateDegreeMIS()">
                    <option value="" selected>-- * Tipo de persona --</option>
                    <option value="Administrativo" {{ $movintsal->tipoPersona == "Administrativo" ? "selected": ""}}>Administrativo</option>
                    <option value="Estudiante" {{ $movintsal->tipoPersona == "Estudiante" ? "selected": ""}}>Estudiante</option>
                    <option value="Docente" {{ $movintsal->tipoPersona == "Docente" ? "selected": ""}}>Docente</option>
                </select>
                @error('mis_adminstudoc')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-5">
                <select class="form-select border border-dark" name="mis_instent" id="mis_instent ">
                    <option value="" selected>-- * Institución o Entidad origen --</option>
                    @foreach ($instEnt as $item)
                    <option value="{{ $item->id }}" {{ $movintsal->instEnt_id == $item->id ? 'selected' : '' }}> {{ $item->nombre }}</option>
                @endforeach
                </select>
                @error('mis_instent')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-2">
                <select class="form-select border border-dark" name="mis_activo" id="mis_activo" value="{{$movintsal->activo}}">
                    <option value="" selected>-- * Activo en la INST/ENT --</option>
                    <option value="Sí" {{ $movintsal->activo == "Sí" ? "selected": ""}}>Sí</option>
                    <option value="No" {{ $movintsal->activo == "No" ? "selected": ""}}>No</option>
                </select>
                @error('mis_activo')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="row mt-2">
                    <div class="offset-1 col-2">
                        <select class="form-select border border-dark" name="mis_colInd" id="mis_colInd" required onchange="activateIndColMovIntSal()">
                            <option value="" selected>-- * Colectivo o Individual --</option>
                            <option value="Colaborativo" {{ $movintsal->colInd == "Colaborativo" ? "selected": ""}}>Colectivo</option>
                            <option value="Individual" {{ $movintsal->colInd == "Individual" ? 'selected': '' }}>Individual</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Nombre completo..." title="Solo se habilitará para Individual" disabled name="mis_fullname" id="mis_fullname" value="{{ $movintsal->fullname }}" >
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control border border-dark" placeholder="Cantidad..." title="Solo se habilitará para Colectivo" disabled name="mis_cantidad" id="mis_cantidad" value="{{ $movintsal->cantidad }}">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Titulos obtenidos..." title="Solo se habilitará para Docentes" disabled name="mis_titulos" id="mis_titulos" value="{{  $movintsal-> titulosOb}}" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <label for="" class="mb-1">* Fecha de la movilidad: </label>
                <input type="date" class="form-control border border-dark" name="mis_fecha" id="mis_fecha" value="{{  $movintsal->fecha }}">
                @error('mis_fecha')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-3">
                <label for="" class="mb-1">* Vigencia de la movilidad: </label>
                <input type="date" class="form-control border border-dark" name="mis_vigencia" id="mis_vigencia" value="{{  $movintsal->vigencia }}">
                @error('mis_vigencia')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-4">
                <input type="text" class="form-control border border-dark" placeholder="Sede o regional" name="mis_sedereg" id="mis_sedereg"  value="{{  $movintsal->sedeReg }}"  >
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-5">
                <textarea class="form-control border border-dark" placeholder="Breve objeto..." name="mis_objeto" id="mis_objeto" onkeyup="countCharsOb(this);" maxlength="600"> {{  $movintsal->objeto  }}</textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumOb">0/600</span>
                </div>
            </div>
            <div class="col-5">
                <textarea class="form-control border border-dark" placeholder="Resultado" name="mis_result" id="mis_result" onkeyup="countCharsAl(this);" maxlength="600">{{  $movintsal->resultado  }} </textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumAl">0/600</span>
                </div>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="offset-1 col-2">
                <a href="{{ route('movilidades_sal_int.index') }}" class="text-danger text-decoration-none">Regresar</a>
            </div>
            <div class="offset-5 col-3">
                <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Actualizar</button>
            </div>
        </div>
    </form>
@endsection