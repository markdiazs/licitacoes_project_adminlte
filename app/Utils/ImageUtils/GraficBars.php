<?php

namespace App\Utils\ImageUtils;

use PHPlot;

class GraficBars
{

    public function createGrafic($title,$titleX,$titleY,$format,$type,$data)
    {
        // instanciando
        $grafico = new PHPlot();
        // setando formato
        $grafico->SetFileFormat($format);
        // definindo atributos
        $grafico->SetTitle($title);
        $grafico->SetXTitle($titleX);
        $grafico->SetYTitle($titleY);
        $grafico->SetDataValues($data);
        $grafico->SetPlotType($type);
        $grafico->DrawGraph();
        $grafico->EncodeImage();
        return $grafico;
    }
}
