<?php

return [
    'plugin' => [
        'name' => 'PEN',
        'description' => 'No description provided yet...',
    ],
    'permissions' => [
        'some_permission' => 'Some permission',
    ],
    'models' => [
        'general' => [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ],
        'penform' => [
            'label' => 'PEN Form',
            'label_plural' => 'PEN Forms',
            'nok'                     => 'Primary & secondary next of kin',
            'add_nok'                 => 'Add Next of Kin',
            'pen_contact'             => 'Personal emergency notification contact',
            'pen_contact_desc'        => 'First person to be notified',
            'add_pen_contact'         => 'Add first person to be notified',
            'authorized_contact'      => 'Authority to release information to NOK / PEN contact',
            'authorized_contact_desc' => 'Person authorized to have access to my personal information',
            'add_authorized_contact'  => 'Add Authorized Contact',
            'same_1'                  => 'Primary Next-of-Kin',
            'same_2'                  => 'Secondary Next-of-Kin',
            'same_3'                  => 'First person to be notified',
            'or'                      => 'Or',
            'and'                     => 'And',
            'honorific'               => 'Honorific',
            'relationship'            => 'Relationship',
            'language'                => 'Language',
            'religion'                => 'Religion (optional)',
            'home_area'               => 'Home # (area)',
            'home_number'             => 'Home # (number)',
            'office_area'             => 'Office # (area)',
            'office_number'           => 'Office # (number)',
            'authorization_section'   => 'Authority to release / exchange information',
            'authority_to_release'    => 'I authorize the department of National Defence and Veterans Affairs Canada to exchange information in the event that I suffer from an injury / illness or die. This information will be used only to determine my eligibility for benefits and compensation.',
            'remarks'                 => 'Remarks',
        ]
    ],
];
