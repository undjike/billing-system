<?php

/*
 * Product.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  27/11/2020 18:58
 */

namespace Undjike\BillingSystem\Interfaces;

/**
 * Interface Product
 * @package Undjike\BillingSystem\Interfaces
 */
interface Product
{
    /**
     * Product's price
     *
     * @return float
     */
    public function getPrice(): float;

    /**
     * Product's name
     *
     * @return string
     */
    public function getName(): string;
}