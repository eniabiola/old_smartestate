<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    protected $fillable = [
        'idsession',
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
