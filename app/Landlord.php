<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Landlord extends Model
  {
      protected $fillable = [
          'landlordid',
'landlordname',
'email',
'phone',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'landlords';
  }