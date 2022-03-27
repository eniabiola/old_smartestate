<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Estate extends Model
  {
      protected $fillable = [
          'estateid',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'estates';
  }