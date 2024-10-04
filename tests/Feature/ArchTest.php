<?php declare(strict_types = 1);

test('globals')
    ->expect(['dd', 'dump', 'tap', 'tinker', 'ds', 'ddd', 'sleep'])
    ->not->toBeUsed();
