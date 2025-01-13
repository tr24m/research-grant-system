<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'grant_id',
        'name',
        'target_completion_date',
        'deliverable',
    ];

    public function grant()
    {
        return $this->belongsTo(Grant::class, 'grant_id');
    }
}
