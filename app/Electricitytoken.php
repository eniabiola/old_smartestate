<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Electricitytoken extends Model
  {
      protected $fillable = [
          'tokenid',
'date',
'amount',
'token',
'statuspurchase',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'electricity_tokens';
  }