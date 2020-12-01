<?php

/*
 * Consumption.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  24/11/2020 20:32
 */

namespace Undjike\BillingSystem\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumption extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['details'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'array'
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['consumable', 'consumer'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['already_billed'];

    /**
     * Whether the consumption is already considered in the billing
     *
     * @return bool
     */
    public function getAlreadyBilledAttribute()
    {
        return isset($this->bill);
    }

    /**
     * The consumable model attached to the consumption
     *
     * @return MorphTo
     */
    public function consumable()
    {
        return $this->morphTo();
    }

    /**
     * The consumer attached to the consumption
     *
     * @return MorphTo
     */
    public function consumer()
    {
        return $this->morphTo();
    }

    /**
     * The bill in which the consumption was considered
     *
     * @return mixed|null
     */
    public function bill()
    {
        return $this->bills()->first();
    }

    /**
     * The bills in which the consumption was considered
     * Normally there should be only one
     *
     * @return BelongsToMany
     */
    public function bills()
    {
        return $this->belongsToMany(Bill::class);
    }

    /**
     * Scope not already billed consumptions
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeNotAlreadyBilled(Builder $builder)
    {
        return $builder->whereDoesntHave('bills');
    }
}