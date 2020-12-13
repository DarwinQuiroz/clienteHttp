@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Publicar nuevo producto</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('products.publish') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Título</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-md-4 col-form-label text-md-right">Detalle</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="details" value="{{ old('details') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="stock" class="col-md-4 col-form-label text-md-right">Stock</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" name="stock" min="1" value="{{ old('stock') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="picture" class="col-md-4 col-form-label text-md-right">Imagen</label>

                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="picture" required>
                                    <label class="custom-file-label">Seleccione un archivo</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">Categoría</label>

                            <div class="col-md-6">
                                <select name="category" class="custom-select" required>
                                    <option selected>Elija una opción...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->identifier }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Publicar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
