<?php

namespace App\Enums;

enum CandidateStatus: int
{
    case APPLIED = 1;
    case INTERVIEWED = 2;
    case HIRED = 3;
    case REJECTED = 4;

    public function label(): string
    {
        return match ($this) {
            self::APPLIED => 'Mới nhận',
            self::INTERVIEWED => 'Phỏng vấn',
            self::HIRED => 'Tuyển dụng',
            self::REJECTED => 'Loại',
        };
    }
}
