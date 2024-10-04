<?php declare(strict_types = 1);

namespace App\Models;

use App\Traits\Models\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Product extends Model
{
    use HasFactory;
    use HasSearch;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'code',
        'description',
        'amount',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
