<?php declare(strict_types = 1);

use App\Models\Video;

test('should be able to create a summary', function () {
    $video = Video::factory()->create();
    dd($video);
});
