<?php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Flight::route('GET /', function(){
    $appTitle = $_ENV['PRINT_TITLE'] ?? 'Replication COUNTER';
    $lpPath = $_ENV['PRINTER_PATH'] ?? '/dev/usb/lp1';
    $model = $_ENV['PRINTER_MODEL'] ?? 'CT-S651';

    $cookie = new \Overclokk\Cookie\Cookie( $_COOKIE );
    $prefix = $cookie->get('prefix');
    $counter = (int)$cookie->get('counter');

    Flight::render('form', [
        'prefix' => isset($prefix) ? $prefix: $_ENV['COUNTER_PREFIX'] ?? '',
        'counter' => isset($counter) ? $counter: '1',
    ], 'formContent');

    Flight::render('status', [
        'request' => null,
        'lpPath' => $lpPath,
        'model' => $model,
    ], 'statusContent');

    Flight::render('print', [
        'request' => [
            'inputValue' => sprintf("%s\n and \n  %s",
                sprintf("first printed to %s(%s)", $model, $lpPath),
                "Use values for next print."
            )
        ],
        'title' => $appTitle,
        'prefix' => $prefix,
        'counter' => $counter,
        'timezone' => $_ENV['TIMEZONE'] ?? 'UTC',
        'lpPath' => $lpPath,
        'model' => $model,
    ], 'printContent');

    Flight::render('index', [
        'title' => $appTitle,
    ]);
});

Flight::route('POST /', function(){
    $appTitle = $_ENV['PRINT_TITLE'] ?? 'Replication COUNTER';
    $lpPath = $_ENV['PRINTER_PATH'] ?? '/dev/usb/lp1';
    $model = $_ENV['PRINTER_MODEL'] ?? 'CT-S651';

    if(isset(Flight::request()->data['counter']) && Flight::request()->data['counter'] != 0) {
        $counter = (int)(Flight::request()->data['counter']) + 1;
    } else {
        $counter = 0;
    }

    $cookie = new \Overclokk\Cookie\Cookie( $_COOKIE );
    $cookie->set('prefix', Flight::request()->data['prefix'], 3600 * 2);
    $cookie->set('counter', $counter, 3600 * 2);

    Flight::render('form', [
        'prefix' => Flight::request()->data['prefix'] ?? $_ENV['PREFIX'] ?? '',
        'counter' => $counter, 'formContent'
    ], 'formContent');

    Flight::render('status', [
        'request' => Flight::request()->data,
        'lpPath' => $lpPath,
        'model' => $_ENV['PRINTER_MODEL'] ?? 'CT-S651',
    ], 'statusContent');

    Flight::render('print', [
        'request' => Flight::request()->data,
        'title' => $appTitle,
        'timezone' => $_ENV['TIMEZONE'] ?? 'UTC',
        'lpPath' => $lpPath,
        'model' => $model,
    ], 'printContent');

    Flight::render('index', [
        'title' => $appTitle,
    ]);
});

Flight::start();
