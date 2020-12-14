<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LicitacaoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            
            'anexoname'             => 'required',
            'titulo_licitacao'      => 'required',
            'numero_licitacao'      => 'required',
            'num_itens_licitacao'   => 'required',
            'modalidade'            => 'required',
            'local_licitacao'       => 'required',
            'cidade_licitacao'      => 'required',
            'abertura_licitacao'    => 'required',
            'contato_licitacao'     => 'required',
            'valor_estimado'        => 'required',
            'impugnacao_licitacao'  => 'required',
            'vencedor_licitacao'    => 'required',
            'objeto_licitacao'      => 'required',
            'situacao'              => 'required'

        ];
    }
}
