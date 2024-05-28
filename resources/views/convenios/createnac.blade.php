@extends('layouts.inst_conv_mov')
@section('title', 'Registro Convenios')

@section('content')
@if (auth()->user()->rol_id == '1' or auth()->user()->rol_id == "2" or auth()->user()->rol_id == "6")
    <form method="POST" class="form-conv-nac border border-2 rounded-3 shadow-lg mt-5 mb-5" action="{{ route('convenios.store_nac') }}" enctype="multipart/form-data">
        @csrf
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori">Registro Convenio Nacional</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <select class="form-select border border-dark" id="con_instEntNac" name="con_instEntNac">
                    <option selected value="">-- * Institución o Entidad --</option>
                    @foreach ($instEntNacs as $item)
                        <option value="{{ $item->id }}" {{ old('con_instEntNac') == $item->id ? 'selected': '' }}> {{ strtoupper($item->nombre) }}</option>
                    @endforeach
                </select>
                @error('con_instEntNac')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <select class="form-select border-dark" name="conv_tipoNac" id="conv_tipoNac">
                    <option value="" selected>-- * Tipo de convenio --</option>
                    <option value="Practicas" {{ old('conv_tipo') == "Practicas" ? 'selected': '' }}>Practicas</option>
                    <option value="Interadministrativo" {{ old('conv_tipo') == "Interadministrativo" ? 'selected': '' }}>Interadministrativo</option>
                    <option value="Especifico" {{ old('conv_tipoNac') == "Especifico" ? 'selected': '' }}>Especifico</option>
                    <option value="Marco" {{ old('conv_tipoNac') == "Marco" ? 'selected': '' }}>Marco</option>
                </select>
                @error('conv_tipoNac')
                    <span class="text-danger">*{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
            <textarea class="form-control border border-dark" placeholder="* Breve descripcion del convenio... " id="conv_objetoNac" name="conv_objetoNac">{{ old('conv_objetoNac') }}</textarea>
                @error('conv_objetoNac')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
            <textarea class="form-control border border-dark" placeholder="* Resultados del convenio (movilidad, financiacion de proyectos, publicaciones, etc.)" id="conv_resultNac" name="conv_resultNac">{{ old('conv_resultNac') }}</textarea>
                @error('conv_resultNac')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-10 mt-3">
                <div class="row">
                    <div class="col">
                        <label for="">* Fecha de inicio: </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col mt-1">
                        <input type="date" class="form-control border border-dark" id="conv_fechaInicioNac" name="conv_fechaInicioNac" value="{{ old('conv_fechaInicioNac') }}">
                        @error('conv_fechaInicioNac')
                            <span class="text-danger">*{{ $message }}</span>    
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="offset-1 col-10">
                <label for="" class="mb-1">* Fecha de Vigencia:</label>
                <input type="date" class="form-control border border-dark" id="conv_vigenciaNac" name="conv_vigenciaNac" value="{{ old('conv_vigenciaNac') }}">
                @error('conv_vigenciaNac')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <label for="" class="mb-1">* N° de usuarios (dejar en 0 si no aplica):</label>
                <input type="number" class="form-control border border-dark" name="conv_nUsuariosNac" id="conv_nUsuariosNac" value="{{ old('conv_nUsuariosNac') }}">
                @error('conv_nUsuariosNac')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <input type="text" class="form-control border border-dark" placeholder="* Supervisor del convenio (ej: Ing. Juan Peréz)..." id="conv_superNac" name="conv_superNac" value="{{ old('conv_superNac') }}">
                @error('conv_superNac')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        

        
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <h6 class="text-center border rounded-3 titles pt-2 pb-2">Documentación Soporte</h6>
            </div>
        </div>
        <div class="row mt-3">
            <div class="offset-1 col-10">
                <input type="file" class="form-control border border-dark " multiple name="conv_docsoporteNac[]" id="conv_docsoporteNac" >
                <span for="">* Nota: Se debe cargar al menos la Minuta.</span>
                @error('conv_docsoporteNac')
                    <br><span style="color: red">* {{ $message }}</span>    
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