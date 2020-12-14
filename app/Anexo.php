<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
  public function licitacao()
  {
      return $this->belongsTo('App\licitacao');
  }
}
