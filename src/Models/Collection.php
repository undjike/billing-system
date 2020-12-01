<?php

/*
 * Collection.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    billing-system
 *
 *  Copyright 2020
 *  24/11/2020 20:33
 */

namespace Undjike\BillingSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read Bill bill
 */
class Collection extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['details', 'amount', 'bill_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['bill_id'];

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
    protected $with = ['bill'];

    /**
     * The bill collected
     *
     * @return BelongsTo
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}