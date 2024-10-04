<?php declare(strict_types = 1);

namespace App\Models;

use App\Traits\Models\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;
    use HasSearch;

    protected $fillable = [
        'provider',
        'headers',
        'payload',
    ];
}
