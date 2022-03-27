<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Userrole extends Model
  {
      protected $fillable = [
          'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'userroles';
  }