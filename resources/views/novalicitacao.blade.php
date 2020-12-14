@extends('layouts.app',["current" => "categorias"])
@section('body')
<div class="card-body">
        {{-- erros --}}
        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <strong>Ops!</strong> Adicione um arquivo válido.<br><br>
          <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        {{-- fim --}}
        <form class="" method="POST"  action="/novalicitacao/store" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                    <div class="form-group col-md-3">
                            <label for="numero_liticitacao">Título:</label>
                            <input class="form-control" type="text" id="titulo_licitacao" name="titulo_licitacao"/>
                    </div>
                    <div class="form-group col-md-3">
                            <label for="numero_liticitacao">Número da Licitação:</label>
                            <input class="form-control" type="number" id="numero_licitacao" name="numero_licitacao"/>
                    </div>
                    <div class="form-group col-md-3">
                            <label for="modalidade">Modalidade:</label>
                            <select class="form-control" name="modalidade" id="modalidade">
                                @foreach($modalidades as $modalidade)
                            <option value="{{$modalidade->id}}">{{$modalidade->titulo}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="situacao">Situação:</label>
                        <select id="situacao" name="situacao" class="form-control">
                            <option value="1">Aberta</option>
                            <option value="0">Fechada</option>
                        </select>
                    </div>
            </div> 
            <div class="form-row">
                    <div class="form-group col-md-2">
                            <label for="num_itens_licitacao">N° de Itens:</label>
                            <input class="form-control" type="text" id="num_itens_licitacao" name="num_itens_licitacao"/>
                    </div>
                    <div class="form-group col-md-3">
                            <label for="local_licitacao">Local:</label>
                            <input class="form-control" type="text" id="local_licitacao" name="local_licitacao"/>
                    </div>
                    <div class="form-group col-md-2">
                            <label for="cidade_licitacao">Cidade:</label>
                            <input class="form-control" type="text" id="cidade_licitacao" name="cidade_licitacao"/>
                    </div>
                    <div class="form-group col-md-2">
                            <label for="abertura_licitacao">Data da Abertura:</label>
                            <input class="form-control" type="date" id="abertura_licitacao" name="abertura_licitacao"/>
                    </div>
                    <div class="form-group col-md-3">
                            <label for="contado_licitacao">Contato:</label>
                            <input class="form-control" type="text" id="contato_licitacao" name="contato_licitacao"/>
                    </div>
            </div> 
            <div class="form-row">
                    <div class="form-group col-md-3">
                            <label for="valor_estimado">Valor estimado da licitação:</label>
                            <input class="form-control" type="text" id="valor_estimado" name="valor_estimado"/>
                    </div>
                    <div class="form-group col-md-4">
                            <label for="impugnacao_licitacao">Questionamentos e impugnações:</label>
                            <input class="form-control" type="text" id="impugnacao_licitacao" name="impugnacao_licitacao"/>
                    </div>
                    <div class="form-group col-md-5">
                            <label for="vencedor_licitacao">Nome do Vencedor da Licitação:</label>
                            <input class="form-control" type="text" id="vencedor_licitacao" name="vencedor_licitacao"/>
                    </div>
            </div> 
            <br>
            <div class="form-row">
                    <div class="input-group">
                        <label for="objeto">Objeto:</label>
                    <textarea id="objeto_licitacao" name="objeto_licitacao" class="form-control" aria-label="Obejto:"></textarea>
                    </div>
            </div>
            <br>
            <div class="form-row">
                <div class="form-group col-md-12">
                    {{-- <label for="anexo_licitacao">Anexo:</label>
                    <input class="form-control" type="text" id="anexo_licitacao" name="anexo_licitacao"> --}}

                        <div class="input-group control-group increment" >
                                <input type="file" name="anexoname[]" class="form-control">
                                <div class="input-group-btn"> 
                                  <button class="btn btn-warming btn-add" type="button"><i class="glyphicon glyphicon-plus"></i></button>
                                </div>
                        </div>
                        <div class="clone hide">
                                <div class="control-group input-group" style="margin-top:10px">
                                        <input type="file" name="anexoname[]" class="form-control">
                                        <div class="input-group-btn"> 
                                        <button title="remover" class="btn btn-remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                        </div>
                                </div>
                        </div>
                </div>
            </div>
            </div>
            <input type="submit" class="more-link" value="salvar">
            <a href="/" class="more-link">Cancelar</a>
        </form>
    </div>
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