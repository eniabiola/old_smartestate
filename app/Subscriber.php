<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Subscriber extends Model
  {

      protected $table = "subscribers";

      protected $fillable = [
            'idsession',
            'tenantid',
            'estatepin',
            'businessname',
            'email',
            'phone',
            'state',
            'city',
            'address',
            'bank',
            'accountno',
            'accountname',
            'contactperson',
            'conatctphone',
            'contactemail',
            'statusestate',
            'tenant',
            'user',
            'imagename'
      ];

  }
