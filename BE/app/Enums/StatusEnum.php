<?php

namespace App\Enums;

enum StatusEnum: string
{
    case READY = 'READY';
    case APPLIED = 'APPLIED';
    case PENDING = 'PENDING';
    case RECEIVE = 'RECEIVE';
    case REQUEST = 'REQUEST';
    case KNOWING = 'KNOWING';
    case NOT_YET = 'NOT_YET';
    case REJECTED = 'REJECTED';
    case HIRED = 'HIRED';
    case REVISION = 'REVISION';
    case ONBEHALF = 'ONBEHALF';
    case APPROVED = 'APPROVED';
    case COMPLETED = 'COMPLETED';
    case UNDER_REVIEW = 'UNDER_REVIEW';
    case READY_PURCHASING = 'READY_PURCHASING';
    case REQUEST_BORROWED = 'REQUEST_BORROWED';
    case APPROVED_ONBEHALF = 'APPROVED_ONBEHALF';
    case REQUEST_PURCHASING = 'REQUEST_PURCHASING';
    case PENDING_PURCHASING = 'PENDING_PURCHASING';
    case PROCESSING_APPROVAL = 'PROCESSING_APPROVAL';
    case PROCESSING_PURCHASING = 'PROCESSING_PURCHASING';
    case PUBLISHED_UNVERIFIED = 'PUBLISHED_UNVERIFIED';

        // Tambahan sesuai permintaan
    case VERIFIED = 'VERIFIED';
    case NEED_ACTIVATION = 'NEED_ACTIVATION';
    case DRAFT = 'DRAFT';
    case PUBLISHED = 'PUBLISHED';
    case CLOSED = 'CLOSED';

        // Tambahan dari permintaan user
    case INVITED = 'invited';
    case CALLED = 'called';
    case PASSED = 'passed';
    case ACCEPTED = 'accepted';

    public static function fromString(?string $value): ?self
    {
        return $value ? self::tryFrom($value) : null;
    }
}

// cara menggunakan
// $status = StatusEnum::APPROVED->value;
