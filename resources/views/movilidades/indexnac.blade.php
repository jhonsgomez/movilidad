@extends('layouts.inst_conv_mov')
@section('title', 'Movilidades Nacionales')

@section('content')
<div class="border border-2 rounded-3 shadow-lg mt-5 mb-5" style="width: 95%; background-color: white;">
    <div class="row mt-4 p-3 shadow-lg rounded-3 titles">
        <div class="offset-1 col-10">
            <h4 class="text-center ">Movilidades Nacionales</h4>
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
                                <th scope="col">Documento</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Estudiante/Docente</th>
                                <th scope="col">Entidad</th>
                                <th scope="col">País</th>
                                <th scope="col">Objeto</th>
                                <th scope="col">Resultados</th>                                
                                <th scope="col">Presencial/Virtual</th>
                                <th scope="col">Entrante/Saliente:</th>
                                <th scope="col">Inicio:</th>
                                <th scope="col">Vigencia:</th>
                                <th scope="col">Duración:</th>
                                <th scope="col">Documentación de soporte:</th>
                                @if (auth()->user()->rol_id == '1' or auth()->user()->rol_id == 2 || auth()->user()->rol_id == 4 || auth()->user()->rol_id == 6)
                                    <th scope="col">Acciones:</th>
                                @endif   
                                @if (auth()->user()->rol_id == 2 || auth()->user()->rol_id == 4 || auth()->user()->rol_id == 6)   
                                    <th scope="col">Actividades:</th>  
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($movilidadesConActividades as $movilidadConActividades)
                            <tr>
                                <td class="text-center">{{ $movilidadConActividades['movilidad']->id }}</td>
                                <td>{{ $movilidadConActividades['movilidad']->documento }}</td>
                                <td>{{ strtoupper($movilidadConActividades['movilidad']->nombre) }}</td>
                                @if ($movilidadConActividades['movilidad']->est_pro == 0)
                                    <td>Estudiante</td>
                                @else
                                    <td>Profesor</td>
                                @endif
                                <td>{{ strtoupper($movilidadConActividades['movilidad']->entidad_origen) }}</td>
                                <td>{{ ucfirst(strtolower($movilidadConActividades['movilidad']->pais)) }}</td>
                                <td>{{ ucfirst(strtolower($movilidadConActividades['movilidad']->objeto)) }}</td>
                                <td>{{ ucfirst(strtolower($movilidadConActividades['movilidad']->resultados)) }}</td>
                                @if ($movilidadConActividades['movilidad']->pres_virt == 0)
                                    <td>Presencial</td>
                                @else
                                    <td>Virtual</td>
                                @endif
                                @if ($movilidadConActividades['movilidad']->ent_sal == 0)
                                    <td>Entrante</td>
                                @else
                                    <td>Saliente</td>
                                @endif
                                <td>{{ date_format(date_create($movilidadConActividades['movilidad']->fecha_inicio), 'd-m-Y') }}</td>
                                <td>{{ date_format(date_create($movilidadConActividades['movilidad']->fecha_final), 'd-m-Y') }}</td>
                                <td>{{ $movilidadConActividades['movilidad']->duracion }}</td>
                                <td>
                                    @foreach (explode(",", $movilidadConActividades['movilidad']->doc_soporte) as $file)
                                            <br> - <a href="{{ url('/download_movilidad_nac', $file) }}">{{$file}}</a>
                                    @endforeach
                                </td>
                                @if (auth()->user()->rol_id == '1' or auth()->user()->rol_id == 2 || auth()->user()->rol_id == 4 || auth()->user()->rol_id == 6)
                                    <td>
                                        <div class="row mt-2">
                                            <div class="col d-flex flex-row p-0">
                                                <a style="margin: 0 0.8rem" class="w-auto btn btn-primary w-100" href="{{ route('movilidades_nac.edit', $movilidadConActividades['movilidad']->id) }}">Editar</a>
                                                <form action="{{ route('movilidades_nac.destroy', $movilidadConActividades['movilidad']->id) }}" method="POST" class="form-delete">
                                                    @csrf
                                                    <button type="submit" class="w-auto btn btn-outline-danger w-100">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                                @if (auth()->user()->rol_id == 2 || auth()->user()->rol_id == 4 || auth()->user()->rol_id == 6)
                                    <td>
                                        <div class="row my-2">
                                            <a href="{{ route('actividades.create', $movilidadConActividades['movilidad']->id) }}" style="margin-left: 0.8rem;" class="w-auto btn btn-primary">Agregar Actividad</a>
                                        </div>
                                        @if (count($movilidadConActividades['actividades']) > 0)
                                        <table class="table-responsive">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center">Actividad</th>
                                                    <th scope="col" class="text-center">Responsable</th>
                                                    <th scope="col" class="text-center">Documento</th>
                                                    <th scope="col" class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($movilidadConActividades['actividades'] as $actividad)
                                                <tr>
                                                    <td>{{ $actividad->tipo }}</td>
                                                    <td>{{ strtoupper($actividad->responsable) }}</td>
                                                    <td>{{ $actividad->documento }}</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col">
                                                                <a href="{{ route('actividades.details', $actividad->id) }}" class="w-auto btn btn-success"><i class="bi bi-eye"></i></a>
                                                            </div>
                                                            <div class="col">
                                                                <a href="{{ route('actividades.edit', $actividad->id) }}" class="w-auto btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                                                            </div>
                                                            <div class="col">
                                                                <form method="POST" action="{{ route('actividades.destroy', $actividad->id) }}">
                                                                    @csrf
                                                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @else
                                            <span>Aún no hay actividades para esta modalidad</span>
                                        @endif
                                    </td>
                                @endif
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
        @if (auth()->user()->rol_id == 2 || auth()->user()->rol_id == 4 || auth()->user()->rol_id == 6)
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
                                <form action="{{ route('movilidad_nac.export') }}">
                                <div class="form-group mb-2">
                                    <label for="desde">Desde:</label>
                                    <input type="date" class="form-control" name="export_fecha_inicial" id="export_fecha_inicial">
                                </div>
                                <div class="form-group mb-2">
                                    <label for="desde">Hasta:</label>
                                    <input type="date" class="form-control" name="export_fecha_final" id="export_fecha_final" >
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
        @endif
    </div>
</div>
@endsection