<?php

return [
    // Mapa de capacidades por provedor (exibido no Admin)
    'capabilities' => [
        'ondapay'    => ['pix' => true,  'usdt_trc20' => true],
        'paghiper'   => ['pix' => true,  'usdt_trc20' => false],
        'gestaopay'  => ['pix' => true,  'usdt_trc20' => false],
        'bspay'      => ['pix' => true,  'usdt_trc20' => false],
        'coinbase'   => ['pix' => false, 'usdt_trc20' => true], // apenas USDT
        'versellpay' => ['pix' => true,  'usdt_trc20' => true],
    ],
];
