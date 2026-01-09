<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership',
        'label' => 'street',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'street,zip,city,phone,email,www',
        'iconfile' => 'EXT:membershipext/Resources/Public/Icons/tx_membershipext_domain_model_membership.gif',
        'security' => [
            'ignorePageTypeRestriction' => true,
        ],
    ],
    'types' => [
        '1' => ['showitem' => 'street, zip, city, phone, email, www, tags, categories,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language, sys_language_uid, l10n_parent, l10n_diffsource, --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access, hidden, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['label' => '', 'value' => 0],
                ],
                'foreign_table' => 'tx_membershipext_domain_model_membership',
                'foreign_table_where' => 'AND {#tx_membershipext_domain_model_membership}.{#pid}=###CURRENT_PID### AND {#tx_membershipext_domain_model_membership}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'format' => 'datetime',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'format' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'street' => [
            'exclude' => false,
            'label' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.street',
            'description' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.street.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'zip' => [
            'exclude' => false,
            'label' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.zip',
            'description' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.zip.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'city' => [
            'exclude' => false,
            'label' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.city',
            'description' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.city.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'phone' => [
            'exclude' => false,
            'label' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.phone',
            'description' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.phone.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'email' => [
            'exclude' => false,
            'label' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.email',
            'description' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.email.description',
            'config' => [
                'type' => 'email',
                'default' => ''
            ]
        ],
        'www' => [
            'exclude' => false,
            'label' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.www',
            'description' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.www.description',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'default' => ''
            ],
        ],
        'tags' => [
            'exclude' => false,
            'label' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.tags',
            'description' => 'LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_domain_model_membership.tags.description',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_membershipext_domain_model_tag',
                'MM' => 'tx_membershipext_membership_tag_mm',
            ],

        ],
        'categories' => [
            'exclude' => true,
            'label' => 'Categories',
            'config' => [
                'type' => 'category',
                'relationship' => 'manyToMany',
            ],
        ],

    ],
];
