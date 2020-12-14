<?php

namespace App\Http\Controllers;

use App\Licitacao;
use App\Utils\ImageUtils\GraficBars;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPlot;

class GraficoController extends Controller
{
  public function index()
  {

    return view('grafico');
  }

  public function getJson(){
    $licitacoes = DB::table('licitacoes')
    ->select(DB::raw('count(*) as total'), DB::raw("DATE_FORMAT(data_abertura, '%Y') ano"))
    ->orderBy('ano','desc')
    ->groupBy('ano')->get();
    $data = [];
    for($i=0;$i < $licitacoes->count(); $i++){
        array_push($data, [$licitacoes[$i]->ano,$licitacoes[$i]->total]);
    }

    return response()->json($data);
  }


}
