<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Mainmenu extends Model
  {
      protected $fillable = [
          'mainmenu',
'mainmenulabel',
'icon',
'tenant',
'user',
'url',
'orderby',
'menuscope',
      ];

    public function submenus()
    {
        return $this->hasMany('App\Submenu','mainmenu')->orderBy('orderby');
    }
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'mainmenus';
  }