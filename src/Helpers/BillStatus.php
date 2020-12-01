<?php

/*
 * BillStatus.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  24/11/2020 22:23
 */

namespace Undjike\BillingSystem\Helpers;

use Illuminate\Support\Arr;
use Spatie\Enum\Enum;

/**
 * @method static self pending()
 * @method static self paid()
 * @method static self partiallyPaid()
 */
class BillStatus extends Enum
{
    /**
     * Matching statuses with the suitable labels
     * NOTE: The first label will be used as database default value
     *
     * @return string[]
     */
    protected static function labels(): array
    {
        return [
            'pending' => 'WAITING FOR PAYMENT',
            'paid' => 'TOTALLY PAID',
            'partiallyPaid' => 'PARTIALLY PAID',
        ];
    }

    /**
     * All the statuses available for bills
     *
     * @return array
     */
    public static function all()
    {
        return Arr::flatten(self::labels());
    }
}