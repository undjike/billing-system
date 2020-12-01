<?php

/*
 * CheckMaxUnpaidBills.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  28/11/2020 09:07
 */

namespace Undjike\BillingSystem\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Undjike\BillingSystem\Interfaces\Billable;

/**
 * Class CheckMaxUnpaidBills
 * @package Undjike\BillingSystem\Http\Middleware
 */
class CheckMaxUnpaidBills
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param Billable $billable
     * @return mixed
     */
    public function handle(Request $request, Closure $next, Billable $billable)
    {
        if (!$billable->isMaxUnpaidBillsException() &&
            ($billable->unpaid_bills_count ?? $billable->unpaidBills()->count())
            > config('billing.max_unpaid_bills'))
            abort(config('billing.max_unpaid_bills_exception'));

        return $next($request);
    }
}