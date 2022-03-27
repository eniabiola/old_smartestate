<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Visitorpa extends Model
  {
      protected $fillable = [
        'visitationdate',
          'passid',
'date',
'recurrentpass',
'dateexpires',
'guestname',
'gender',
'specialfeature',
'generatedcode',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'visitor_passes';
  }