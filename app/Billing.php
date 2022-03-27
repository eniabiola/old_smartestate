<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Billing extends Model
  {
      protected $fillable = [
        'idsession',
        'billitemcode',
        'billname',
        'description',
        'amount',
        'frequency',
        'bill_target',
        'duedate',
        'statusbill',
        'tenant',
        'user',
      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'billings';
  }