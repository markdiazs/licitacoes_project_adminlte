@extends('layouts.adminlte',["current" => "Licitações"])

@section('body')

<div class="card card-primary" style="width: 100%;">
@if (count($errors) > 0)
          <strong>Ops!</strong> Adicione um arquivo válido.<br><br>
      
            @foreach ($errors->all() as $error)
              <div class="alert alert-warning alert-dismissible" style="font-size: 10px; height: 20px;">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  {{$error}}
              </div>
            @endforeach
@endif
              <div class="card-header">
                <h3 class="card-title">Editar licitação : {{$licitacao->numero}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" name="cadLicitacao" method="POST" action="/licitacao/update/{{$licitacao->id}}" enctype="multipart/form-data">
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <div class="col6">
                        <label for="exampleInputEmail1">Título</label>
                        <input type="text" class="form-control" name="titulo_licitacao" id="exampleInputEmail1" placeholder="título" value=" {{$licitacao->titulo}}">
                      </div>
                      <div class="col6">
                        <label for="Número">Número</label>
                        <input type="number" class="form-control" name="numero_licitacao" id="exampleInputEmail1" placeholder="número da licitação" value="{{$licitacao->numero}}">
                      </div>
                  </div>
                  <div class="form-group">
                        <label>Modalidade</label>
                        <select class="form-control" name="modalidade" id="modalidade"> 
                        @foreach($modalidades as $modalidade)
                          @if($licitacao->modalidade == $modalidade->id)
                            <option selected value="{{$modalidade->id}}">{{$modalidade->titulo}}</option>
                          @else
                            <option  value="{{$modalidade->id}}">{{$modalidade->titulo}}</option>
                          @endif
                        @endforeach
                        </select>
                  </div>
                  <div class="form-group">
                        <label>Situação</label>
                        <select id="situacao" name="situacao" class="form-control">
                            <option value="1">Aberta</option>
                            <option value="0">Fechada</option>
                        </select>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-2">
                        <label for="Local">itens</label>
                        <input type="text" name="itens_licitacao" class="form-control" placeholder="Itens" value="{{$licitacao->qtd_itens}}">
                      </div>
                      <div class="col-md-3">
                        <label for="Local">Local</label>
                        <input type="text" name="local_licitacao" class="form-control" placeholder="Local" value="{{$licitacao->local}}">
                      </div>
                      <div class="col-md-3">
                        <label for="Local">Cidade</label>
                        <input type="text" name="cidade_licitacao" class="form-control" placeholder="Cidade" value="{{$licitacao->cidade}}">
                      </div>
                      <div class="col-md-2">
                        <label for="Local">Data</label>
                        <input type="Date" name="abertura_licitacao" class="form-control" placeholder="Data" value="{{$licitacao->data_abertura}}">
                      </div>
                      <div class="col-md-2">
                        <label for="Local">Contato</label>
                        <input type="text" name="contato_licitacao" class="form-control" placeholder="Contato" value="{{$licitacao->contato}}">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label for="Local">Valor estimado da licitação</label>
                        <input type="text" name="valor_licitacao" class="form-control" placeholder="valor estimado da licitação" value="{{$licitacao->valor_estimado}}">
                      </div>
                      <div class="col-md-4">
                        <label for="Local">Questionamentos e impugnações</label>
                        <input type="text" name="impugnacao_licitacao" class="form-control" placeholder="Questionamentos e impugnações" value="{{$licitacao->impugnacoes}}">
                      </div>
                      <div class="col-md-4">
                        <label for="Local">Nome do Vencedor da Licitação</label>
                        <input type="text" name="vencedor_licitacao" class="form-control" placeholder="Nome do Vencedor da Licitação" value="{{$licitacao->nome_vendedor}}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="Objeto">Objeto</label>
                      <textarea id="objeto_licitacao" name="objeto_licitacao" class="form-control" aria-label="Obejto:">{{$licitacao->objeto}}</textarea>
                    </div>
                    <div class="form-group">
                  <label for="exampleInputFile">Procurar arquivo</label>
                  <input type="file" id="exampleInputFile" name="anexoname[]">
                </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">cadastrar</button>
                  <a href="/" class="btn btn-warning">Voltar</a>
                </div>
              </form>
            </div>

            <script>

$(document).ready(function() {
$(".btn-add").click(function(){ 
    var html = $(".clone").html();
    $(".increment").after(html);
});

$("body").on("click",".btn-remove",function(){ 
    $(this).parents(".control-group").remove();
});

});
</script>
@endsection