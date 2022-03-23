@extends('layouts.plantilla')

@section('content')
    <div class="container mt-5 ">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Actas ISTE') }}</div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" action="{{ route('procesar') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Datos Excel</label>
                                <input type="file" class="form-control @error('datos') is-invalid @enderror" name="datos"
                                    id="exampleInputEmail1" aria-describedby="emailHelp">
                                <div id="emailHelp" class="form-text">
                                    <small id="emailHelp" class="form-text text-muted">
                                        Selecciona el archivo excel con los datos de los actas.
                                    </small>
                                </div>
                                @error('datos')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Plantilla Acta</label>
                                <input name="plantilla" type="file"
                                    class="form-control @error('plantilla') is-invalid @enderror"
                                    id="exampleInputPassword1">
                                @error('plantilla')
                                    <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Generar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
