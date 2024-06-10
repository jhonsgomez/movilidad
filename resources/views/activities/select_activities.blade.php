@extends('layouts.app')
@section('title', 'ORI UTS - Actividades')

@section('act_content')
    <form name="f" action="" class="rounded shadow-lg act_form m-5">
        @csrf
        <img src="{{asset('images/index/header_login.jpg')}}" alt="" class="img-fluid m-0 rounded-top">
        <div class="row mt-3">
            <div class="col">
                @if (auth()->user()->rol_id == '1')
                    <h4 class="text-center">Coordinador</h4>
                @elseif(auth()->user()->rol_id=='2')
                    <h4 class="text-center">Oficina de Relaciones Interinstitucionales</h4>      
                @elseif(auth()->user()->rol_id=='3')
                    <h4 class="text-center">Dirección de Investigación y Extensión</h4>
                @elseif(auth()->user()->rol_id=='4')
                    <h4 class="text-center">Decanatura</h4>
                @elseif(auth()->user()->rol_id=='5')
                    <h4 class="text-center">Bienvenido</h4>
                @elseif(auth()->user()->rol_id=='6')
                    <h4 class="text-center">Administrador</h4>
                @endif
            </div>
        </div>
        <div class="form-row m-4 justify-content-around">
            <label for="" class="col">Acción que desea realizar: </label>
            <select class="col col-md-8 custom-select" name="actions" id="actions" required>
                <option selected value="">&nbsp;&nbsp;Seleccione una opción</option>
                <option value="consultar">&nbsp;&nbsp;Consultar</option>
                @if (auth()->user()->rol_id == '1' or auth()->user()->rol_id == 2 || auth()->user()->rol_id == 4 || auth()->user()->rol_id == 6)
                    <option value="registrar">&nbsp;&nbsp;Registrar</option>
                @endif()
            </select>
        </div>
        <div class="form-row m-4 justify-content-around">
            <label for="" class="col">¿Que área desea manejar? </label>
            <select class="col col-md-8 custom-select" name="about_what" id="about_what" required>
                <option selected value="">&nbsp;&nbsp;Seleccione una opción</option>
                <option value="instituciones">&nbsp;&nbsp;Instituciones</option>
                <option value="convenios">&nbsp;&nbsp;Convenios</option>    
                <option value="movilidad">&nbsp;&nbsp;Movilidadades</option>
            </select>
        </div>
        <div class="form-row m-4 justify-content-around">
            <label for="" class="col">A nivel: </label>
            <select class="col col-md-8 custom-select"  name="nacoInt" id="nacoInt" title="Solo se habilitará para registro de Movilidades o consultas en general" required>
                <option value="">&nbsp;&nbsp;Seleccione una opción</option>
                <option value="nacional">&nbsp;&nbsp;Nacional</option>
                <option value="internacional">&nbsp;&nbsp;Internacional</option>
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