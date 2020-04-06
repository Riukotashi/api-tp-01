<?php

namespace App\Article;

class Status
{
    const NOT_PUBLISHED = 0;
    const REDACTION = 1;
    const PUBLISHED = 2;
    public static function getStatus(): array
    {
        return [
            self::NOT_PUBLISHED,
            self::REDACTION,
            self::PUBLISHED
        ];
    }
}