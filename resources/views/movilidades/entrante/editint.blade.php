@extends('layouts.inst_conv_mov')
@section('title', 'Edicion Movilidad Entrante Internacional')

@section('content')
    <form  action="{{ route('movilidadIntEnt.update', $moventr) }}" method="POST"  class="form-mov border border-2 rounded-3 shadow-lg"  style="width: 70%" >
        @csrf
        @method('PUT')
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori"> Edicion de Movilidad Entrante Internacional</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <select  class="form-select border border-dark" name="mie_adminstudoc" id="mie_adminstudoc" onchange="activateDegreeMIE()">
                    <option value="" selected>-- * Tipo de persona --</option>
                    <option value="Administrativo" {{ $moventr->tipoPersona == "Administrativo" ? "selected": ""}}>Administrativo</option>
                    <option value="Estudiante" {{ $moventr->tipoPersona == "Estudiante" ? "selected": ""}}>Estudiante</option>
                    <option value="Docente" {{ $moventr->tipoPersona == "Docente" ? "selected": ""}}>Docente</option>
                </select>
                @error('mie_adminstudoc')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-5">
                <select class="form-select border border-dark" name="mie_instent" id="mie_instent">
                    <option value="" selected>-- * Institución o Entidad origen --</option>
                    @foreach ($instEnt as $item)
                    <option value="{{ $item->id }}" {{ $moventr->instEnt_id == $item->id ? 'selected' : '' }}> {{ $item->nombre }}</option>
                @endforeach
                </select>
                @error('mie_instent')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-2">
                <select class="form-select border border-dark" name="mie_activo" id="mie_activo" value="{{$moventr->activo}}">
                    <option value="" selected>-- * Activo en la INST/ENT --</option>
                    <option value="Sí" {{ $moventr->activo == "Sí" ? "selected": ""}}>Sí</option>
                    <option value="No" {{ $moventr->activo == "No" ? "selected": ""}}>No</option>
                </select>
                @error('mie_activo')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="row mt-2">
                    <div class="offset-1 col-2">
                        <select class="form-select border border-dark" name="mie_colInd" id="mie_colInd" required onchange="activateIndColMovIntEnt()">
                            <option value="" selected>-- * Colectivo o Individual --</option>
                            <option value="Colaborativo" {{ $moventr->colInd == "Colaborativo" ? "selected": ""}}>Colectivo</option>
                            <option value="Individual" {{ $moventr->colInd == "Individual" ? 'selected': '' }}>Individual</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Nombre completo..." title="Solo se habilitará para Individual" disabled name="mie_fullname" id="mie_fullname" value="{{ $moventr->fullname }}" >
                    </div>
                    <div class="col-2">
                        <input type="number" class="form-control border border-dark" placeholder="Cantidad..." title="Solo se habilitará para Colectivo" disabled name="mie_cantidad" id="mie_cantidad" value="{{ $moventr->cantidad }}">
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control border border-dark" placeholder="Titulos obtenidos..." title="Solo se habilitará para Docentes" disabled name="mie_titulos" id="mie_titulos" value="{{  $moventr->titulosOb }}" >
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-3">
                <label for="" class="mb-1">* Fecha de la movilidad: </label>
                <input type="date" class="form-control border border-dark" name="mie_fecha" id="mie_fecha" value="{{  $moventr-> fecha }}">
                @error('mie_fecha')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-3">
                <label for="" class="mb-1">* Vigencia de la movilidad: </label>
                <input type="date" class="form-control border border-dark" name="mie_vigencia" id="mie_vigencia" value="{{  $moventr-> vigencia }}">
                @error('mie_vigencia')
                    <span class="text-danger">* {{$message}}</span>
                @enderror
            </div>
            <div class="col-4">
                <input type="text" class="form-control border border-dark" placeholder="Sede o regional" name="mie_sedereg" id="mie_sedereg"  value="{{  $moventr-> sedeReg }}"  >
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-5">
                <textarea class="form-control border border-dark" placeholder="Breve objeto..." name="mie_objeto" id="mie_objeto"  onkeyup="countCharsOb(this);" maxlength="600">{{ $moventr->objeto }}  </textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumOb">0/600</span>
                </div>
            </div>
            <div class="col-5">
                <textarea class="form-control border border-dark" placeholder="Resultado" name="mie_result" id="mie_result" onkeyup="countCharsAl(this);" maxlength="600">{{ $moventr->resultado }} </textarea>
                <div class="d-flex justify-content-end">
                    <span id="charNumAl">0/600</span>
                </div>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <div class="offset-1 col-2">
                <a href="{{ route('movilidades_ent_int.index') }}" class="text-danger text-decoration-none">Regresar</a>
            </div>
            <div class="offset-5 col-3">
              
                <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Actualizar</button>
            </div>
        </div>
        
    </form>
@endsection