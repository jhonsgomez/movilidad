@extends('layouts.inst_conv_mov')
@section('title', 'Registro Convenios')

@section('content')
    <form method="POST" class="form-conv-nac border border-2 rounded-3 shadow-lg mt-5 mb-5" action="{{ route('convenios.store_int') }}" enctype="multipart/form-data">
        @csrf
        <div class="row mt-3 p-3 shadow-lg rounded-3 titles">
            <div class="offset-1 col-10">
                <h4 class="text-center" id="ori">Registro Convenio Internacional</h4>
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <select class="form-select border border-dark" id="conv_instEntInt" name="conv_instEntInt">
                    <option selected value="">-- * Institución o Entidad --</option>
                    @foreach ($instEntInt as $item)
                        <option value="{{ $item->id }}" {{ old('conv_instEntInt') == $item->id ? 'selected': '' }}> {{ strtoupper($item->nombre) }}</option>
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
                    <option value="Practicas" {{ old('conv_tipo') == "Practicas" ? 'selected': '' }}>Practicas</option>
                    <option value="Interadministrativo" {{ old('conv_tipo') == "Interadministrativo" ? 'selected': '' }}>Interadministrativo</option>
                    <option value="Especifico" {{ old('conv_tipo') == "Especifico" ? 'selected': '' }}>Específico</option>
                    <option value="Marco" {{ old('conv_tipo') == "Marco" ? 'selected': '' }}>Marco</option>
                </select>
                @error('conv_tipo')
                    <span class="text-danger">*{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
            <textarea class="form-control border border-dark" placeholder="* Breve descripcion del convenio... " id="conv_objeto" name="conv_objeto">{{ old('conv_objeto') }}</textarea>
                @error('conv_objeto')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        <div class="row mt-4">
            <div class="offset-1 col-10">
            <textarea class="form-control border border-dark" placeholder="* Resultados del convenio (movilidad, financiacion de proyectos, publicaciones, etc.)" id="conv_result" name="conv_result">{{ old('conv_result') }}</textarea>
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
                        <input type="date" class="form-control border border-dark" id="conv_fechaInicio" name="conv_fechaInicio" value="{{ old('conv_fechaInicio') }}">
                        @error('conv_fechaInicio')
                            <span class="text-danger">*{{ $message }}</span>    
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="offset-1 col-10">
                <label for="" class="mb-1">* Fecha de Vigencia:</label>
                <input type="date" class="form-control border border-dark" id="conv_vigencia" name="conv_vigencia" value="{{ old('conv_vigencia') }}">
                @error('conv_vigencia')
                    <span class="text-danger">*{{ $message }}</span>    
                @enderror
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="offset-1 col-10">
                <div id="userAlert" class="alert alert-success d-none" role="alert">
                    Usuario agregado exitosamente.
                </div>
                <label for="" class="mb-1">N° de usuarios: <span id="n_usuarios">(0)</span></label>
                <br>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#userModal"><i class="bi bi-person-plus"></i>&nbsp;Agregar Usuarios</button>
                <input type="hidden" name="usuarios_convenio" id="usuarios_convenio">
                @error('conv_nUsuariosNac')
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
                <input type="file" class="form-control border border-dark " multiple name="conv_docsoporte[]" id="conv_docsoporte" >
                <span for="">* Nota: Se debe cargar al menos la Minuta.</span>
                @error('conv_docsoporte')
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
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">AGREGAR USUARIO AL CONVENIO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <div class="mb-3">
                            <label for="doc" class="form-label">* Documento de identidad:</label>
                            <input type="number" class="form-control" id="doc" placeholder="Documento de identidad..." required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">* Nombre:</label>
                            <input type="text" class="form-control" id="name" placeholder="Nombre del usuario..." required>
                        </div>
                        <div class="mb-3">
                            <label for="program" class="form-label">* Programa académico:</label>
                            <select class="form-select" id="program" name="program" required>
                                <option selected value="">Seleccione un programa</option>
                                @foreach ($programas as $programa)
                                    <option value="{{ $programa->id }}">{{ ucfirst(strtolower($programa->nombre)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="period" class="form-label">* Periodo académico (Ejemplo: 2024-1):</label>
                            <input type="text" class="form-control" id="period" placeholder="Periodo académico..." required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">* Correo institucional:</label>
                            <input type="email" class="form-control" id="email" placeholder="Correo institucional..." required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">* Número de teléfono:</label>
                            <input type="number" class="form-control" id="phone" placeholder="Número de teléfono" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">* Fecha de inicio:</label>
                            <input type="date" class="form-control" id="start_date" placeholder="Fecha de inicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">* Fecha de terminación:</label>
                            <input type="date" class="form-control" id="end_date" placeholder="Fecha de terminación" required>
                        </div>
                        <div class="mb-3">
                            <label for="duracion" class="form-label">* Duración:</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" class="form-control" id="duracion" placeholder="Número de horas, semanas, dias o meses." required>
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
                        <div class="mb-3">
                            <label for="supervisor" class="form-label">* Supervisor:</label>
                            <input type="text" class="form-control" id="supervisor" placeholder="Supervisor del usuario...">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let usuarios = [];
            const userForm = document.getElementById('userForm');
            const usuariosInput = document.getElementById('usuarios_convenio');
            const nUsuariosSpan = document.getElementById('n_usuarios');
            const userAlert = document.getElementById('userAlert');

            usuariosInput.value = JSON.stringify(usuarios);

            userForm.addEventListener('submit', function (e) {
                e.preventDefault();
                
                const user = {
                    documento: document.getElementById('doc').value,
                    nombre: document.getElementById('name').value,
                    programa_academico: document.getElementById('program').value,
                    periodo_academico: document.getElementById('period').value,
                    correo_institucional: document.getElementById('email').value,
                    numero_telefono: document.getElementById('phone').value,
                    fecha_inicio: document.getElementById('start_date').value,
                    fecha_terminacion: document.getElementById('end_date').value,
                    duracion: document.getElementById('duracion').value + " " + document.getElementById('type_duracion').value,
                    supervisor: document.getElementById('supervisor').value
                };

                usuarios.push(user);
                usuariosInput.value = JSON.stringify(usuarios);

                nUsuariosSpan.textContent = `(${usuarios.length})`;

                // Mostrar el alert de éxito
                userAlert.classList.remove('d-none');
                setTimeout(() => {
                    userAlert.classList.add('d-none');
                }, 5000);

                // Reset form and close modal
                userForm.reset();
                $('#userModal').modal('hide');
            });
        });
    </script>
@endsection