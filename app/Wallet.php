<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Wallet extends Model
  {
      protected $fillable = [
        'transid',
          'walletid',
'date',
'surname',
'credit',
'debit',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'wallets';
  }