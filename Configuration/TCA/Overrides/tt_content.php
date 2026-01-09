<?php
defined('TYPO3') || die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'Membershipext',
    'membershipplug',
    'membershipplug',
    'membershipext_membershipplug'
);

if (!is_array($GLOBALS['TCA']['tt_content']['types']['membershipext_membershipplug'] ?? false)) {
    $GLOBALS['TCA']['tt_content']['types']['membershipext_membershipplug'] = [];
}

// Add content element to selector list
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'label' => 'membershipplug',
        'value' => 'membershipext_membershipplug',
        'icon'  => 'tx_membershipext_membershipplug',
        'group' => 'membershipext'
    ]
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:membershipext/Configuration/FlexForms/flexform_membershipplug.xml',
    'membershipext_membershipplug'
);

$GLOBALS['TCA']['tt_content']['types']['membershipext_membershipplug']['showitem'] = '
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        --palette--;;general,
        --palette--;;headers,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.plugin,
        pi_flexform,
    --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
        --palette--;;frames,
        --palette--;;appearanceLinks,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
        --palette--;;language,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
        --palette--;;hidden,
        --palette--;;access,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
        categories,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
        rowDescription,
    --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
';
