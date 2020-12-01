<?php

/*
 * BillingServiceProvider.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  24/11/2020 20:25
 */

namespace Undjike\BillingSystem;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Undjike\BillingSystem\Models\Bill;
use Undjike\BillingSystem\Models\Collection;
use Undjike\BillingSystem\Observers\BillObserver;
use Undjike\BillingSystem\Observers\CollectionObserver;

class BillingServiceProvider extends ServiceProvider
{
    public function boot(Filesystem $filesystem)
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__.'/../config/billing.php' => config_path('billing.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations/create_billing_system_tables.stub' => $this->getMigrationFileName($filesystem),
            ], 'migrations');
        }

        $this->loadObservers();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/billing.php',
            'billing'
        );
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param Filesystem $filesystem
     * @return string
     */
    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return \Illuminate\Support\Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path.'*_create_billing_system_tables.php');
            })->push($this->app->databasePath()."/migrations/{$timestamp}_create_billing_system_tables.php")
            ->first();
    }

    /**
     * Load observers
     */
    protected function loadObservers()
    {
        if (config('billing.auto_bill_status')) {
            Bill::observe(BillObserver::class);
            Collection::observe(CollectionObserver::class);
        }
    }
}