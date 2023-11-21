<?php

namespace App\Traits;

trait HasStatuses
{
    const STATUS_PENDING            = 0;
    const STATUS_IN_PROGRESS        = 1;
    const STATUS_COMPLETED          = 2;

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING        => 'pending',
            self::STATUS_IN_PROGRESS    => 'in-progress',
            self::STATUS_COMPLETED      => 'completed',
        ];
    }

    /**
     * Get textual representation of the status
     *
     * @return string
     */
    public function getStatusTextAttribute(): string
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? 'unknown';
    }
}
