<?php declare(strict_types = 1);

namespace App\Interfaces;

interface YoutubeApiInterface
{
    public function getVideoDetails(string $videoId): array;
    public function extractVideoID(string $url): ?string;
    public function getVideoCaptions(string $url): array;
    public function getVideoTitle(array $videoDetails): string;
    public function getVideoDescription(array $videoDetails): string;
    public function getVideoCategory(array $videoDetails): string;
    public function getVideoChannelTitle(array $videoDetails): string;
    public function getVideoChannelId(array $videoDetails): string;
    public function getVideoCaptionsUrl(array $videoDetails): string;
}
