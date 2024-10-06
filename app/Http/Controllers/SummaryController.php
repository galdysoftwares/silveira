<?php declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Service\YouTubeApiService;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    public function __construct(
        private YouTubeApiService $youtubeServiceApi
    ) {
    }

    public function store(Request $request)
    {
        dd($this->youtubeServiceApi->getVideoDetails('videoId'));
    }
}
