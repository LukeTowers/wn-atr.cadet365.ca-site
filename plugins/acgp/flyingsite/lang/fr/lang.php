<?php return [

    'models' => [

        'general' => [
            'yes'         => 'Oui',
            'no'          => 'Non',
            'mr'          => 'M.',
            'mrs'         => 'Mmme',
            'miss'        => 'Mlle',
            'address' => [
                'label'    => 'Adresse',
                'city'     => 'Ville',
                'region'   => 'Région',
                'country'  => 'Pays',
                'postcode' => 'Code postal',
            ],
        ],

        'member' => [
            'surname'      => 'Nom',
            'given_names'  => 'Prénoms',
            'dob'          => 'Date de naissance',
            'pen'       => [
                'nok'                     => 'Plus proche parent',
                'add_nok'                 => 'Ajouter plus proche parent',
                'pen_contact'             => "Personne à prévenir en cas d'urgence",
                'pen_contact_desc'        => 'Première personne à être avisée',
                'add_pen_contact'         => 'Ajouter première personne à être avisée',
                'authorized_contact'      => 'Autorité de divulguer des renseignements au PPP / ou personne désignée',
                'authorized_contact_desc' => 'Personne autorisée à accéder à mon information personnelle',
                'add_authorized_contact'  => 'Ajouter Personne autorisée à accéder à mon information personnelle',
                'same_1'                  => 'Plus proche parent',
                'same_2'                  => 'Deuxième plus proche parent',
                'same_3'                  => 'Première personne à être avisée',
                'or'                      => 'Ou',
                'and'                     => 'Et',
                'honorific'               => 'Honorifique',
                'relationship'            => 'Lien de parenté',
                'language'                => 'Langue',
                'religion'                => 'Religion (optionnel)',
                'home_area'               => 'Téléphone domicile (area)',
                'home_number'             => 'Téléphone domicile (number)',
                'office_area'             => 'Téléphone bureau (area)',
                'office_number'           => 'Téléphone bureau (number)',
                'authorization_section'   => 'Autorisation de communiquer / échanger des renseignements',
                'authority_to_release'    => "J'autorise le ministère de la Défense nationale et Anciens Combattants du Canada à échanger des renseignements dans l'éventualité que je souffre d'une blessure / maladie ou lors de mon décès. Les renseignements serviront seulement à déterminer mon admissibilité à des avantages et indemnités.",
                'remarks'                 => 'Remarques',
            ],

            'type'      => [
                'label'    => 'Élément',
                'regf'     => 'Régulière',
                'resf'     => 'Réserve',
            ],

            'rank'      => [
                'label'    => 'Grade',
            ],
        ],
    ],
];
