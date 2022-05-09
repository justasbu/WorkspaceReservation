<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

/**
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Zone extends Model
{
    protected $primaryKey = 'id';

    use HasFactory;

    protected $fillable = [
        'city', 'name', 'description'
    ];

    // Zone have many workspaces
    public function workspaces()
    {
        return $this->hasMany(Workspace::class);
    }
}
