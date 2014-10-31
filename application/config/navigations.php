<?php defined('BASEPATH') or exit('No direct script access allowed');

$config['navigations'] = array(
	array(
		'name' => 'logo',
		'label' => 'Pinet',
		'logo' => 'logo.png',
		'controller' => 'Welcome'
	),
    array(
        'name' => 'user_account_settings',
        'label' => 'User and Account Settings',
        'logo' => 'user_account_settings.png',
        'controller' => 'Account',
        'method' => 'index',
        'subnavi' => array(
            array(
                'name' => 'account_summary',
                'label' => 'Account Summary',
                'controller' => 'Account',
                'method' => 'summary_details'
            ),
            array(
                'name' => 'change_password',
                'label' => 'Change Password',
                'controller' => 'Account',
                'method' => 'change_password'
            ),
            array(
                'name' => 'reset_password',
                'label' => 'Reset Password',
                'controller' => 'Account',
                'method' => 'reset_password'
            )
        )
    )
);
