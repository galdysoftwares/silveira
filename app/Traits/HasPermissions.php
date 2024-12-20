<?php declare(strict_types = 1);

namespace App\Traits;

use App\Enums\Can;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

trait HasPermissions
{
    public function givePermissionTo(Can|string $key): void
    {
        $pKey = $key instanceof Can ? $key->value : $key;

        $this->permissions()->firstOrCreate(['key' => $pKey]);

        Cache::forget($this->getPermissionCacheKey());
        Cache::remember($this->getPermissionCacheKey(), now()->addMonths(3), function () {
            return $this->permissions;
        });
    }

    public function hasPermissionTo(Can|string $key): bool
    {
        $pKey = $key instanceof Can ? $key->value : $key;

        /** @var Collection $permissions */
        $permissions = Cache::get($this->getPermissionCacheKey(), fn () => $this->permissions);

        return $permissions->contains('key', $pKey);
    }

    private function getPermissionCacheKey(): string
    {
        return "user:{$this->id}:permissions";
    }
}
