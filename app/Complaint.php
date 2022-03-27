<?php
  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Complaint extends Model
  {
      protected $fillable = [
          'residentid',
          'date',
          'requestsubject',
          'description',
          'jobcategory',
          'priority',
          'attachdoc',
          'tenant',
          'user',
      ];

      
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'complaints';
  }