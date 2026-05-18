<?php

namespace App\Services;

class LibraryService
{
    public function canDownload(string $status): bool
    {
        return $status === 'completed' || $status === 'paid';
    }

    public function formatGameSize(int $bytes): string
    {
        return round($bytes / (1024 * 1024 * 1024), 2) . " GB";
    }
}