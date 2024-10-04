<?php declare(strict_types = 1);

namespace App\Models;

use App\Traits\Models\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Opportunity extends Model
{
    use HasFactory;
    use HasSearch;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'title',
        'status',
        'amount',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
