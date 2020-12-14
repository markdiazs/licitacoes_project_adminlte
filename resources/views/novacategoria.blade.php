@extends('layouts.adminlte',["current" => "Categoria"])

@section('body')
<div class="card card-primary" style="width: 100%;">
              <div class="card-header">
                <h3 class="card-title">Criar uma nova Categoria</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" name="cadcategoria" method="POST" action="/cadastro/categoria/store">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Adicione um título para a categoria</label>
                    <input type="text" class="form-control" name="titulo" id="exampleInputEmail1" placeholder="categoria">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">cadastrar</button>
                  <button type="submit" class="btn btn-warning">voltar</button>
                </div>
              </form>
            </div>
@endsection