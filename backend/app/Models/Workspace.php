<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'tableNumber', 'monitorsCount', 'mount', 'dockingStation',
        'headPhones', 'tableType', 'zone_id'

    ];

    // Workspace belongs to zone
    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    //Workspace have many reservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
