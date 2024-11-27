<?php
return [
    'pools' => [
        'sha256' => [
            'primary' => [
                'host' => 'mining-dutch.nl',
                'port' => 3333,
                'user' => 'Alexandru83.worker1',
                'pass' => 'x',
                'backup' => false
            ]
        ],
        'ethash' => [
            'primary' => [
                'host' => 'mining-dutch.nl',
                'port' => 4444,
                'user' => 'Alexandru83.worker2',
                'pass' => 'x',
                'backup' => false
            ]
        ],
        'scrypt' => [
            'primary' => [
                'host' => 'mining-dutch.nl',
                'port' => 5555,
                'user' => 'Alexandru83.worker3',
                'pass' => 'x',
                'backup' => false
            ]
        ],
        'randomx' => [
            'primary' => [
                'host' => 'mining-dutch.nl',
                'port' => 6666,
                'user' => 'Alexandru83.worker4',
                'pass' => 'x',
                'backup' => false
            ]
        ]
    ],
    'proxy' => [
        'listen' => [
            'sha256' => '0.0.0.0:13333',
            'ethash' => '0.0.0.0:14444',
            'scrypt' => '0.0.0.0:15555',
            'randomx' => '0.0.0.0:16666'
        ],
        'ssl' => false,
        'redirect_all' => true,
        'hide_worker_id' => true
    ]
];
