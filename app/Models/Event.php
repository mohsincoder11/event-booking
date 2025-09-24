<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CommonQueryScopes;

class Event extends Model
{
    use HasFactory, SoftDeletes, CommonQueryScopes;
    protected $table = 'event';

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'created_by',
    ];

    protected $dates = ['date', 'deleted_at'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
