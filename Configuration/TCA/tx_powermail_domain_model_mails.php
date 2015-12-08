<?php
use In2code\Powermail\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

$typeDefault = 'crdate, receiver_mail, ' .
    '--palette--;LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
    'tx_powermail_domain_model_mails.palette1;1, ' .
    'subject, body, ' .
    '--div--;LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
    'tx_powermail_domain_model_fields.sheet1, ' .
    'form, answers, feuser, spam_factor, time, sender_ip, user_agent, ' .
    '--div--;LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
    'tx_powermail_domain_model_fields.sheet2, ' .
    'marketing_referer_domain, marketing_referer, marketing_country, marketing_mobile_device, ' .
    'marketing_frontend_language, marketing_browser_language, marketing_page_funnel, ' .
    '--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access, hidden, starttime, endtime';
$rteIconPath = 'EXT:backend/Resources/Public/Images/FormFieldWizard/wizard_rte.gif';
if (!GeneralUtility::compat_version('7.6')) {
    // todo remove condition for TYPO3 6.2 in upcoming major version
    $typeDefault = str_replace('body', 'body;;;richtext[]', $typeDefault);
    $rteIconPath = 'wizard_rte2.gif';
}

$mailsTca = [
    'ctrl' => [
        'title' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:tx_powermail_domain_model_mails',
        'label' => 'sender_mail',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'versioningWS' => 2,
        'versioning_followPages' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'default_sortby' => 'ORDER BY crdate DESC',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'iconfile' => ConfigurationUtility::getIconPath('tx_powermail_domain_model_mails.gif'),
        'searchFields' => 'sender_mail, sender_name, subject, body'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, ' .
            'crdate, receiver_mail, sender_name, sender_mail, subject, form, answers, body, ' .
            'feuser, spam_factor, time, sender_ip, user_agent, marketing_referer_domain, ' .
            'marketing_referer, marketing_country, marketing_mobile_device, ' .
            'marketing_frontend_language, marketing_browser_language, marketing_page_funnel',
    ],
    'types' => [
        '1' => [
            'showitem' => $typeDefault,
            'columnsOverrides' => [
                'body' => [
                    'defaultExtras' => 'richtext[]'
                ]
            ]
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => 'sender_name, sender_mail'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'sys_language',
                'renderType' => 'selectSingle',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    ['LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1],
                    ['LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0]
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_powermail_domain_model_mails',
                'foreign_table_where' => 'AND tx_powermail_domain_model_mails.pid=###CURRENT_PID### AND ' .
                    'tx_powermail_domain_model_mails.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ]
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ],
            ],
        ],
        'crdate' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.crdate',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'datetime',
                'readOnly' => 1
            ],
        ],
        'receiver_mail' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.receiver_mail',
            'config' => [
                'type' => 'text',
                'cols' => '30',
                'rows' => '5'
            ],
        ],
        'sender_mail' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.sender_mail',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'sender_name' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.sender_name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'subject' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.subject',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'body' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.body',
            'config' => [
                'type' => 'text',
                'cols' => '30',
                'rows' => '5',
                'wizards' => [
                    '_PADDING' => 2,
                    'RTE' => [
                        'notNewRecords' => 1,
                        'RTEonly' => 1,
                        'type' => 'script',
                        'title' => 'RTE',
                        'icon' => $rteIconPath,
                        'module' => [
                            'name' => 'wizard_rte'
                        ]
                    ],
                ],
            ],
        ],
        'form' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'x_powermail_domain_model_mails.form',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_powermail_domain_model_forms',
                'foreign_table_where' => 'AND tx_powermail_domain_model_forms.deleted = 0 AND ' .
                    'tx_powermail_domain_model_forms.hidden = 0 order by tx_powermail_domain_model_forms.title',
            ],
        ],
        'answers' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.answers',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_powermail_domain_model_answers',
                'foreign_field' => 'mail',
                'maxitems' => 1000,
                'appearance' => [
                    'collapse' => 1,
                    'levelLinksPosition' => 'top',
                    'showSynchronizationLink' => 1,
                    'showPossibleLocalizationRecords' => 1,
                    'showAllLocalizationLink' => 1
                ],
            ],
        ],
        'feuser' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.feuser',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1
            ]
        ],
        'spam_factor' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.spam_factor',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'eval' => 'trim',
                'readOnly' => 1
            ],
        ],
        'time' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.time',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'timesec',
                'checkbox' => 0,
                'default' => 0,
                'readOnly' => 1
            ],
        ],
        'sender_ip' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.sender_ip',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'readOnly' => 1
            ],
        ],
        'user_agent' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.user_agent',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim',
                'readOnly' => 1
            ],
        ],
        'marketing_referer_domain' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.marketing_referer_domain',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'readOnly' => 1
            ],
        ],
        'marketing_referer' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.marketing_referer',
            'config' => [
                'type' => 'text',
                'cols' => '30',
                'rows' => '5',
                'readOnly' => 1
            ],
        ],
        'marketing_country' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.marketing_country',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'readOnly' => 1
            ],
        ],
        'marketing_mobile_device' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.marketing_mobile_device',
            'config' => [
                'type' => 'check',
                'readOnly' => 1
            ],
        ],
        'marketing_frontend_language' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.marketing_frontend_language',
            'config' => [
                'type' => 'input',
                'size' => 2,
                'eval' => 'int',
                'readOnly' => 1
            ],
        ],
        'marketing_browser_language' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.marketing_browser_language',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'readOnly' => 1
            ],
        ],
        'marketing_page_funnel' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:powermail/Resources/Private/Language/locallang_db.xlf:' .
                'tx_powermail_domain_model_mails.marketing_page_funnel',
            'config' => [
                'type' => 'text',
                'cols' => '30',
                'rows' => '5',
                'readOnly' => 1
            ],
        ],
        'uid' => [
            'exclude' => 1,
            'label' => 'UID',
            'config' => [
                'type' => 'none',
            ],
        ],
    ],
];

if (ConfigurationUtility::isDisableMarketingInformationActive()) {
    foreach (array_keys($mailsTca['columns']) as $columnName) {
        if (strpos($columnName, 'marketing_') === 0) {
            unset($mailsTca['columns'][$columnName]);
        }
    }
}

return $mailsTca;
