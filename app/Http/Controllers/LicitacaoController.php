<?php

namespace App\Http\Controllers;

use App\Anexo;
use App\Licitacao;
use Illuminate\Http\Request;
use App\Modalidade;
use DateTime;
use Facade\FlareClient\Http\Response;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\File as FlysystemFile;

class LicitacaoController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    // adaptacao adminlte

    public function dashboard()
    {

        // user
        $user = Auth::user();
        // var_dump($user);
        // exit();
         //recuperando as modalidades
        $modalidades = Modalidade::All();
        
        // recuperando os anexos
        $anexos = Anexo::all();
         
        // buscando licitacoes com base nos filtros
        $licitacao = DB::table('licitacoes')->select('*')->paginate(5);
        $qtd_licitacoes = count(DB::table('licitacoes')->select('*')->get());
        $qtd_abertas = count(DB::table('licitacoes')->where('situacao', 1)->get());
        $qtd_fechadas = count(DB::table('licitacoes')->where('situacao', 0)->get());
 
        return view('dashboard', ['modalidades' => $modalidades,'result' => $licitacao,'anexo' => $anexos, 'qtd_licitacoes' => $qtd_licitacoes,'qtd_abertas' => $qtd_abertas, 'qtd_fechadas' => $qtd_fechadas, 'user' => $user]);

    }

    public function cadCategoria(){
        // user
        $user = Auth::user();

        return view('novacategoria',['user' => $user]);
    }

    public function storeCategoria(Request $request)
    {

    
        $this->validate($request,[
            'titulo' => 'required'
        ]);

        DB::table('modalidades')->insert(['titulo' => $request['titulo']]);

      flash('categoria criada com sucesso')->success();
      return redirect('/cadastro/categoria');
    }


    public function index()
    {
        $modalidades = Modalidade::All();
        return view('index',['modalidades' => $modalidades]);
    }

    public function create()
    {
        // user
        $user = Auth::user();
        $modalidades = Modalidade::All();
        return view('novaLicitacao2',['modalidades' => $modalidades, 'user' => $user]);
    }

    public function busca(Request $request)
    {
        // definindo os filtros para a busca
        $data = [
            'numero'        => $request->input('num_licitacao'),
            'data_abertura' => $request->input('ano_licitacao'),
            'modalidade'    => $request->input('modalidade_licitacao'),
            'objeto'        => $request->input('objeto_licitacao'),
            'situacao'      => $request->input('situacao_licitacao')
        ];

        //recuperando as modalidades
        $modalidades = Modalidade::All();
        
        // recuperando os anexos
        $anexos = Anexo::all();
        
        // buscando licitacoes com base nos filtros
        $licitacao = Licitacao::buscarLicitacoes($data)->paginate(3);

        return view('index',['modalidades' => $modalidades,'result' => $licitacao,'anexo' => $anexos,'dataForm' => $data]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'anexoname'             => 'required',
            'titulo_licitacao'      => 'required',
            'numero_licitacao'      => 'required',
            'itens_licitacao'       => 'required',
            'modalidade'            => 'required',
            'local_licitacao'       => 'required',
            'cidade_licitacao'      => 'required',
            'abertura_licitacao'    => 'required',
            'contato_licitacao'     => 'required',
            'valor_licitacao'       => 'required',
            'impugnacao_licitacao'  => 'required',
            'vencedor_licitacao'    => 'required',
            'objeto_licitacao'      => 'required',
            'situacao'              => 'required'

        ]);

        // formatando a data
        $data_abertura = new DateTime($request->input('abertura_licitacao'));
        $data_abertura->format('d-m-y');

        $licitacao = [
            'titulo'        => $request->input('titulo_licitacao'),
            'numero'        => $request->input('numero_licitacao'),
            'qtd_itens'     => $request->input('itens_licitacao'),
            'modalidade_id' => $request->input('modalidade'),
            'modalidade'    => $request->input('modalidade'),
            'local'         => $request->input('local_licitacao'),
            'cidade'        => $request->input('cidade_licitacao'),
            'data_abertura' => $data_abertura,
            'contato'       => $request->input('contato_licitacao'),
            'valor_estimado'=> $request->input('valor_licitacao'),
            'impugnacoes'   => $request->input('impugnacao_licitacao'),
            'nome_vendedor' => $request->input('vencedor_licitacao'),
            'objeto'        => $request->input('objeto_licitacao'),
            'situacao'      => $request->input('situacao')
        ];

         $licitacao_id = DB::table('licitacoes')->insertGetId($licitacao);
        // anexos
        if($request->hasFile('anexoname')){
            foreach($request->file('anexoname') as $anexo){
                $data = [
                    'anexo'         => $licitacao['numero'] .'_'. $anexo->getClientOriginalName(),
                    'link'          => public_path().'/anexos/' . $anexo->getClientOriginalName(),
                    'licitacoes_id' => $licitacao_id
                ];
                $anexo->move(public_path().'/anexos/',$data['anexo']);
                DB::table('anexos')->insert($data);
                
            }
            unset($anexo);
        }
        flash('Licitação cadastrada com sucesso')->success();
        return redirect('/');
    }

    public function consulta ($numero)
    {
        $licitacao = DB::table('licitacoes')->where('numero',$numero)->first();
        $data = new DateTime($licitacao->data_abertura);
        $licitacao->data_abertura = $data->format('Y');
        $anexos = DB::table('anexos')->where('licitacoes_id',$licitacao->id)->get();
         return view('detalhes_licitacao',['licitacao' => $licitacao,'anexos' => $anexos]) ; 
    }

    public function baixarArquivo($id)
    {
        $arquivo = Anexo::findOrFail($id);
        $download_path = ( public_path() . '/anexos/' . $arquivo->anexo );
        return response()->download($download_path);
        
    }

    public function edit($id)
    {

        // user
        $user = Auth::user();
        $l = Licitacao::find($id);
        $modalidades = Modalidade::all();
        return view('editarlicitacao2', ['licitacao' => $l, 'modalidades' => $modalidades, 'user' => $user]);
    }


    public function update(Request $req, $id)
    {

        $this->validate($req, [
            'titulo_licitacao'      => 'required',
            'numero_licitacao'      => 'required',
            'itens_licitacao'       => 'required',
            'modalidade'            => 'required',
            'local_licitacao'       => 'required',
            'cidade_licitacao'      => 'required',
            'contato_licitacao'     => 'required',
            'valor_licitacao'       => 'required',
            'impugnacao_licitacao'  => 'required',
            'vencedor_licitacao'    => 'required',
            'objeto_licitacao'      => 'required',
            'situacao'              => 'required'

        ]);

        $l = Licitacao::find($id);

        if(isset($l)){

        // formatando a data
        $data_abertura = new DateTime($req->input('abertura_licitacao'));
        $data_abertura->format('d-m-y');

        $licitacao = [
            'titulo'        => $req->input('titulo_licitacao'),
            'numero'        => $req->input('numero_licitacao'),
            'qtd_itens'     => $req->input('itens_licitacao'),
            'modalidade_id' => $req->input('modalidade'),
            'modalidade'    => $req->input('modalidade'),
            'local'         => $req->input('local_licitacao'),
            'cidade'        => $req->input('cidade_licitacao'),
            'data_abertura' => $data_abertura != null? $l->data_abertura : $req->input('data_abertura'),
            'contato'       => $req->input('contato_licitacao'),
            'valor_estimado'=> $req->input('valor_licitacao'),
            'impugnacoes'   => $req->input('impugnacao_licitacao'),
            'nome_vendedor' => $req->input('vencedor_licitacao'),
            'objeto'        => $req->input('objeto_licitacao'),
            'situacao'      => $req->input('situacao')
        ];

        $l->update($licitacao);

        //  $licitacao_id = DB::table('licitacoes')->insertGetId($licitacao);
        // anexos
        flash('Licitação editada com sucesso')->warning();
        return redirect('/');

        }


    }

    public function delete($id)
    {
        if($id){
            $l = Licitacao::find($id);
            
            $anexo = DB::table('anexos')->where('licitacoes_id',$l->id)->first();
            Storage::disk('public')->delete($anexo->anexo);
            $l->anexos()->delete();
            $l->delete();

         
            flash('Licitacao excluida com sucesso')->success();

            return redirect('/');
        }
    }
}
