<?php
defined('TYPO3') || die();

(static function() {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Membershipext',
        'Membershipplug',
        [
            \membershipext\Membershipext\Controller\MembershipController::class => 'list, show, ajaxList'
        ],
        [
            \membershipext\Membershipext\Controller\MembershipController::class => 'list, show, ajaxList'
        ],
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.ext-membershipext {
                header = membershipext
                after = common
                elements {
                    membershipplug {
                        iconIdentifier = tx_membershipext_membershipplug
                        title = LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_membershipplug.name
                        description = LLL:EXT:membershipext/Resources/Private/Language/locallang_db.xlf:tx_membershipext_membershipplug.description
                        tt_content_defValues {
                            CType = membershipext_membershipplug
                        }
                    }
                }
                show = *
            }
       }'
    );
})();
