<?php

namespace ACFP\ATR\Models;

use Winter\Storm\Database\Model;

/**
 * Model
 */
class Site extends Model
{
    use \Winter\Storm\Database\Traits\Sluggable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'acfp_atr_sites';

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array List of attributes to automatically generate unique URL names (slugs) for.
     */
    protected $slugs = ['code' => 'name'];

    /**
     * Relations
     */
    public $belongsTo = [
        'region' => [Region::class],
    ];
}
