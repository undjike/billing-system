<?php

/*
 * CollectionObserver.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  26/11/2020 22:57
 */

namespace Undjike\BillingSystem\Observers;

use Spatie\ModelStatus\Exceptions\InvalidStatus;
use Undjike\BillingSystem\Helpers\BillStatus;
use Undjike\BillingSystem\Models\Collection;

class CollectionObserver
{
    /**
     * @param Collection $collection
     * @throws InvalidStatus
     */
    public function created(Collection $collection)
    {
        $this->updateBillStatus($collection);
    }

    /**
     * @param Collection $collection
     * @throws InvalidStatus
     */
    public function updated(Collection $collection)
    {
        $this->updateBillStatus($collection);
    }

    /**
     * @param Collection $collection
     * @throws InvalidStatus
     */
    public function deleted(Collection $collection)
    {
        $this->updateBillStatus($collection);
    }

    /**
     * @param Collection $collection
     * @throws InvalidStatus
     */
    public function forceDeleted(Collection $collection)
    {
        $this->updateBillStatus($collection);
    }

    /**
     * Update bill status
     *
     * @param Collection $collection
     * @throws InvalidStatus
     */
    private function updateBillStatus(Collection $collection)
    {
        $bill = $collection->bill;

        $bill->setStatus(
            $bill->to_be_collected > 0
                ? BillStatus::partiallyPaid()
                : BillStatus::paid()
        );
    }
}