<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'dateFrom', 'dateTo', 'workspace_id'

    ];

    // Reservation belongs to Workspace
    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    // Reservation belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
