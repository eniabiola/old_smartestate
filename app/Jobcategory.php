<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Jobcategory extends Model
  {
      protected $fillable = [
          'jobcategory',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = '';
  }