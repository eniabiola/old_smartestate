<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Payment extends Model
  {
      protected $fillable = [
          'receiptno',
'date',
'surname',
'paymentchannel',
'statuspayment',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'payments';
  }