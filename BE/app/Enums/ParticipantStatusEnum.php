<?php

namespace App\Enums;

enum ParticipantStatusEnum: string
{
    case JOINED = 'JOINED';
    case PENDING = 'PENDING';
    case CANCEL = 'CANCEL';
    
    /**
     * Get the status badge class
     *
     * @return string
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::JOINED => 'bg-success',
            self::PENDING => 'bg-warning text-dark',
            self::CANCEL => 'bg-danger',
        };
    }
    
    /**
     * Get the label for the status
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::JOINED => 'Mengikuti',
            self::PENDING => 'Belum Verifikasi',
            self::CANCEL => 'Dibatalkan',
        };
    }
}
