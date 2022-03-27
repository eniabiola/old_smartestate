<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Bank extends Model
  {
      protected $fillable = [
          'bank',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'banks';
  }