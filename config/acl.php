<?php

return array(
    'wrong_password_count' => 10,
    'password_cost'        => '12',
    'login_attempts'       => 10,
    'rememberable'         => array(
        'key' => '__acl_remember_me_token__',
        'ttl' => 1209600,
    ),
    'access'               => array(
        'cache_time' => 604800
    ),
);
