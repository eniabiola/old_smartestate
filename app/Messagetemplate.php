<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Messagetemplate extends Model
  {
      protected $fillable = [
          'id',
          'tenant',
          'user',
'templatetitle',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'messagetemplates';
  }