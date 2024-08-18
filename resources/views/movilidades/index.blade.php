@extends('layouts.inst_conv_mov')
@section('title', 'ORI UTS - Movilidades')

@section('content')
<div class="border border-2 rounded-3 shadow-lg mt-5 mb-5" style="width: 95%; background-color: white;">
    <div class="row mt-4 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            @if ($nivel == 0)
                <h4 class="text-center ">Movilidades Nacionales</h4>
            @else
                <h4 class="text-center ">Movilidades Internacionales</h4>
            @endif
        </div>
    </div>
    <div class="row mt-4">
        <div class="offset-1 col-10">
            <div class="card">
                <div class="card-body ">
                    <table id="queryTable">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Convenio</th>
                                <th scope="col">Entrante/Saliente</th>
                                <th scope="col">Documento</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Tipo Persona</th>
                                <th scope="col">País</th>
                                <th scope="col">Actividad</th>
                                <th scope="col">Presencial/Virtual: </th>
                                <th scope="col">Descripcion: </th>
                                <th scope="col">Entidad: </th>
                                <th scope="col">Objeto: </th>
                                <th scope="col">Resultados: </th>
                                <th scope="col">Responsable: </th>
                                <th scope="col">Fecha Inicio: </th>
                                <th scope="col">Fecha Final: </th>
                                <th scope="col">Documentación de soporte: </th>
                                <th scope="col">Acciones: </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($movilidades as $movilidad)
                                <tr>
                                    <td>{{ $movilidad->id }}</td>
                                    <td>
                                        @if ($movilidad->nac_ext == 0)
                                            {{ __('Nacional') }}
                                        @else
                                            {{ __('Internacional') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($movilidad->convenio_id != '')
                                            UTS - {{ strtoupper($movilidad->institucion) }}
                                        @else
                                            {{ __('No Aplica') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($movilidad->ent_sal == 0)
                                            {{ __('Entrante') }}
                                        @else
                                            {{ __('Saliente') }}
                                        @endif
                                    </td>
                                    <td>{{ $movilidad->documento }}</td>
                                    <td>{{ strtoupper($movilidad->nombre) }}</td>
                                    <td>{{ $movilidad->tipo_persona }}</td>
                                    <td>{{ ucfirst(strtolower($movilidad->pais)) }}</td>
                                    <td>{{ $movilidad->actividad }}</td>
                                    <td>
                                        @if ($movilidad->pres_virt == 0)
                                            {{ __('Presencial') }}
                                        @else
                                            {{ __('Virtual') }}
                                        @endif
                                    </td>
                                    <td>{{ ucfirst(strtolower($movilidad->descripcion)) }}</td>
                                    <td>{{ strtoupper($movilidad->entidad) }}</td>
                                    <td>{{ ucfirst(strtolower($movilidad->objeto)) }}</td>
                                    <td>{{ ucfirst(strtolower($movilidad->resultados)) }}</td>
                                    <td>
                                        @if ($movilidad->responsable != '')
                                            {{ strtoupper($movilidad->responsable) }}
                                        @else
                                            {{ __('No Aplica') }}
                                        @endif
                                    </td>
                                    <td>{{ date_format(date_create($movilidad->fecha_inicio), 'd-m-Y') }}</td>
                                    <td>{{ date_format(date_create($movilidad->fecha_final), 'd-m-Y') }}</td>
                                    <td>
                                        @if ($movilidad->doc_soporte != '')
                                            @foreach (explode(",", $movilidad->doc_soporte) as $file)
                                                <br> - <a href="{{ route('movilidades.download', $file) }}">{{$file}}</a>
                                            @endforeach
                                        @else
                                            {{ __('No hay documentación de soporte') }}
                                        @endif
                                    </td>
                                    <td>
                                        <div class="row mt-2">
                                            <div class="col d-flex flex-row p-0">
                                                <a style="margin: 0 0.8rem" class="w-auto btn btn-primary w-100"
                                                    href="{{ route('movilidades.edit', $movilidad->id) }}">Editar</a>
                                                <form action="{{ route('movilidades.delete', $movilidad->id) }}"
                                                    method="POST" class="form-delete"
                                                    onsubmit="confirmarEliminacion(event)">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-auto btn btn-outline-danger w-100">Eliminar</button>
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
            <a href="{{ route('login.activites') }}" class="btn btn-outline-success text-decoration-none">Regresar</a>
        </div>
        <div class="offset-5 col-3">
            <button type="button" class="btn btn-outline-dark w-100" data-toggle="modal"
                data-target="#exampleModalCenter">Generar Reportes <i
                    class="bi bi-file-earmark-spreadsheet-fill"></i></button>
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Reportes</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('movilidades.export') }}" method="POST">
                                @csrf
                                <div class="form-group mb-2">
                                    <label for="desde">Desde:</label>
                                    <input type="date" class="form-control" name="export_fecha_inicial"
                                        id="export_fecha_inicial">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="desde">Hasta:</label>
                                    <input type="date" class="form-control" name="export_fecha_final"
                                        id="export_fecha_final">
                                </div>
                                <span><b>Nota*:</b>Puede seleccionar 1 (Desde), ambas o ninguna fecha.</span>
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

<script>
    function confirmarEliminacion(event) {
        const confirmation = confirm("¿Estás seguro/a de que deseas eliminar este ítem?");

        if (!confirmation) {
            event.preventDefault();
        }
    }
</script>
@endsection