<?php

namespace ACFP\PEN\Models;

use ACFP\ATR\Models\EncryptedFile;
use ACFP\ATR\Models\Member;
use Winter\Storm\Database\Model;

/**
 * PenForm Model
 */
class PenForm extends Model
{
    use \Winter\Storm\Database\Traits\Encryptable;
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'acfp_pen_pen_forms';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'sensitive_data.pen.nok.*.given_names' => 'required',
        'sensitive_data.pen.nok.*.surname' => 'required',
        'sensitive_data.pen.nok.*.honorific' => 'required',
        'sensitive_data.pen.nok.*.address' => 'required',
        'sensitive_data.pen.nok.*.postcode' => 'required',
        'sensitive_data.pen.nok.*.relationship' => 'required',

        'sensitive_data.pen.pen_contact_choice' => 'required',

        'sensitive_data.pen.pen_contact.*.given_names' => 'required_if:sensitive_data.pen.pen_contact_choice,or',
        'sensitive_data.pen.pen_contact.*.surname' => 'required_if:sensitive_data.pen.pen_contact_choice,or',
        'sensitive_data.pen.pen_contact.*.honorific' => 'required_if:sensitive_data.pen.pen_contact_choice,or',
        'sensitive_data.pen.pen_contact.*.address' => 'required_if:sensitive_data.pen.pen_contact_choice,or',
        'sensitive_data.pen.pen_contact.*.postcode' => 'required_if:sensitive_data.pen.pen_contact_choice,or',
        'sensitive_data.pen.pen_contact.*.relationship' => 'required_if:sensitive_data.pen.pen_contact_choice,or',

        'sensitive_data.pen.authorized_contact_choice' => 'required_without:sensitive_data.pen.authorized_contact_choice_or_and',

        'sensitive_data.pen.authorized_contact.*.given_names' => 'required_with:sensitive_data.pen.authorized_contact_choice_or_and',
        'sensitive_data.pen.authorized_contact.*.surname' => 'required_with:sensitive_data.pen.authorized_contact_choice_or_and',
        'sensitive_data.pen.authorized_contact.*.honorific' => 'required_with:sensitive_data.pen.authorized_contact_choice_or_and',
        'sensitive_data.pen.authorized_contact.*.address' => 'required_with:sensitive_data.pen.authorized_contact_choice_or_and',
        'sensitive_data.pen.authorized_contact.*.postcode' => 'required_with:sensitive_data.pen.authorized_contact_choice_or_and',
        'sensitive_data.pen.authorized_contact.*.relationship' => 'required_with:sensitive_data.pen.authorized_contact_choice_or_and',
    ];

    /**
     * @var array List of attributes to encrypt
     */
    protected $encryptable = ['sensitive_data'];

    /**
     * Relations
     */
    public $attachOne = [
        'generatedFile' => [EncryptedFile::class, 'public' => false],
    ];
    public $belongsTo = [
        'member' => [Member::class],
    ];


    public function beforeSave()
    {
        // Cleanup PEN form data
        if ($this->exists && empty($this->sensitive_data['pen']['authorized_contact']['surname'])) {
            $this->sensitive_data = array_merge($this->sensitive_data, ['pen' => ['authorized_contact_choice_or_and' => false]]);
        }
    }

    public function getFileAttribute()
    {
        return false;
        // Check to see if the form has been generated already and if the cached version is still valid
        $lastGenerated = $this->generatedFile->updated_at;
        if ($this->generatedFile && $this->updated_at->lt($lastGenerated) && $this->member->updated_at->lt($lastGenerated)) {
            return $this->generatedFile;
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
                        'or'     => '3_or',
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
                    'contact_choice' => [
                        'key'    => '4_contact_choice',
                        'or'     => '4_or',
                        'and'    => '4_and',
                    ],
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
                'surname'     => $this->member->surname,
                'given_names' => $this->member->given_names
            ];
            switch ($this->member->type) {
                case 'regf':
                    $general['sn'] = $this->member->sensitive_data['sn'];
                    $general['rank'] = $this->member->rank;
                    $general['component'] = 'regular';
                    break;
                case 'coats':
                case 'resv':
                    $general['sn'] = $this->member->sensitive_data['sn'];
                    $general['rank'] = $this->member->rank;
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
            $data['general'] = $general;

            // 1. Primary Next of Kin
            $data['primary'] = $this->sensitive_data['pen']['nok'][0];

            // 2. Secondary Next of Kin
            $data['secondary'] = $this->sensitive_data['pen']['nok'][1];

            // 3. PEN Contact
            $data['pen_contact'] = $this->sensitive_data['pen']['pen_contact'][0];
            // TODO: $data['contact_choice'] =

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
            if ($this->member->type === 'resv' || $this->member->type === 'coats') {
                $reserve = [
                    'unit' => $this->member->sensitive_data['unit'],
                    // TODO: 'unit_of_employment' => $this->sensitive_data['unit_of_employment'],
                    // TODO: 'duty_type' => $this->sensitive_data['duty_type'],
                    // TODO: 'duty_commence_date' => $this->sensitive_data['duty_commence_date'],
                    // TODO: 'duty_terminate_date' => $this->sensitive_data['duty_terminate_date'],
                    'date_of_birth' => $this->member->date_of_birth,
                ];
            }
            $data['reserve_force'] = $reserve;

            // 7. Remarks
            $data['remarks']['remarks'] = $this->sensitive_data['pen']['remarks'];

            // 8. Signature
            $data['final'] = [
                'member_signature'       => '',
                'member_signature_date'  => '', // TODO: should we insert dates?
                'witness_signature'      => '',
                'witness_signature_date' => '', // TODO: should we insert dates?
            ];

            dd($data);

            $data = [

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

            $pdf = new \FPDM(plugins_path('acfp/pen/views/pen-fdf-template.pdf'));
            $test = $pdf->parsePDFEntries($data);

            dd($pdf, $data, $test);
         }
     }
}
