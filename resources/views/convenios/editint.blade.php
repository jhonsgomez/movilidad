@extends('layouts.inst_conv_mov')
@section('title', 'Edición Convenios')

@section('content')
<form method="POST" action="{{ route('convenios_int.update', $convs) }}" class="form-conv-nac border border-2 rounded-3 shadow-lg mt-5 mb-5"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            <h4 class="text-center" id="ori">Edición Convenio Internacional</h4>
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <select class="form-select border border-dark" id="conv_instEntInt" name="conv_instEntInt">
                <option selected value="">-- * Institución o Entidad --</option>
                @foreach ($instEntInt as $item)
                    <option value="{{ $item->id }}" {{ $convs->instEntInt_id == $item->id ? 'selected' : '' }}> {{ $item->nombre }}</option>
                @endforeach
            </select>
            @error('conv_instEntInt')
                <span class="text-danger">*{{ $message }}</span>    
            @enderror
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <select class="form-select border-dark" name="conv_tipo" id="conv_tipo">
                <option value="" selected>-- * Tipo de convenio --</option>
                <option value="Practicas" {{ $convs->tipo == 'Practicas' ? 'selected': '' }}>Practicas</option>
                <option value="Interadministrativo" {{ $convs->tipo == 'Interadministrativo' ? 'selected': '' }}>Interadministrativo</option>
                <option value="Especifico" {{ $convs->tipo == 'Especifico' ? 'selected': ''}}>Especifico</option>
                <option value="Marco" {{ $convs->tipo == 'Marco' ? 'selected': ''}}>Marco</option>
            </select>
            @error('conv_tipo')
                <span class="text-danger">*{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
        <textarea class="form-control border border-dark" placeholder="* Breve descripcion del convenio... " id="conv_objeto" name="conv_objeto">{{ ucfirst(strtolower($convs->breve_objeto)) }}</textarea>
            @error('conv_objeto')
                <span class="text-danger">*{{ $message }}</span>    
            @enderror
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
        <textarea class="form-control border border-dark" placeholder="* Resultados del convenio (movilidad, financiacion de proyectos, publicaciones, etc.)" id="conv_result" name="conv_result">{{ ucfirst(strtolower($convs->resultados_concretos)) }}</textarea>
            @error('conv_result')
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
                    <input type="date" class="form-control border border-dark" id="conv_fechaInicio" name="conv_fechaInicio" value="{{ $convs->fechaInicio }}">
                    @error('conv_fechaInicio')
                        <span class="text-danger">*{{ $message }}</span>    
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <label for="">* Vigencia del convenio:</label>
            <input type="date" class="form-control border border-dark" id="conv_vigencia" name="conv_vigencia" value="{{ $convs->vigencia }}">
            @error('conv_vigencia')
                <span class="text-danger">*{{ $message }}</span>    
            @enderror
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <label for="" class="mb-1">* N° de usuarios (dejar vacío si no aplica):</label>
            <input type="number" class="form-control border border-dark" name="conv_nUsuarios" id="conv_nUsuarios" value="{{ $convs->n_usuarios }}">
            @error('conv_nUsuarios')
                <span class="text-danger">*{{ $message }}</span>    
            @enderror
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <input type="text" class="form-control border border-dark" placeholder="* Supervisor..." id="conv_super" name="conv_super" value="{{ ucwords(strtolower($convs->supervisor)) }}">
            @error('conv_super')
                <span class="text-danger">*{{ $message }}</span>    
            @enderror
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <select class="form-select border border-dark" name="conv_activo" id="conv_activo">
                <option selected value="">-- Activo --</option>
                <option value="Sí" {{ $convs->activo == "Sí" ? "selected": '' }}>Sí</option>
                <option value="No" {{ $convs->activo == "No" ? "selected": '' }}>No</option>
            </select>
        </div>
    </div> 
    <div class="row mt-4 mb-5">
            <div class="offset-1 col-2">
                <a  href="{{ route('convenios.show_int') }}" class="text-danger text-decoration-none">Regresar</a>
            </div>
        <div class="offset-5 col-3">
            <button type="submit" class="w-100 btn_1 btn-primary rounded-pill border border-dark">Editar</button>
        </div>
    </div>
</form>
@endsection