<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Usermanagement extends Model
  {
      protected $fillable = [
          'userfullname',
'username',
'password',
'phone',
'email',
'rolename',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'usermanagements';
  }