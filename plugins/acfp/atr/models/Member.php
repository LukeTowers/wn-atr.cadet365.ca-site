<?php

namespace ACFP\ATR\Models;

use Illuminate\Support\Facades\Lang;
use Winter\Storm\Database\Model;

/**
 * Model
 */
class Member extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use \Winter\Storm\Database\Traits\SoftDelete;
    use \Winter\Storm\Database\Traits\Encryptable;

    /**
     * @var array Behaviors implemented by this model class
     */
    public $implement = [
        '@LukeTowers.EasyAudit.Behaviors.TrackableModel',
    ];

    /**
     * Set the soft delete column name to archived_at
     */
    const DELETED_AT = 'archived_at';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'acfp_atr_members';

    /**
     * @var array The properties to be cast to dates
     */
    protected $dates = ['created_at', 'updated_at', 'archived_at'];

    /**
     * @var array Validation Rules
     */
    public $rules = [
        'given_names'         => 'required',
        'surname'             => 'required',
        'type'                => 'required',
        'element'             => 'required',
        'rank'                => 'required',
        'sensitive_data.unit' => 'required',
        'sensitive_data.sn'   => 'required_if:type,coats,ci,regf,resf',
        'date_of_birth'       => 'required_if:type,cadet,coats,resf',
        'contact_data.email'  => 'required|email',
        'contact_data.phone'  => 'required',
    ];

    /**
     * @var array List of attributes to encrypt
     */
    protected $encryptable = ['contact_data', 'sensitive_data'];

    /**
     * @var array The model events that are to be tracked as activities
     */
    public $trackableEvents = [
        'model.afterUpdate' => ['name' => 'updated', 'description' => 'The member profile was updated'],
        'model.afterCreate' => ['name' => 'created', 'description' => 'The member profile was created'],
        'model.afterDelete' => ['name' => 'archived', 'description' => 'The member profile was archived'],
    ];

    /**
     * Relations
     */
    public $attachOne = [
        'picture' => [\System\Models\File::class, ['public' => false]],
    ];

    /**
     * Get the available rank options based on the current type
     * @return array $ranks
     */
    public function getRankOptions()
    {
        $ranks = [];

        switch ($this->type) {
            case 'coats':
            case 'regf':
            case 'resf':
                $ranks = [
                    'ocdt' => 'acfp.atr::lang.models.member.rank.ocdt',
                    '2lt'  => 'acfp.atr::lang.models.member.rank.2lt',
                    'lt'   => 'acfp.atr::lang.models.member.rank.lt',
                    'capt' => 'acfp.atr::lang.models.member.rank.capt',
                    'maj'  => 'acfp.atr::lang.models.member.rank.maj',
                    'lcol' => 'acfp.atr::lang.models.member.rank.lcol',
                    'col'  => 'acfp.atr::lang.models.member.rank.col',
                ];
                break;
            case 'ci':
            case 'cv':
                $ranks = ['na' => 'acfp.atr::lang.models.member.rank.na'];
                break;
            case 'cadet':
            default:
                $ranks = [
                    'cdt-ac'   => 'acfp.atr::lang.models.member.rank.cdt-ac',
                    'cdt-lac'  => 'acfp.atr::lang.models.member.rank.cdt-lac',
                    'cdt-cpl'  => 'acfp.atr::lang.models.member.rank.cdt-cpl',
                    'cdt-fcpl' => 'acfp.atr::lang.models.member.rank.cdt-fcpl',
                    'cdt-sgt'  => 'acfp.atr::lang.models.member.rank.cdt-sgt',
                    'cdt-fsgt' => 'acfp.atr::lang.models.member.rank.cdt-fsgt',
                    'cdt-wo2'  => 'acfp.atr::lang.models.member.rank.cdt-wo2',
                    'cdt-wo1'  => 'acfp.atr::lang.models.member.rank.cdt-wo1',
                ];
                break;
        }

        return $ranks;
    }

    /**
     * Get the human-readable version of the type
     */
    public function getTypeCleanAttribute(): string
    {
        return Lang::get("acfp.atr::lang.models.member.type.{$this->type}");
    }

    /**
     * Get the human-readable version of the rank
     */
    public function getRankCleanAttribute(): string
    {
        return Lang::get("acfp.atr::lang.models.member.rank.{$this->rank}");
    }

    /**
     * Accessor for full name which includes first_name and last_name
     */
    public function getFullNameAttribute(): string
    {
        return $this->given_names . ' ' . $this->surname;
    }
    public function getNameAttribute(): string
    {
        return $this->full_name;
    }
}
