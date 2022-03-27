<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Rolemanagement extends Model
  {
      protected $fillable = [
          'add',
'edit',
'view',
'delete',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'rolemanagements';
  }