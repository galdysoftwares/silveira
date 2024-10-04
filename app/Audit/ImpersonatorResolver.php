<?php declare(strict_types = 1);

namespace App\Audit;

use OwenIt\Auditing\Contracts\{Auditable, Resolver};

class ImpersonatorResolver implements Resolver
{
    public static function resolve(Auditable $model)
    {
        return session('impersonator');
    }
}
