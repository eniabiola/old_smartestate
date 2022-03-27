<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class City extends Model
  {
      protected $fillable = [
          'city',
'state',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'cities';
  }