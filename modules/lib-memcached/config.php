<?php

return [
    '__name' => 'lib-memcached',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getmim/lib-memcached.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'http://iqbalfn.com/'
    ],
    '__files' => [
        'modules/lib-memcached' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [],
        'optional' => []
    ],
    '__inject' => [
        [
            'name' => 'libMemcached',
            'question' => 'lib-memcached app config',
            'children' => [
                [
                    'name' => [
                        'question' => 'New memcached connection name',
                        'rule'     => 'any'
                    ],
                    'children' => [
                        [
                            'name' => 'host',
                            'question' => 'Connection hostname',
                            'default' => '127.0.0.1',
                            'rule' => 'any'
                        ],
                        [
                            'name' => 'port',
                            'question' => 'Connection port number',
                            'default' => '11211',
                            'rule' => 'any'
                        ]
                    ]
                ]
            ]
        ]
    ],
    'autoload' => [
        'classes' => [
            'LibMemcached\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-memcached/library'
            ],
            'LibMemcached\\Server' => [
                'type' => 'file',
                'base' => 'modules/lib-memcached/server'
            ]
        ]
    ],
    'server' => [
        'lib-memcached' => [
            'Memcached' => 'LibMemcached\\Server\\PHP::memcached'
        ]
    ]
];