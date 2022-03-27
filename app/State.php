<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class State extends Model
  {
      protected $fillable = [
          'state',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'states';
  }