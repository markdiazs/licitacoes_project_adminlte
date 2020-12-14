@extends('layouts.app',["current" => "home"])
<style>

    @import url('https://fonts.googleapis.com/css?family=Open+Sans|Overlock&display=swap');

    
</style>
@section('body')

<div class="container">

    
    <div class="cardd">
        <div class="card-titler">
        <p>
            Apresenta a lista de licitações realizadas – com seu respectivo objeto, número de itens, data, 
            hora e local de abertura – pelo Tribunal Regional do Trabalho da 8ª Região, publicados em atenção
             ao art. 7º do Ato nº 8/2009 CSJT.GP.SE. Solicite informações adicionais
             por meio do Serviço de Informação ao Cidadão, que encaminhará sua solicitação à área responsável.
        </p>
        <a id="btn-voltar" href="/" class="float-right">voltar</a>
        </div>
    </div>
    <div class="card-bodyd">
    <h4 id="title">Nº {{$licitacao->numero}}/{{$licitacao->data_abertura}}</h4>
    <h6><b>Objeto: </b>{{$licitacao->objeto}}</h6>
    <h6><b>Nº de Itens: </b>{{$licitacao->qtd_itens}}</h6>
    <h6><b>Situação: </b>{{$licitacao->situacao==1?'ABERTA':'FECHADA'}}</h6>
    <h6><b>Local: </b>{{$licitacao->local}}</h6>
    <h6><b>Cidade: </b>{{$licitacao->cidade}}</h6>
    <h6><b>Data da Abertura: </b>{{$licitacao->data_abertura}}</h6>
    <h6><b>Contato: </b>{{$licitacao->contato}}</h6>
    <h6><b>Valor estimado da licitação: </b>{{$licitacao->valor_estimado}}</h6>
    <h6><b>Questionamentos e impugnações: </b>{{$licitacao->impugnacoes}}</h6>
    <h6><b>Nome do Vencedor da Licitação: </b>{{$licitacao->nome_vendedor}}</h6>
    <h6><b>Anexos:</b></h6>
    @foreach ($anexos as $item)
    <h6><a href="/download/{{$item->id}}">{{$item->anexo}}</a></h6>
    @endforeach
    </div>
</div>


@endsection