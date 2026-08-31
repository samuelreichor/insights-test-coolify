<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

return [
    '*' => [
        'aliases' => [
            '@webroot' => getenv('CRAFT_WEB_ROOT'),
        ],
        'allowAdminChanges' => false,
        'allowedFileExtensions' => ['jpg', 'png', 'jpeg', 'webP', 'gif', 'svg', 'mp4', 'pdf', 'zip', 'csv'],
        'allowUpdates' => false,
        'cacheDuration' => false,
        'defaultTokenDuration' => 'P2W',
        'defaultSearchTermOptions' => [
            'subLeft' => true,
            'subRight' => true,
        ],
        'devMode' => true,
        'disallowRobots' => true,
        'generateTransformsBeforePageLoad' => true,
        'limitAutoSlugsToAscii' => true,
        'maxRevisions' => 5,
        'omitScriptNameInUrls' => true,
        'runQueueAutomatically' => false,
        'securityKey' => getenv('CRAFT_SECURITY_KEY'),
    ],

    'production' => [
        'disallowRobots' => false,
        'devMode' => false,
    ],

    'dev' => [
        'devMode' => true,
        'allowAdminChanges' => true,
        'allowUpdates' => true,
        'enableTemplateCaching' => false,
        'testToEmailAddress' => getenv('TEST_EMAIL_ADDRESS') ?: null,
        'rememberedUserSessionDuration' => 'P1Y',
        'runQueueAutomatically' => true,
    ],
];
