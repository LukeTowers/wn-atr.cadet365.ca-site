<?php return [
    'plugin' => [
        'name' => 'Cadet Flying Sites',
        'description' => 'Main plugin powering cadetflying.site'
    ],

    'permissions' => [
        'manage_members' => 'Manage Members',
    ],

    'models' => [
        'general' => [
            'created_at'  => 'Created at',
            'updated_at'  => 'Updated at',
            'archived_at' => 'Archived at',
            'code'        => 'Code',
            'yes'         => 'Yes',
            'no'          => 'No',
            'mr'          => 'Mr',
            'mrs'         => 'Mrs',
            'miss'        => 'Miss',
            'name'        => 'Name',
            'code'        => 'Code',
            'address' => [
                'finder'   => 'Address Lookup',
                'label'    => 'Address',
                'line_1'   => 'Line 1',
                'line_2'   => 'Line 2',
                'city'     => 'City',
                'region'   => 'Province / Territory',
                'country'  => 'Country',
                'postcode' => 'Postal Code',
                'notes'    => 'Notes',
            ],
        ],

        'region' => [
            'label'        => 'Region',
            'label_plural' => 'Regions',
        ],

        'site' => [
            'label'        => 'Cadet Flying Site',
            'label_plural' => 'Cadet Flying Sites',
            'acronym'      => 'CFS',
        ],

        'member' => [
            'label'        => 'Member',
            'label_plural' => 'Members',
            'picture'      => 'Picture',
            'surname'      => 'Surname',
            'given_names'  => 'Given Name(s)',
            'dob'          => 'Date of Birth',
            'tab_general'  => 'General Information',
            'sensitive' => [
                'sn'       => 'Service Number',
                'unit'     => 'Unit',
            ],
            'contact'   => [
                'label'    => 'Contact Information',
                'phone'    => 'Phone #',
                'email'    => 'Email',
            ],
            'type'      => [
                'label'    => 'Type',
                'cadet'    => 'Cadet',
                'coats'    => 'COATS (CIC)',
                'cv'       => 'Civilian Volunteer',
                'ci'       => 'Civilian Instructor',
                'regf'     => 'Regular Force',
                'resf'     => 'Reserves',
            ],
            'element' => [
                'label'    => 'Element',
                'air'      => 'Air',
                'army'     => 'Army',
                'sea'      => 'Sea',
            ],
            'rank'      => [
                'label'    => 'Rank',
                'na'       => 'Not Applicable',

                'cdt-ac'   => 'Air Cadet (Cadet)',
                'cdt-lac'  => 'Leading Air Cadet (Cadet)',
                'cdt-cpl'  => 'Corporal (Cadet)',
                'cdt-fcpl' => 'Flight Corporal (Cadet)',
                'cdt-sgt'  => 'Sergeant (Cadet)',
                'cdt-fsgt' => 'Flight Sergeant (Cadet)',
                'cdt-wo2'  => 'Warrant Officer 2nd Class (Cadet)',
                'cdt-wo1'  => 'Warrant Officer 1st Class (Cadet)',

                'cv'       => 'Civilian Volunteer',
                'ci'       => 'Civilian Instructor',
                'ocdt'     => 'Officer Cadet',
                '2lt'      => 'Second Lieutenant',
                'lt'       => 'Lieutenant',
                'capt'     => 'Captain',
                'maj'      => 'Major',
                'lcol'     => 'Lieutenant Colonel',
                'col'      => 'Colonel',
            ],
            'placeholder' => [
                'given_names' => 'Joe',
                'surname'     => 'Bloggins',
                'address'     => '#123 - 1300 Main St., Regina, SK',
                'postcode'    => 'H0H 0H0',
                'relationship' => 'Spouse',
            ]
        ],
    ],
];
