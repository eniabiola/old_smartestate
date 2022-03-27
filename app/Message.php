<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Message extends Model
  {
      protected $fillable = [
          'datemsg',
'templatetitle',
'sentcount',
'tenantname',
'statussent',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'messages';
  }