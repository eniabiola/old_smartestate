<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Submenu extends Model
  {
      protected $fillable = [
          'mainmenu',
'submenu',
'submenulabel',
'tenant',
'user',
'icon',
'url',
'orderby',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'submenus';
  }