<?php declare(strict_types = 1);

namespace App\Models;

use App\Traits\Models\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Customer extends Model
{
    use HasFactory;
    use HasSearch;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
    ];

    public function opportunities(): HasMany
    {
        return $this->hasMany(Opportunity::class);
    }
}
