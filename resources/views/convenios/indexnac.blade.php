@extends('layouts.inst_conv_mov')
@section('title', 'Convenios Nacionales')

@section('content')
<div class="border border-2 rounded-3 shadow-lg bg-white" style="width: 75%;">
    <div class="row mt-4 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            <h4 class="text-center" style="text-shadow: 0px 0px 7px #000;">Convenios Nacionales</h4>
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <div class="card">
                <div class="card-body ">
                    <table id="queryTable"> 
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Fecha de Creación</th>
                                <th scope="col">Institución o Entidad</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Inicio</th>
                                <th scope="col">Vigencia</th> 
                                <th scope="col">Tipo</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Breve Objeto: </th>
                                <th scope="col">Resultados Concretos: </th>
                                <th scope="col">N° de usuarios/No Aplica: </th>
                                <th scope="col">Documentación Soporte: </th>
                                <th scope="col">Acciones: </th>
                                <th scope="col">Usuarios:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($conveniosConUsuarios as $item)
                                <tr>
                                    <td> {{ $item['convenio']->codigo }}</td>
                                    <td> {{ date_format(date_create($item['convenio']->created_at), 'd-m-Y') }} </td>
                                    <td> {{ strtoupper($item['convenio']->nombre) }} </td>
                                    <td> {{ ucwords(strtolower($item['convenio']->ciudad)) }} </td>
                                    <td> {{ $item['convenio']->fechaInicio }} </td>
                                    <td> {{ $item['convenio']->vigencia }} </td>
                                    <td> {{ $item['convenio']->tipo }} </td>
                                    <td> {{ $item['convenio']->activo }} </td>
                                    <td> {{ ucfirst(strtolower($item['convenio']->breve_objeto)) }} </td>
                                    <td> {{ ucfirst(strtolower($item['convenio']->resultados_concretos)) }} </td>
                                    @if ($item['convenio']->n_usuarios == 0)
                                        <td>No Aplica</td>   
                                    @else 
                                        <td> {{ $item['convenio']->n_usuarios }} </td>
                                    @endif                            
                                    <td> 
                                        @foreach (explode(",", $item['convenio']->docSoportes) as $file)
                                            <br> - <a href="{{ url('/download_conv_nac', $file) }}">{{$file}}</a>
                                        @endforeach 
                                    </td>
                                        <td>
                                            <div class="row">
                                                <div class="w-auto">
                                                    <a class="btn btn-primary" href="{{ route('convenios_nac.edit', $item['convenio']->id) }}">Editar</a>
                                                </div>
                                                <div class="w-auto">
                                                    <form action="{{ route('convenio_nac.destroy', $item['convenio']->id) }}" method="POST" class="form-delete">
                                                        @csrf
                                                            <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="w-auto">
                                                    <button class="btn my-3 btn-success" data-toggle="modal" data-target="#createUserModal" data-convenio_id="{{ $item['convenio']->id }}">
                                                        Agregar Usuario
                                                    </button>
                                                </div>
                                                @if ($item['convenio']->n_usuarios > 0)
                                                    <div class="w-auto">
                                                        <form method="POST" action="{{ route('convenios.report_user_convenio_nacs') }}">
                                                            @csrf  
                                                            <input type="hidden" name="convenio_id" id="convenio_id" value="{{ $item['convenio']->id }}">
                                                            <button type="submit" class="btn my-3 btn-primary" >Reporte de usuarios</button>
                                                        </form>
                                                    </div>
                                                @endif  
                                            </div>

                                            @if ($item['convenio']->n_usuarios == 0)
                                                <p>Aún no hay usuarios en el convenio.  </p> 
                                            @else 
                                                <table>
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th>Documento</th>
                                                            <th>Nombre</th>
                                                            <th>Programa</th>
                                                            <th>Contacto</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($item['usuarios'] as $usuario)
                                                            <tr class="text-center">
                                                                <td> {{ $usuario->documento }} </td>
                                                                <td> {{ strtoupper($usuario->nombre) }} </td>
                                                                <td> {{ ucfirst(strtolower($usuario->nombre_programa)) }} </td>
                                                                <td> {{ $usuario->numero_telefono }} </td>
                                                                <td> 
                                                                    <div class="row">
                                                                        <div class="col">
                                                                        <button class="w-auto btn btn-success" data-toggle="modal" data-target="#viewUserModal"
                                                                                data-documento="{{ $usuario->documento }}"
                                                                                data-nombre="{{ strtoupper($usuario->nombre) }}"
                                                                                data-programa="{{ ucfirst(strtolower($usuario->nombre_programa)) }}"
                                                                                data-periodo="{{ $usuario->periodo_academico }}"
                                                                                data-correo="{{ strtolower($usuario->correo_institucional) }}"
                                                                                data-contacto="{{ $usuario->numero_telefono }}"
                                                                                data-inicio="{{ $usuario->fecha_inicio }}"
                                                                                data-terminacion="{{ $usuario->fecha_terminacion }}"
                                                                                data-duracion="{{ $usuario->duracion }}"
                                                                                data-supervisor="{{ strtoupper($usuario->supervisor) }}">
                                                                            <i class="bi bi-eye"></i>
                                                                        </button>
                                                                        </div>
                                                                        <div class="col">
                                                                            <button class="w-auto btn btn-primary" data-toggle="modal" data-target="#editUserModal"
                                                                                    data-id="{{ $usuario->id }}"
                                                                                    data-convenio="{{ $usuario->convenio_id }}"
                                                                                    data-documento="{{ $usuario->documento }}"
                                                                                    data-nombre="{{ strtoupper($usuario->nombre) }}"
                                                                                    data-programa="{{ ucfirst(strtolower($usuario->programa_academico)) }}"
                                                                                    data-periodo="{{ $usuario->periodo_academico }}"
                                                                                    data-correo="{{ strtolower($usuario->correo_institucional) }}"
                                                                                    data-contacto="{{ $usuario->numero_telefono }}"
                                                                                    data-inicio="{{ $usuario->fecha_inicio }}"
                                                                                    data-terminacion="{{ $usuario->fecha_terminacion }}"
                                                                                    data-duracion="{{ $usuario->duracion }}"
                                                                                    data-supervisor="{{ strtoupper($usuario->supervisor) }}">
                                                                                <i class="bi bi-pencil-square"></i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="col">
                                                                            <form method="POST" action="{{ route('convenios.destroy_user_convenio') }}">
                                                                                @csrf
                                                                                <input type="hidden" name="user_id" id="user_id" value="{{ $usuario->id }}">
                                                                                <input type="hidden" name="convenio_id" id="convenio_id" value="{{ $usuario->convenio_id }}">
                                                                                <input type="hidden" name="nac_int" id="nac_int" value="{{ $usuario->nac_int }}">
                                                                                <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 mb-4">
        <div class="offset-1 col-2">
            <a href="{{ route('login.activites') }}" class="btn btn-outline-success text-decoration-none">Regresar</a>
        </div>
            <div class="offset-5 col-3">
                <button type="button" class="btn btn-outline-dark w-100" data-toggle="modal" data-target="#exampleModalCenter">Generar Reportes  <i class="bi bi-file-earmark-spreadsheet-fill"></i></button>
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Reportes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('convNac.export') }}">
                                <div class="form-group mb-2">
                                    <label for="desde">Desde:</label>
                                    <input type="date" class="form-control" name="convNac_initialDate" id="convNac_initialDate">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="desde">Hasta:</label>
                                    <input type="date" class="form-control" name="convNac_finalDate" id="convNac_initialDate" >
                                </div>
                                <span><b>Nota*:</b>Puede seleccionar 1 (Desde), ambas o ninguna fecha.</span>
                                <div class="form-row justify-content-around mt-4">
                                    <select class="col col-md-8 form-select" name="type_reporte" id="type_reporte" required>
                                        <option value="" selected>&nbsp;&nbsp; -- Tipo de reporte --</option>
                                        <option value="Todos">&nbsp;&nbsp;Todos los convenios</option>
                                        <option value="Usuarios">&nbsp;&nbsp;Todos los usuarios</option>
                                        <option value="Practicas">&nbsp;&nbsp;Practicas</option>
                                        <option value="Marco">&nbsp;&nbsp;Marco</option>
                                        <option value="Especifico">&nbsp;&nbsp;Específico</option>
                                        <option value="Interadministrativo">&nbsp;&nbsp;Interadministrativo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-outline-success">Descargar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Crear Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createUserForm" method="POST" action="{{ route('convenios.add_user_convenio') }}">
                    @csrf
                    <input type="hidden" name="convenio_id" id="convenio_id">
                    <input type="hidden" name="nac_int" id="nac_int" value="0">
                    <div class="form-group">
                        <label for="editDocumento"><strong>Documento:</strong></label>
                        <input type="number" class="form-control" id="documento" name="documento" required>
                    </div>
                    <div class="form-group">
                        <label for="editNombre"><strong>Nombre:</strong></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="editPrograma"><strong>Programa Académico:</strong></label>                    
                        <select class="form-select" id="programa_academico" name="programa_academico" required>
                            <option selected value="">Seleccione un programa</option>
                            @foreach ($programas as $programa)
                                <option value="{{ $programa->id }}">{{ ucfirst(strtolower($programa->nombre)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editPeriodo"><strong>Periodo Academico (Ejemplo: 2024-1):</strong></label>
                        <input type="text" class="form-control" id="periodo_academico" name="periodo_academico" required>
                    </div>
                    <div class="form-group">
                        <label for="editCorreo"><strong>Correo institucional:</strong></label>
                        <input type="email" class="form-control" id="correo_institucional" name="correo_institucional" required>
                    </div>
                    <div class="form-group">
                        <label for="editContacto"><strong>Contacto:</strong></label>
                        <input type="number" class="form-control" id="numero_telefono" name="numero_telefono" required>
                    </div>
                    <div class="form-group">
                        <label for="editInicio"><strong>Fecha de Inicio:</strong></label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="editTerminacion"><strong>Fecha de Terminacion:</strong></label>
                        <input type="date" class="form-control" id="fecha_terminacion" name="fecha_terminacion" required>
                    </div>
                    <div class="form-group">
                        <label for="duracion"><strong>Duración:</strong></label>
                        <div class="row">
                            <div class="col">
                                <input type="number" class="form-control" name="duracion" id="duracion" placeholder="Número de horas, semanas, dias o meses." required>
                            </div>
                            <div class="col">
                                <select name="type_duracion" class="form-select" id="type_duracion" required>
                                    <option value="" selected>-- * Tipo de duración --</option>
                                    <option value="Horas">Horas</option>
                                    <option value="Dias">Días</option>
                                    <option value="Semanas">Semanas</option>
                                    <option value="Meses">Meses</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editSupervisor"><strong>Supervisor:</strong></label>
                        <input type="text" class="form-control" id="supervisor" name="supervisor">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewUserModal" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel">Detalles del Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Documento:</strong> <span id="modalDocumento"></span></p>
                <p><strong>Nombre:</strong> <span id="modalNombre"></span></p>
                <p><strong>Programa Académico:</strong> <span id="modalPrograma"></span></p>
                <p><strong>Periodo Academico:</strong> <span id="modalPeriodo"></span></p>
                <p><strong>Correo institucional:</strong> <span id="modalCorreo"></span></p>
                <p><strong>Contacto:</strong> <span id="modalContacto"></span></p>
                <p><strong>Fecha de Inicio:</strong> <span id="modalInicio"></span></p>
                <p><strong>Fecha de Terminacion:</strong> <span id="modalTerminacion"></span></p>
                <p><strong>Duración:</strong> <span id="modalDuracion"></span></p>
                <p><strong>Supervisor:</strong> <span id="modalSupervisor"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST" action="{{ route('convenios.update_user_convenio') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="convenio_id" id="convenio_id">
                    <input type="hidden" name="nac_int" id="nac_int" value="0">
                    <div class="form-group">
                        <label for="editDocumento"><strong>Documento:</strong></label>
                        <input type="number" class="form-control" id="documento" name="documento" required>
                    </div>
                    <div class="form-group">
                        <label for="editNombre"><strong>Nombre:</strong></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="editPrograma"><strong>Programa Académico:</strong></label>
                        <select class="form-select" id="programa_academico" name="programa_academico" required>
                            <option selected value="">Seleccione un programa</option>
                            @foreach ($programas as $programa)
                                <option value="{{ $programa->id }}">{{ ucfirst(strtolower($programa->nombre)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editPeriodo"><strong>Periodo Academico (Ejemplo: 2024-1):</strong></label>
                        <input type="text" class="form-control" id="periodo_academico" name="periodo_academico" required>
                    </div>
                    <div class="form-group">
                        <label for="editCorreo"><strong>Correo institucional:</strong></label>
                        <input type="email" class="form-control" id="correo_institucional" name="correo_institucional" required>
                    </div>
                    <div class="form-group">
                        <label for="editContacto"><strong>Contacto:</strong></label>
                        <input type="number" class="form-control" id="numero_telefono" name="numero_telefono" required>
                    </div>
                    <div class="form-group">
                        <label for="editInicio"><strong>Fecha de Inicio:</strong></label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                    </div>
                    <div class="form-group">
                        <label for="editTerminacion"><strong>Fecha de Terminacion:</strong></label>
                        <input type="date" class="form-control" id="fecha_terminacion" name="fecha_terminacion" required>
                    </div>
                    <div class="form-group">
                        <label for="duracion"><strong>Duración:</strong></label>
                        <div class="row">
                            <div class="col">
                                <input type="number" class="form-control" name="duracion" id="duracion" placeholder="Número de horas, semanas, dias o meses." required>
                            </div>
                            <div class="col">
                                <select name="type_duracion" class="form-select" id="type_duracion" required>
                                    <option value="" selected>-- * Tipo de duración --</option>
                                    <option value="Horas">Horas</option>
                                    <option value="Dias">Días</option>
                                    <option value="Semanas">Semanas</option>
                                    <option value="Meses">Meses</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editSupervisor"><strong>Supervisor:</strong></label>
                        <input type="text" class="form-control" id="supervisor" name="supervisor">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#createUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var convenio_id = button.data('convenio_id');
        var modal = $(this);
        modal.find('#convenio_id').val(convenio_id);
    });

    $('#viewUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        var documento = button.data('documento');
        var nombre = button.data('nombre');
        var programa = button.data('programa');
        var periodo = button.data('periodo');
        var correo = button.data('correo');
        var contacto = button.data('contacto');
        var inicio = button.data('inicio');
        var terminacion = button.data('terminacion');
        var duracion = button.data('duracion');
        var supervisor = button.data('supervisor');

        var modal = $(this);

        modal.find('#modalDocumento').text(documento);
        modal.find('#modalNombre').text(nombre);
        modal.find('#modalPrograma').text(programa);
        modal.find('#modalPeriodo').text(periodo);
        modal.find('#modalCorreo').text(correo);
        modal.find('#modalContacto').text(contacto);
        modal.find('#modalInicio').text(inicio);
        modal.find('#modalTerminacion').text(terminacion);
        modal.find('#modalDuracion').text(duracion);
        modal.find('#modalSupervisor').text(supervisor);
    });

    $('#editUserModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        var id = button.data('id');
        var convenio_id = button.data('convenio');
        var documento = button.data('documento');
        var nombre = button.data('nombre');
        var programa_academico = button.data('programa');
        var periodo_academico = button.data('periodo');
        var correo_institucional = button.data('correo');
        var numero_telefono = button.data('contacto');
        var fecha_inicio = button.data('inicio');
        var fecha_terminacion = button.data('terminacion');
        var duracion = button.data('duracion');
        var supervisor = button.data('supervisor');

        const arrayDuracion = duracion.split(" ");

        var modal = $(this);

        modal.find('#id').val(id);
        modal.find('#convenio_id').val(convenio_id);
        modal.find('#documento').val(documento);
        modal.find('#nombre').val(nombre);
        modal.find('#programa_academico').val(programa_academico);
        modal.find('#periodo_academico').val(periodo_academico);
        modal.find('#correo_institucional').val(correo_institucional);
        modal.find('#numero_telefono').val(numero_telefono);
        modal.find('#fecha_inicio').val(fecha_inicio);
        modal.find('#fecha_terminacion').val(fecha_terminacion);
        modal.find('#duracion').val(arrayDuracion[0]);
        modal.find('#type_duracion').val(arrayDuracion[1]);
        modal.find('#supervisor').val(supervisor);
    });
</script>
@endsection