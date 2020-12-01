<?php

/*
 * HasBills.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  24/11/2020 22:03
 */

namespace Undjike\BillingSystem\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use LogicException;
use Undjike\BillingSystem\Helpers\BillStatus;
use Undjike\BillingSystem\Interfaces\Product;
use Undjike\BillingSystem\Models\Bill;
use Undjike\BillingSystem\Models\Consumption;

/**
 * Trait HasBills
 * @package Undjike\BillingSystem\Traits
 * @mixin Model
 */
trait HasBills
{
    /**
     * All bills of the billable model
     *
     * @return MorphMany
     */
    public function bills()
    {
        return $this->morphMany(Bill::class, 'billable');
    }

    /**
     * All unpaid bills of the billable model
     * NOTE: Even partially paid bills will be taken
     *
     * @return MorphMany
     * @noinspection PhpUndefinedMethodInspection
     */
    public function unpaidBills()
    {
        return $this->bills()->otherCurrentStatus(BillStatus::paid());
    }

    /**
     * All paid bills of the billable model
     *
     * @return MorphMany
     * @noinspection PhpUndefinedMethodInspection
     */
    public function paidBills()
    {
        return $this->bills()->currentStatus(BillStatus::paid());
    }

    /**
     * All partially paid bills of the billable model
     *
     * @return MorphMany
     * @noinspection PhpUndefinedMethodInspection
     */
    public function partiallyPaidBills()
    {
        return $this->bills()->currentStatus(BillStatus::partiallyPaid());
    }

    /**
     * Charge a billable for a consumption
     *
     * @param Product $product
     * @return bool
     * @noinspection PhpParamsInspection
     */
    public function charge(Product $product)
    {
        if (!($product instanceof Model))
            throw new LogicException('Product interface should be implemented by a model');

        $consumption = new Consumption;

        $consumption->consumable()->associate($product);
        $consumption->consumer()->associate($this);

        return $consumption->save();
    }
}