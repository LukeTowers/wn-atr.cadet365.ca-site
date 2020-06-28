<?php namespace ACGP\FlyingSite\Models;

use Lang;
use Model;

/**
 * Model
 */
class Member extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Encryptable;

    /**
     * @var array Behaviors implemented by this model class
     */
    public $implement = ['@LukeTowers.EasyAudit.Behaviors.TrackableModel'];

    /**
     * Set the soft delete column name to archived_at
     */
    const DELETED_AT = 'archived_at';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'acgp_flyingsite_members';

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
    public $hasOne = [
        'pen_form' => [PenForm::class],
    ];

    /**
     * Ensure that the member always has an accompanying PEN Form record
     */
    public function afterCreate()
    {
        // $penForm = new PenForm();
        // $penForm->member_id = $this->id;
        // $penForm->save();
    }

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
                    'ocdt' => 'acgp.flyingsite::lang.models.member.rank.ocdt',
                    '2lt'  => 'acgp.flyingsite::lang.models.member.rank.2lt',
                    'lt'   => 'acgp.flyingsite::lang.models.member.rank.lt',
                    'capt' => 'acgp.flyingsite::lang.models.member.rank.capt',
                    'maj'  => 'acgp.flyingsite::lang.models.member.rank.maj',
                    'lcol' => 'acgp.flyingsite::lang.models.member.rank.lcol',
                    'col'  => 'acgp.flyingsite::lang.models.member.rank.col',
                ];
                break;
            case 'ci':
            case 'cv':
                $ranks = ['na' => 'acgp.flyingsite::lang.models.member.rank.na'];
                break;
            case 'cadet':
            default:
                $ranks = [
                    'cdt-ac'   => 'acgp.flyingsite::lang.models.member.rank.cdt-ac',
                    'cdt-lac'  => 'acgp.flyingsite::lang.models.member.rank.cdt-lac',
                    'cdt-cpl'  => 'acgp.flyingsite::lang.models.member.rank.cdt-cpl',
                    'cdt-fcpl' => 'acgp.flyingsite::lang.models.member.rank.cdt-fcpl',
                    'cdt-sgt'  => 'acgp.flyingsite::lang.models.member.rank.cdt-sgt',
                    'cdt-fsgt' => 'acgp.flyingsite::lang.models.member.rank.cdt-fsgt',
                    'cdt-wo2'  => 'acgp.flyingsite::lang.models.member.rank.cdt-wo2',
                    'cdt-wo1'  => 'acgp.flyingsite::lang.models.member.rank.cdt-wo1',
                ];
                break;
        }

        return $ranks;
    }

    /**
     * Get the human-readable version of the type
     * @return string
     */
    public function getTypeCleanAttribute()
    {
        return Lang::get("acgp.flyingsite::lang.models.member.type.{$this->type}");
    }

    /**
     * Get the human-readable version of the rank
     * @return string
     */
    public function getRankCleanAttribute()
    {
        return Lang::get("acgp.flyingsite::lang.models.member.rank.{$this->rank}");
    }

    /**
     * Accessor for full name which includes first_name and last_name
     * @return string first_name [space] last_name
     */
    public function getFullNameAttribute()
    {
        return $this->given_names . ' ' . $this->surname;
    }
    public function getNameAttribute()
    {
        return $this->full_name;
    }
}
