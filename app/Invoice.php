<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Invoice extends Model
  {
      protected $fillable = [
          'date',
'invoiceno',
'surname',
'billitemcode',
'tenant',
'user',

      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'invoices';
  }