@extends('layouts.adminlte',["current" => "Início"])

@section('body')
<div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-contract"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Licitações cadastradas</span>
                <span class="info-box-number">
                  {{$qtd_licitacoes}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-lock-open"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Licitações abertas</span>
                <span class="info-box-number">{{$qtd_abertas}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-lock"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Licitações fechadas</span>
                <span class="info-box-number">{{$qtd_fechadas}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clipboard-list"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Modalidades</span>
                <span class="info-box-number">{{count($modalidades)}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->


          <div class="box" style="width: 100%;">
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
                <tbody><tr>
                  <th style="width: 10px">Número</th>
                  <th>Modalidade</th>
                  <th>Situação</th>
                  <th>Data</th>
                  <th>Vencedor</th>
                  <th>ações</th>
                </tr>
                @foreach ($result as $l)
                <tr>
                  <td>{{$l->numero}}</td>
                  <td>{{$l->titulo}}</td>
                  <td>@if($l->situacao == 1) <span class="badge bg-success">Aberta</span> @else <span class="badge bg-danger">Fechada</span> @endif</td>
                  <td>{{$l->data_abertura}}</td>
                  <td>{{$l->nome_vendedor}}</td>
                  <td>
                    <a href="/licitacao/editar/{{$l->id}}" class="btn btn-sm btn-warning" >Editar</a>
                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-danger">Excluir</a>
                  </td>
                </tr>

          <div class="modal fade show" id="modal-danger" aria-modal="true">
        <div class="modal-dialog">
          <div class="modal-content bg-danger">
            <div class="modal-header">
              <h4 class="modal-title">A operação não podera ser disfeita</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">fechar</button>
              <form action="/licitacao/delete/{{$l->id}}" method="POST">
              @csrf
              <button type="submit" class="btn btn-outline-light">excluir</button>
              </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
                @endforeach
              </tbody>
            </table>
            </div>
            {{ $result->links() }}
            <!-- /.box-body -->
          </div>

@endsection