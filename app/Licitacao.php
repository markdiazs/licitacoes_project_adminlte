<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Licitacao extends Model
{
    // nome da tabela
     protected $table = 'licitacoes';
     protected $fillable = ['titulo','qtd_itens','modalidade_id', 'modalidade', 'local', 'cidade', 'data_abertura', 'contato', 'valor_estimado', 'impugnacoes', 'nome_vendedor', 'objeto situacao'];

    public function anexos()
    {
        return $this->hasMany(Anexo::class,'licitacoes_id');
    }
    /*
    *param[] array com os filtros recuperados com o request do form na página de busca
    * return retorn um objeto do tipo collection
    */
    public static function buscarLicitacoes($filtros = []){
        // var_dump($filtros);
        $result = DB::Table('licitacoes')
        ->select('*')
        ->where(function ($query) use($filtros){
            foreach($filtros as $key => $value){
                // verifica e aplica um filtr específico para o campo data
                if($key == 'data_abertura' && $value != ""){
                    $query->whereYear('data_abertura','=',$value);
                }else {
                    $query->where($key,'like','%'.$value.'%');
                }     
            }
        });
        return $result;    
    }

}
