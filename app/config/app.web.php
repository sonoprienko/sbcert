<?php
return [
    'routes' => [
        '/' => [
            'controller' => 'SBCert\Controller\IndexController',
            'action' => 'index',
        ],
        '/admin' => [
            'controller' => 'SBCert\Controller\AdminController',
            'action' => 'admin',
        ],
        '/register/' => [
            'controller' => 'SBCert\Controller\RegisterController',
            'action' => 'register',
        ],
        '*' => [
            'controller' => 'SBCert\Controller\IndexController',
            'action' => 'error',
        ],
    ],
    'services' => [
        'database' => [
            'call' => 'Pop\Db\Db::connect',
            'params' => [
                'adapter' => 'MySQL',
                'options' => [
                    'database' => 'sbcert_db',
                    'username' => 'sbcert_user',
                    'password' => 'yw7ol!mn@4',
                    'host' => 'localhost',
                ],
            ],
        ],
    ],
];