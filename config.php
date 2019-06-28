<?php
$protocol = (isset($_SERVER['HTTPS'])) ? 'https' : 'http';
$url = "{$protocol}://{$_SERVER['HTTP_HOST']}";
$url .= str_replace(array('simple-conference.php', basename(__FILE__)), '', $_SERVER['PHP_SELF']);


return [
    'accountSid' => 'AC838d68b98c8022ff6e1ffa4999dbcfa0',
    'authToken' => '0ea366c2e4dc51e81d96c53bb8a4056a',
    'appSid' => 'AP584f9517a301983966f88ea7dd8a474b',
    'numbers' => [
            'GB' => '+16829706764',
    ],
    'sounds' => [
            'wait' => [ 'local' => 'sounds/wait.wav', 'remote' => "{$url}/sounds/wait.wav" ],
            'joining' => [ 'local' => 'sounds/joining-dont-play.wav', 'remote' => "{$url}/sounds/joining-dont-play.wav" ],
            'welcome' => [ 'local' => 'sounds/professional/welcome-mciof.wav', 'remote' => "{$url}/sounds/professional/welcome-mciof.wav" ],
            'enterPin' => [ 'local' => 'sounds/professional/enter-pin.wav', 'remote' => "{$url}/sounds/professional/enter-pin.wav" ],
            'invalidPin' => [ 'local' => 'sounds/professional/invalid-pin.wav', 'remote' => "{$url}/sounds/professional/invalid-pin.wav" ],
    ]
];
