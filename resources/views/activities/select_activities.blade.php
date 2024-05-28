@extends('layouts.app')
@section('title', 'Actividades')

@section('act_content')
    <form name="f" action="" class="rounded shadow-lg act_form m-5">
        @csrf
        <img src="{{asset('images/index/header_login.jpg')}}" alt="" class="img-fluid m-0 rounded-top">
        
        @if (auth()->user()->rol_id == '5')
            {{-- Sección de coordinación un otras dependencias --}}
            <div class="row mt-3">
                <div class="col">
                    @if (auth()->user()->rol_id == '1')
                        <h4 class="text-center">Coordinacion</h4>
                    @elseif(auth()->user()->rol_id=='5')
                        <h4 class="text-center">Otras Dependencias</h4>
                    @endif
                </div>
            </div>
            <div class="offset-1 col-10 mt-1">
                <label for="" class="mb-1">Acción que desea realizar: </label>
                <select class="form-select border-dark" name="c_o_actions" id="c_o_actions" onchange="loadActions();">
                    <option value="">-- Seleccione una opción --</option>
                    <option value="registrar">Registrar</option>
                    <option value="consultar">Consultar</option>
                </select>
            </div>
            <div class="offset-1 col-10 mt-4">
                <label for="" class="mb-1">Institución, Convenio o Movilidad: </label>
                <select class="form-select border-dark" name="c_o_about_what" id="c_o_about_what">
                    <option value="">-- Seleccione una opción --</option>
                </select>
            </div>
            <div class="offset-1 col-10 mt-4">
                <label for="" class="mb-1">A nivel: </label>
                <select class="form-select border border-dark"  name="c_o_nacoInt" id="c_o_nacoInt">
                    <option value="">-- Seleccione una opción --</option>
                    <option value="internacional">Internacional</option>
                    <option value="nacional">Nacional</option>
                </select>
            </div>
            <div class="offset-1 col-10 mt-4">
                <label for="" class="mb-1">Entrante o Saliente: </label>
                <select class="form-select border border-dark"  name="c_o_entSal" id="c_o_entSal">
                    <option value="">-- Seleccione una opción --</option>
                    <option value="entrante">Entrante</option>
                    <option value="saliente">Saliente</option>
                </select>
            </div>
            {{-- Quitar cuando se realice las otra partes del CRUD de movilidad --}}
        
            <div class="offset-3 col-6 mt-5 mb-4">
                <button class="w-100 btn btn-primary rounded-pill border border-dark">Siguiente</button>
            </div>
            
        @elseif(auth()->user()->rol_id == '1' or auth()->user()->rol_id == '2' or auth()->user()->rol_id=='3' or auth()->user()->rol_id=='6')
            {{-- Sección de ORI y DIE --}}
            <div class="row mt-3">
                <div class="col">
                    @if (auth()->user()->rol_id == '2')
                        <h4 class="text-center">Oficina de Relaciones Interinstitucionales</h4>
                    @elseif(auth()->user()->rol_id=='1')
                        <h4 class="text-center">Coordinador</h4>
                    @elseif(auth()->user()->rol_id=='3')
                        <h4 class="text-center">Dirección de Investigación y Extensión</h4>
                    @elseif(auth()->user()->rol_id=='6')
                        <h4 class="text-center">Administrador</h4>
                    @endif
                </div>
            </div>
            <div class="form-row m-4 justify-content-around">
                <label for="" class="col">Acción que desea realizar: </label>
                <select class="col col-md-8 custom-select" name="actions" id="actions" required>
                    <option selected value="">&nbsp;&nbsp;Seleccione una opción</option>
                    <option value="registrar">&nbsp;&nbsp;Registrar</option>
                    <option value="consultar">&nbsp;&nbsp;Consultar</option>
                </select>
            </div>
            <div class="form-row m-4 justify-content-around">
                <label for="" class="col">¿Que área desea manejar? </label>
                @if(auth()->user()->rol_id == '1' or auth()->user()->rol_id == '2' or auth()->user()->rol_id=='3')
                <select class="col col-md-8 custom-select" name="about_what" id="about_what" onchange="activateNacInt();">
                @elseif(auth()->user()->rol_id=='6')
                <select class="col col-md-8 custom-select" name="about_what" id="about_what" required>
                @endif
                    <option selected value="">&nbsp;&nbsp;Seleccione una opción</option>
                    <option value="convenios">&nbsp;&nbsp;Convenios</option>
                    <option value="instituciones">&nbsp;&nbsp;Instituciones</option>
                    <option value="movilidad">&nbsp;&nbsp;Movilidadades</option>
                </select>
            </div>
            <div class="form-row m-4 justify-content-around">
                <label for="" class="col">A nivel: </label>
                @if(auth()->user()->rol_id == '2' or auth()->user()->rol_id=='3')
                <select class="col col-md-8 custom-select"  name="nacoInt" id="nacoInt" title="Solo se habilitará para registro de Movilidades o consultas en general">
                @elseif(auth()->user()->rol_id == '1' or auth()->user()->rol_id=='6')
                <select class="col col-md-8 custom-select"  name="nacoInt" id="nacoInt" title="Solo se habilitará para registro de Movilidades o consultas en general" required>
                @endif
                    <option value="">&nbsp;&nbsp;Seleccione una opción</option>
                    <option value="internacional">&nbsp;&nbsp;Internacional</option>
                    <option value="nacional">&nbsp;&nbsp;Nacional</option>
                </select>
            </div>
            <div class="form-row m-4 justify-content-around" id="type_convenio_container" style="display: none;">
                <label for="type_convenio" class="col">Tipo de convenio: </label>
                <select class="col col-md-8 custom-select" name="type_convenio" id="type_convenio" title="Tipo de convenio">
                    <option value="" selected>&nbsp;&nbsp; -- Tipo de convenio --</option>
                    <option value="Practicas">&nbsp;&nbsp;Practicas</option>
                    <option value="Marco">&nbsp;&nbsp;Marco</option>
                    <option value="Especifico">&nbsp;&nbsp;Específico</option>
                    <option value="Interadministrativo">&nbsp;&nbsp;Interadministrativo</option>
                </select>
            </div>
            <div class="row m-4 justify-content-around">
                <button class="btn btn-submit px-4 py-2" id="ori_enlace" type="submit">Siguiente&nbsp;<i class="bi bi-box-arrow-right"></i></button>
            </div>

        @elseif(auth()->user()->rol_id == '4')
            {{-- Secciona para decanatura --}}
            <div class="row mt-3">
                <div class="col">
                    <h4 class="text-center">Decanatura</h4>
                </div>
            </div>
            <div class="offset-1 col-10 mt-3">
                <label for="" class="mb-1">Acción que desea realizar: </label>
                <select class="form-select border-dark" name="dec_actions" id="dec_actions">
                    <option value="">-- Seleccione una opción --</option>
                    <option value="consultar">Consultar</option>
                </select>
            </div>
            {{-- Sobre que con restricciones de rol --}}
            <div class="offset-1 col-10 mt-4">
                <label for="" class="mb-1">Institución, Convenio o Movilidad: </label>
                <select class="form-select border-dark" name="dec_about_what" id="dec_about_what">
                    <option selected>-- Seleccione una opción --</option>
                    <option value="convenios">Convenio</option>
                    <option value="instituciones">Institución</option>
                    <option value="movilidad">Movilidad</option>
                </select>
            </div>
            <div class="offset-1 col-10 mt-4">
                <label for="" class="mb-1">A nivel: </label>
                <select class="form-select border border-dark"  name="dec_anacoInt" id="dec_anacoInt" disabled title="Solo se habilitará para registro de Movilidades o consultas en general">
                    <option value="">-- Seleccione una opción --</option>
                    <option value="internacional">Internacional</option>
                    <option value="nacional">Nacional</option>
                </select>
            </div>
            <div class="offset-1 col-10 mt-4">
                <label for="" class="mb-1">Entrante o Saliente: </label>
                {{-- Para modificar atributo disable ver index.js en la carpeta public --}}
                {{-- atributo title mediante onload y se encuentra en layouts.app --}}
                <select class="form-select border border-dark"  name="entSal" id="entSal" disabled title="Solo se habilitará en registro y consulta de Movilidades">
                    <option value="">-- Seleccione una opción --</option>
                    <option value="entrante">Entrante</option>
                    <option value="saliente">Saliente</option>
                </select>
            </div>
            <div class="row m-4 justify-content-center">
                <button class="btn btn-submit">Siguiente</button>
            </div>
        @endif
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const actionsSelect = document.getElementById('actions');
            const aboutWhatSelect = document.getElementById('about_what');
            const typeConvenioContainer = document.getElementById('type_convenio_container');
            const typeConvenioSelect = document.getElementById('type_convenio');

            function checkAndToggleTypeConvenio() {
                if (actionsSelect.value === 'consultar') {
                    if (aboutWhatSelect.value === 'convenios') {
                        typeConvenioContainer.style.display = 'flex';
                        typeConvenioSelect.required = true;
                    } else {
                        typeConvenioContainer.style.display = 'none';
                        typeConvenioSelect.required = false;
                    }
                } else {
                    typeConvenioContainer.style.display = 'none';
                    typeConvenioSelect.required = false;
                }
            }

            actionsSelect.addEventListener('change', function () {
                checkAndToggleTypeConvenio();
            });

            aboutWhatSelect.addEventListener('change', function () {
                checkAndToggleTypeConvenio();
            });
        });
    </script>
@endsection