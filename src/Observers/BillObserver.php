<?php

/*
 * Bill.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  26/11/2020 22:52
 */

namespace Undjike\BillingSystem\Observers;

use Spatie\ModelStatus\Exceptions\InvalidStatus;
use Undjike\BillingSystem\Helpers\BillStatus;
use Undjike\BillingSystem\Models\Bill;

class BillObserver
{
    /**
     * @param Bill $bill
     * @throws InvalidStatus
     */
    public function created(Bill $bill)
    {
        $bill->setStatus(BillStatus::pending());
    }
}