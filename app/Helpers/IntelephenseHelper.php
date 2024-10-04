<?php declare(strict_types = 1);

namespace Illuminate\Contracts\View;

use Illuminate\Contracts\Support\Renderable;

interface View extends Renderable
{
    /** @return static */
    public function layout(?string $layout);
}
