<?php

/*
 * Bill.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  24/11/2020 20:31
 */

namespace Undjike\BillingSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

/**
 * @property-read float|mixed $due_amount
 * @property-read float|mixed $total_collected
 * @property-read float|mixed $to_be_collected
 */
class Bill extends Model
{
    use SoftDeletes, HasStatuses;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['details', 'due_amount'];

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
    protected $with = ['billable'];

    /**
     * Total amount collected on the bill
     *
     * @return int|float|mixed
     */
    public function getTotalCollectedAttribute()
    {
        return $this->collections()->sum('amount');
    }

    /**
     * Remaining amount to be collected on the bill
     *
     * @return int|float|mixed
     */
    public function getToBeCollectedAttribute()
    {
        return $this->due_amount - $this->total_collected;
    }

    /**
     * The billable model owning the bill
     *
     * @return MorphTo
     */
    public function billable()
    {
        return $this->morphTo();
    }

    /**
     * All the collections made on the bill for recovery
     *
     * @return HasMany
     */
    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    /**
     * All consumptions considered in the bill
     *
     * @return BelongsToMany
     */
    public function consumptions()
    {
        return $this->belongsToMany(Consumption::class);
    }
}