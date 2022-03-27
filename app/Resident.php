<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Resident extends Model
  {
      protected $fillable = [
        'idsession',
          'residentid',
'surname',
'othername',
'phone',
'email',
'password',
'gender',
'datemovedin',
'housetype',
'landlordname',
'street',
'houseno',
'meterno',
'lgaccountno',
'regstatus',
'tenant',
'user',

      ];

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'residents';
  }