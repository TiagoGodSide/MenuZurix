<?php

namespace App\Enums;

enum BusinessStatus: string
{
    case Open = 'open';
    case Closed = 'closed';
    case Paused = 'paused';
    case Vacation = 'vacation';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Aberta',
            self::Closed => 'Fechada',
            self::Paused => 'Pausada',
            self::Vacation => 'Férias',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Open => 'text-bg-success',
            self::Closed => 'text-bg-secondary',
            self::Paused => 'text-bg-warning',
            self::Vacation => 'text-bg-info',
        };
    }
}