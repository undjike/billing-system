<?php

/*
 * Billable.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  28/11/2020 09:32
 */

namespace Undjike\BillingSystem\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Billable
{
    /**
     * @return bool
     */
    public function isMaxUnpaidBillsException();

    /**
     * All bills of the billable model
     *
     * @return MorphMany
     */
    public function bills();

    /**
     * All unpaid bills of the billable model
     * NOTE: Even partially paid bills will be taken
     *
     * @return MorphMany
     */
    public function unpaidBills();

    /**
     * All paid bills of the billable model
     *
     * @return MorphMany
     */
    public function paidBills();

    /**
     * All partially paid bills of the billable model
     *
     * @return MorphMany
     */
    public function partiallyPaidBills();

    /**
     * Charge a billable for a consumption
     *
     * @param Product $product
     * @return bool
     */
    public function charge(Product $product);
}