<?php

require_once __DIR__ . '/../vendor/autoload.php';

use dnsomatic\Factory;

// DNS-O-Matic Username
define('DNSOMATIC_USER', '');
// DNS-O-Matic Password
define('DNSOMATIC_PASS', '');
// DNS-O-Matic Hostname
define('DNSOMATIC_HOST', '');
// Output messages to stdout
define('VERBOSE', true);
// IP Address local cache
define('IP_CACHE', __DIR__ . '/ip.cache');
// Log file
define('LOG_FILE', __DIR__ . '/dnsomatic.log');


try {
    if (VERBOSE) {
        echo 'Starting..', PHP_EOL;
    }

    $checker = Factory::createChecker();
    // Resolves current IP Address
    $ipAddr = $checker->exec();
    if (VERBOSE) {
        echo 'Resolved IP Address: ', $ipAddr, PHP_EOL;
    }

    // Retrieves last IP Address from local cache
    $cached = '';
    if (is_file(IP_CACHE)) {
        $cached = trim(file_get_contents(IP_CACHE));
        if (VERBOSE) {
            echo 'Cached IP Address: ', $cached, PHP_EOL;
        }
    }

    // If resolved IP Address and cached IP Address don't match
    if ($ipAddr !== $cached) {
        if (VERBOSE) {
            echo 'Updating DNS-O-Matic..', PHP_EOL;
        }

        // Update DNS-O-Matic with current IP Address
        $updater = Factory::createUpdater(DNSOMATIC_USER, DNSOMATIC_PASS);
        $updater
            ->setHostname(DNSOMATIC_HOST)
            ->setMyip($ipAddr);
        $updater->exec();

        // Stores current IP Address in local cache
        file_put_contents(IP_CACHE, $ipAddr, LOCK_EX);
    }
} catch (\Exception $exception) {
    // Exceptions are sent to the log file
    $logLine = sprintf(
        '[%s] %s (%s:%d)',
        date('d/m/Y H:i:s'),
        $exception->getMessage(),
        $exception->getFile(),
        $exception->getLine()
    );
    if (VERBOSE) {
        echo $logLine, PHP_EOL;
    }

    file_put_contents(
        LOG_FILE,
        $logLine . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
} finally {
    if (VERBOSE) {
        echo 'Done', PHP_EOL;
    }
}
