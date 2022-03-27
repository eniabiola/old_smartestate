<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Street extends Model
  {
      protected $fillable = [
          'streetname',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'street';
  }