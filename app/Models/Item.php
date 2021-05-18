<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * Class Item
 * @package App\Models
 *
 * @property string $name
 * @property boolean $completed
 * @property Carbon|null $completed_at
 * @method static Item findOrFail($value)
 */
class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
