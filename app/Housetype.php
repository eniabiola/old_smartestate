<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Housetype extends Model
  {
      protected $fillable = [
          'housetype',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'housetypes';
  }