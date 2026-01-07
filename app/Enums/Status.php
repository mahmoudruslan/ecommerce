<?php

namespace App\Enums;

enum Status: int
{
    case PENDING = 0;
    case PAYMENT_COMPLETED = 1;
    case PROCESSING = 2;
    case REJECTED = 3;
    case CANCELED = 4;
    case FINISHED = 5;
    case REFUND_REQUEST = 6;
    case RETURNED_ORDER = 7;
    case REFUNDED = 8;

    public function label(): string
    {
        return match ($this) {
            self::PENDING => __('Pending'),
            self::PAYMENT_COMPLETED => __('Payment completed'),
            self::PROCESSING => __('Processing'),
            self::REJECTED => __('Rejected'),
            self::CANCELED => __('Canceled'),
            self::FINISHED => __('Finished'),
            self::REFUND_REQUEST => __('Refund request'),
            self::RETURNED_ORDER => __('Returned order'),
            self::REFUNDED => __('Refunded'),
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING => 'btn-secondary',
            self::PAYMENT_COMPLETED,
            self::PROCESSING,
            self::RETURNED_ORDER,
            self::REFUNDED => 'btn-info',

            self::REJECTED,
            self::CANCELED => 'btn-danger',

            self::FINISHED => 'btn-success',

            self::REFUND_REQUEST => 'btn-warning',
        };
    }

    public function badgeHtml(): string
    {
        return sprintf(
            '<label class="p-1 %s">%s</label>',
            $this->badgeClass(),
            $this->label()
        );
    }
}

