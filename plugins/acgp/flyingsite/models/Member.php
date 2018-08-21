<?php namespace ACGP\FlyingSite\Models;

use Lang;
use Model;
use System\Models\File as FileModel;

/**
 * Model
 */
class Member extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Encryptable;

    /**
     * Set the soft delete column name to archived_at
     */
    protected const DELETED_AT = 'archived_at';

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
        'rank'                => 'required',
        'sensitive_data.unit' => 'required',
        'sensitive_data.sn'   => 'required_if:type,coats,ci,regf,resf',
        'date_of_birth'       => 'required_if:type,cadet,coats,resf',
        'contact_data.phone'  => 'required',
        'contact_data.email'  => 'required|email',
    ];

    /**
     * @var array List of attributes to encrypt
     */
    protected $encryptable = ['contact_data', 'sensitive_data'];

    /**
     * Relations
     */
    public $attachOne = [
        'photo'           => [FileModel::class, 'public' => false],
        'cachedPENForm'   => [EncryptedFile::class, 'public' => false],
        'pen_sig'         => [FileModel::class, 'public' => false],
        'pen_witness_sig' => [FileModel::class, 'public' => false],
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


    public function getPenFormAttribute()
    {
        return false;
        // Check to see if the form has been generated already and if the cached version is still valid
        if ($this->cachedPENForm && $this->updated_at->lt($this->cachedPENForm->updated_at)) {
            return $this->cachedPENForm;
        } else {
            // Render the form

            // Array holding the mapping of the data keys to the form field names
            $mapping = [
                'general' => [
                    'sn'          => 'SN',
                    'rank'        => 'Rank',
                    'surname'     => 'Surname',
                    'given_names' => 'Given_names',
                    'component'   => [
                        'key'      => 'Component',
                        'regular'  => 'Regular',
                        'reserve'  => 'Reserve',
                        'civilian' => 'Civilian',
                    ],
                ],
                'primary' => [
                    'honorific'   => [
                        'key'  => '1_honorific',
                        'mr'   => '1_mr',
                        'mrs'  => '1_mrs',
                        'miss' => '1_miss',
                    ],
                    'surname'     => '1_surname',
                    'given_names' => '1_given_names',
                    'address'     => '1_address',
                    'postcode'    => '1_postcode',
                    'relationship' => '1_relationship',
                    'language'     => '1_language',
                    'religion'     => '1_religion',
                    'home_area'    => '1_home_area',
                    'home_number'  => '1_home_number',
                    'office_area'  => '1_office_area',
                    'office_number' => '1_office_number',
                ],
                'secondary' => [
                    'honorific'   => [
                        'key'  => '2_honorific',
                        'mr'   => '2_mr',
                        'mrs'  => '2_mrs',
                        'miss' => '2_miss',
                    ],
                    'surname'     => '2_surname',
                    'given_names' => '2_given_names',
                    'address'     => '2_address',
                    'postcode'    => '2_postcode',
                    'relationship' => '2_relationship',
                    'language'     => '2_language',
                    'religion'     => '2_religion',
                    'home_area'    => '2_home_area',
                    'home_number'  => '2_home_number',
                    'office_area'  => '2_office_area',
                    'office_number' => '2_office_number',
                ],
                'pen_contact' => [
                    'contact_choice' => [
                        'key'    => '3_contact_choice',
                        'same_1' => '3_same_1',
                        'same_2' => '3_same_2',
                    ],
                    'honorific'   => [
                        'key'  => '3_honorific',
                        'mr'   => '3_mr',
                        'mrs'  => '3_mrs',
                        'miss' => '3_miss',
                    ],
                    'surname'     => '3_surname',
                    'given_names' => '3_given_names',
                    'address'     => '3_address',
                    'postcode'    => '3_postcode',
                    'relationship' => '3_relationship',
                    'language'     => '3_language',
                    'religion'     => '3_religion',
                    'home_area'    => '3_home_area',
                    'home_number'  => '3_home_number',
                    'office_area'  => '3_office_area',
                    'office_number' => '3_office_number',
                ],
                'release_to_contact' => [
                    'same_1' => '4_same_1',
                    'same_2' => '4_same_2',
                    'same_3' => '4_same_3',
                    'or'     => [
                        'key' => '4_contact_choice',
                        'true' => '4_or',
                    ],
                    'and' => '4_and',
                    'honorific'   => [
                        'key'  => '4_honorific',
                        'mr'   => '4_mr',
                        'mrs'  => '4_mrs',
                        'miss' => '4_miss',
                    ],
                    'surname'     => '4_surname',
                    'given_names' => '4_given_names',
                    'address'     => '4_address',
                    'postcode'    => '4_postcode',
                    'relationship' => '4_relationship',
                    'language'     => '4_language',
                    'religion'     => '4_religion',
                    'home_area'    => '4_home_area',
                    'home_number'  => '4_home_number',
                    'office_area'  => '4_office_area',
                    'office_number' => '4_office_number',
                ],
                'authority_to_release' => [
                    'authorized' => [
                        'key'   => 'authorized_release',
                        'true'  => 'auth_yes',
                        'false' => 'auth_no',
                    ],
                ],
                'reserve_force' => [
                    'unit' => 'unit',
                    'unit_of_employment' => 'unit_of_employment',
                    'duty_type' => 'duty_type',
                    'duty_commence_date' => 'duty_commence_date',
                    'duty_terminate_date' => 'duty_terminate_date',
                    'date_of_birth' => 'date_of_birth',
                ],
                'remarks' => [
                    'remarks' => 'remarks',
                ],
                'final' => [
                    'member_signature'       => 'member_signature',
                    'member_signature_date'  => 'member_signature_date',
                    'witness_signature'      => 'witness_signature',
                    'witness_signature_date' => 'witness_signature_date',
                ],
            ];


            $data = [];




            // Header. General member information
            $general = [
                'surname'     => $this->surname,
                'given_names' => $this->given_names
            ];
            switch ($this->type) {
                case 'regf':
                    $general['sn'] = $this->sensitive_data['sn'];
                    $general['rank'] = $this->rank;
                    $general['component'] = 'regular';
                    break;
                case 'coats':
                case 'resv':
                    $general['sn'] = $this->sensitive_data['sn'];
                    $general['rank'] = $this->rank;
                    $general['component'] = 'reserve';
                    break;
                case 'cadet':
                    $general['sn'] = 'N/A';
                    $general['rank'] = 'N/A';
                    $general['component'] = 'civilian';
                    break;
                case 'cv':
                    $general['sn'] = 'N/A';
                    $general['rank'] = 'N/A';
                    $general['component'] = 'civilian';
                    break;
                case 'ci':
                    $general['sn'] = 'N/A';
                    $general['rank'] = 'N/A';
                    $general['component'] = 'civilian';
                    break;
            }

            // 5. Authority to release / exchange information
            $data['authority_to_release'] = [
                'authorized' => (bool) $this->sensitive_data['pen']['authority_to_release'],
            ];

            // 6. Reserve Force Personnel
            $reserve = [
                'unit' => 'N/A',
                'unit_of_employment' => 'N/A',
                'duty_type' => 'N/A',
                'duty_commence_date' => 'N/A',
                'duty_terminate_date' => 'N/A',
                'date_of_birth' => 'N/A',
            ];
            if ($this->type === 'resv' || $this->type === 'coats') {
                $reserve = [
                    'unit' => $this->sensitive_data['unit'],
                    // TODO: 'unit_of_employment' => $this->sensitive_data['unit_of_employment'],
                    // TODO: 'duty_type' => $this->sensitive_data['duty_type'],
                    // TODO: 'duty_commence_date' => $this->sensitive_data['duty_commence_date'],
                    // TODO: 'duty_terminate_date' => $this->sensitive_data['duty_terminate_date'],
                    'date_of_birth' => $this->date_of_birth,
                ];
            }

            // 7. Remarks
            $data['remarks']['remarks'] = $this->sensitive_data['pen']['remarks'];

            // 8. Signature
            $data['final'] = [
                'member_signature'       => '',
                'member_signature_date'  => '', // TODO: should we insert dates?
                'witness_signature'      => '',
                'witness_signature_date' => '', // TODO: should we insert dates?
            ];

$data = [
 'primary' => [
     'honorific'   => [
         'key'  => '1_honorific',
         'mr'   => '1_mr',
         'mrs'  => '1_mrs',
         'miss' => '1_miss',
     ],
     'surname'     => '1_surname',
     'given_names' => '1_given_names',
     'address'     => '1_address',
     'postcode'    => '1_postcode',
     'relationship' => '1_relationship',
     'language'     => '1_language',
     'religion'     => '1_religion',
     'home_area'    => '1_home_area',
     'home_number'  => '1_home_number',
     'office_area'  => '1_office_area',
     'office_number' => '1_office_number',
 ],
 'secondary' => [
     'honorific'   => [
         'key'  => '2_honorific',
         'mr'   => '2_mr',
         'mrs'  => '2_mrs',
         'miss' => '2_miss',
     ],
     'surname'     => '2_surname',
     'given_names' => '2_given_names',
     'address'     => '2_address',
     'postcode'    => '2_postcode',
     'relationship' => '2_relationship',
     'language'     => '2_language',
     'religion'     => '2_religion',
     'home_area'    => '2_home_area',
     'home_number'  => '2_home_number',
     'office_area'  => '2_office_area',
     'office_number' => '2_office_number',
 ],
 'pen_contact' => [
     'contact_choice' => [
         'key'    => '3_contact_choice',
         'same_1' => '3_same_1',
         'same_2' => '3_same_2',
     ],
     'honorific'   => [
         'key'  => '3_honorific',
         'mr'   => '3_mr',
         'mrs'  => '3_mrs',
         'miss' => '3_miss',
     ],
     'surname'     => '3_surname',
     'given_names' => '3_given_names',
     'address'     => '3_address',
     'postcode'    => '3_postcode',
     'relationship' => '3_relationship',
     'language'     => '3_language',
     'religion'     => '3_religion',
     'home_area'    => '3_home_area',
     'home_number'  => '3_home_number',
     'office_area'  => '3_office_area',
     'office_number' => '3_office_number',
 ],
 'release_to_contact' => [
     'same_1' => '4_same_1',
     'same_2' => '4_same_2',
     'same_3' => '4_same_3',
     'or'     => [
         'key' => '4_contact_choice',
         'true' => '4_or',
     ],
     'and' => '4_and',
     'honorific'   => [
         'key'  => '4_honorific',
         'mr'   => '4_mr',
         'mrs'  => '4_mrs',
         'miss' => '4_miss',
     ],
     'surname'     => '4_surname',
     'given_names' => '4_given_names',
     'address'     => '4_address',
     'postcode'    => '4_postcode',
     'relationship' => '4_relationship',
     'language'     => '4_language',
     'religion'     => '4_religion',
     'home_area'    => '4_home_area',
     'home_number'  => '4_home_number',
     'office_area'  => '4_office_area',
     'office_number' => '4_office_number',
 ],

];

             $pdf = new \FPDM(plugins_path('acgp/flyingsite/views/pen-fdf-template.pdf'));
             $test = $pdf->parsePDFEntries($data);

             dd($pdf, $data, $test);
         }
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
}
