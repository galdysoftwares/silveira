<?php declare(strict_types = 1);

namespace App\Models;

use App\Traits\Models\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Category extends Model
{
    use HasFactory;
    use HasSearch;
    use SoftDeletes;

    protected $fillable = [
        'title',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
