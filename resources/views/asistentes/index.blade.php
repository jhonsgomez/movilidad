@extends('layouts.inst_conv_mov')
@section('title', 'Gestionar Asistencia')

@section('content')
<div class="border border-2 rounded-3 shadow-lg mt-5 mb-5" style="width: 80%; background-color: white;">
    <div class="row mt-4 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            <h4 class="text-center ">Asistentes de {{ $actividad->tipo }}</h4>
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <div class="card">
                <div class="card-body ">
                    <div class="row mb-4">
                        <div class="col d-flex justify-content-between">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#createOneModal" data-actividad_id="{{ $actividad->id }}"><i class="bi bi-person-plus"></i> Registrar una asistencia</button>
                            <button class="btn btn-success" data-toggle="modal" data-target="#createManyModal" data-actividad_id="{{ $actividad->id }}"><i class="bi bi-people"></i> Registrar varias asistencias</button>
                        </div>
                    </div>
                    <table id="queryTable"> 
                        <thead>
                            <tr class="text-center">
                                <th scope="col">Documento</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Programa Academico</th>
                                <th scope="col">Periodo Academico</th>
                                <th scope="col">Correo Institucional</th>
                                <th scope="col">Telefono</th>                                
                                @if (auth()->user()->rol_id == '1' or auth()->user()->rol_id == 2 || auth()->user()->rol_id == 6)
                                    <th scope="col">Acciones:</th>
                                @endif                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asistentes as $asistente)
                                <tr class="text-center">
                                    <td>{{ $asistente->documento }}</td>
                                    <td>{{ strtoupper($asistente->nombre) }}</td>
                                    <td>{{ ucfirst(strtolower($asistente->nombre_programa)) }}</td>
                                    <td>Semestre {{ $asistente->periodo_academico }}</td>
                                    <td>{{ strtolower($asistente->correo_institucional) }}</td>
                                    @if ($asistente->numero_telefono != '')
                                        <td>{{ $asistente->numero_telefono }}</td>
                                    @else
                                        <td>No Aplica</td>
                                    @endif  
                                    <td>
                                        <div class="row mt-3">
                                            <div class="col">
                                                <button class="w-auto btn btn-primary" data-toggle="modal" data-target="#editAsistenteModal"
                                                    data-id="{{ $asistente->id }}"
                                                    data-actividad_id="{{ $asistente->actividad_id }}"
                                                    data-documento="{{ $asistente->documento }}"
                                                    data-nombre="{{ strtoupper($asistente->nombre) }}"
                                                    data-programa="{{ ucfirst(strtolower($asistente->programa_academico)) }}"
                                                    data-periodo="{{ $asistente->periodo_academico }}"
                                                    data-correo="{{ strtolower($asistente->correo_institucional) }}"
                                                    data-contacto="{{ $asistente->numero_telefono }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </div>
                                            <div class="col">
                                                <form method="POST" action="{{ route('movilidades.delete_asistentes') }}">
                                                    @csrf
                                                    <input type="hidden" name="id" id="id" value="{{ $asistente->id }}">
                                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
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
            @if($actividad->inst_ent_nacs != '')
                <a href="{{ route('movilidades_nac.index') }}" class="btn btn-outline-success text-decoration-none">Regresar</a>
            @else
                <a href="{{ route('movilidades_int.index') }}" class="btn btn-outline-success text-decoration-none">Regresar</a>
            @endif
        </div>
        <div class="offset-5 col-3">
            <form method="POST" action="{{ route('movilidades.report_asistentes') }}">
                @csrf
                <input type="hidden" name="actividad_id" id="actividad_id" value="{{ $actividad->id }}">
                <button type="submit" class="btn btn-outline-dark w-100">Generar Reporte <i class="bi bi-file-earmark-spreadsheet-fill"></i></button>
            </form>
        </div>
    </div>
    <div class="modal fade" id="createOneModal" tabindex="-1" role="dialog" aria-labelledby="createOneModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Registrar Asistente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createOneForm" method="POST" action="{{ route('movilidades.new_one_asistentes') }}">
                        @csrf
                        <input type="hidden" name="actividad_id" id="actividad_id">
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
                            <label for="editPeriodo"><strong>Periodo Academico (Número de semestre):</strong></label>
                            <input type="number" class="form-control" id="periodo_academico" name="periodo_academico" required>
                        </div>
                        <div class="form-group">
                            <label for="editCorreo"><strong>Correo institucional:</strong></label>
                            <input type="email" class="form-control" id="correo_institucional" name="correo_institucional" required>
                        </div>
                        <div class="form-group">
                            <label for="editContacto"><strong>Contacto:</strong></label>
                            <input type="number" class="form-control" id="numero_telefono" name="numero_telefono">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Registrar Asistente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createManyModal" tabindex="-1" role="dialog" aria-labelledby="createManyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Registrar Varios Asistentes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createOneForm" method="POST" action="{{ route('movilidades.new_many_asistentes') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="actividad_id" id="actividad_id">
                        <div class="form-group mb-4 pb-2">
                            <label for="editDocumento"><span class="bg-secondary rounded text-white p-2"><strong>PASO 1:</strong></span>&nbsp;&nbsp;Descargar el formato <a href="{{ url('/download_asistentes_format', 'FormatoAsistencia.xlsx') }}">FormatoAsistencia.xlsx</a>.</label>
                        </div>
                        <div class="form-group my-4 pb-2">
                            <label for="editDocumento"><span class="bg-secondary rounded text-white p-2"><strong>PASO 2:</strong></span>&nbsp;&nbsp;Diligenciar el archivo.</label>
                        </div>
                        <div class="form-group my-4 pb-2">
                            <label for="editDocumento"><span class="bg-secondary rounded text-white p-2"><strong>PASO 3:</strong></span>&nbsp;&nbsp;Guardar el archivo en formaro ".csv".</label>
                        </div>
                        <div class="form-group mt-4 mb-3 pb-2">
                            <label for="editFile"><span class="bg-secondary rounded text-white p-2"><strong>PASO 4:</strong></span>&nbsp;&nbsp;Cargue el archivo ".csv" aquí:</label>
                            <input type="file" class="form-control mt-4" name="file" id="file" required>
                        </div>
                        <div class="form-group pb-2">
                            <label for="editFile"><span class="bg-secondary rounded text-white p-2"><strong>PASO 5:</strong></span>&nbsp;&nbsp;Click  en "Registrar Asitencia".</label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Registrar Asistencia</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAsistenteModal" tabindex="-1" role="dialog" aria-labelledby="editAsistenteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Asistente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" method="POST" action="{{ route('movilidades.update_asistente') }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="actividad_id" id="actividad_id">
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
                            <label for="editPeriodo"><strong>Periodo Academico:</strong></label>
                            <input type="number" class="form-control" id="periodo_academico" name="periodo_academico" required>
                        </div>
                        <div class="form-group">
                            <label for="editCorreo"><strong>Correo institucional:</strong></label>
                            <input type="email" class="form-control" id="correo_institucional" name="correo_institucional" required>
                        </div>
                        <div class="form-group">
                            <label for="editContacto"><strong>Contacto:</strong></label>
                            <input type="number" class="form-control" id="numero_telefono" name="numero_telefono">
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
</div>

<script>
    $('#createOneModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var actividad_id = button.data('actividad_id');
        var modal = $(this);
        modal.find('#actividad_id').val(actividad_id);
    });

    $('#createManyModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var actividad_id = button.data('actividad_id');
        var modal = $(this);
        modal.find('#actividad_id').val(actividad_id);
    });

    $('#editAsistenteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        var id = button.data('id');
        var actividad_id = button.data('actividad_id');
        var documento = button.data('documento');
        var nombre = button.data('nombre');
        var programa_academico = button.data('programa');
        var periodo_academico = button.data('periodo');
        var correo_institucional = button.data('correo');
        var numero_telefono = button.data('contacto');

        var modal = $(this);

        modal.find('#id').val(id);
        modal.find('#actividad_id').val(actividad_id);
        modal.find('#documento').val(documento);
        modal.find('#nombre').val(nombre);
        modal.find('#programa_academico').val(programa_academico);
        modal.find('#periodo_academico').val(periodo_academico);
        modal.find('#correo_institucional').val(correo_institucional);
        modal.find('#numero_telefono').val(numero_telefono);
    });


    document.getElementById('createOneForm').addEventListener('submit', function (event) {
        event.preventDefault();

        var form = event.target;
        var formData = new FormData(form);

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
            } else {
                alert(data.success);
                $('#createManyModal').modal('hide');
                form.reset();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ha ocurrido un error al registrar los asistentes.');
        });
    });
</script>

</script>

@endsection