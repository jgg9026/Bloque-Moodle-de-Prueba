<?php
    $capabilities = array(
 
    'block/simplehtml:myaddinstance' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'user' => CAP_PROHIBIT

        ),
 
        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ),
 
    'block/simplehtml:addinstance' => array(
        'riskbitmask' => RISK_SPAM | RISK_XSS,
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW,
            'guest' => CAP_ALLOW
        ),
 
        'clonepermissionsfrom' => 'moodle/course:manageblocks'
    ),
    
);