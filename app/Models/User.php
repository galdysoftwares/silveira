<?php declare(strict_types = 1);

namespace App\Models;

use App\Traits\HasPermissions;
use App\Traits\Models\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};
use Illuminate\Database\Eloquent\{SoftDeletes};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasPermissions;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use HasSearch;

    protected $fillable = [
        'name',
        'email',
        'password',
        'restored_at',
        'restored_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function restoredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'restored_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
