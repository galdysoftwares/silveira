<?php declare(strict_types = 1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait HasSearch
{
    public function scopeSearch(Builder $query, ?string $search = null, ?array $column = []): Builder
    {
        return $query->when(
            $search,
            function (Builder $q) use ($column, $search) {
                foreach ($column as $col) {
                    $q->orWhere(
                        DB::raw('lower(' . $col . ')'),
                        'like',
                        '%' . strtolower($search) . '%'
                    );
                }
            }
        );
    }
}
