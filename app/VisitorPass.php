<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitorPass extends Model
{
    protected $fillable = [
        'visitationdate',
        'passid',
        'date',
        'recurrentpass',
        'dateexpires',
        'guestname',
        'gender',
        'specialfeature',
        'generatedcode',
        'tenant',
        'user',
        'user_role',
        'visitor_pass_category'
    ];

    protected $keyType = 'string';

    protected $table = 'visitor_passes';

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin() : object
    {
        return $this->belongsTo(Usermanagement::class, 'user', 'id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function resident() : object
    {
        return $this->belongsTo(Subscriber::class, 'user', 'id');
    }
}
