<?php

namespace dnsomatic;

use \GuzzleHttp\Client;

/*
 * Convenience Factory class to create new instances of \dnsomatic\Updater and \dnsomatic\Checker classes.
 */
class Factory {
    /**
     * Creates a new instance of \dnsomatic\Updater class, injecting all required dependencies.
     *
     * @param string $username
     * @param string $password
     *
     * @return \dnsomatic\Updater
     */
    public static function createUpdater(string $username, string $password) : Updater {
        return new Updater(new Client(), $username, $password);
    }

    /**
     * Creates a new instance of \dnsomatic\Checker class, injecting all required dependencies.
     *
     * @return \dnsomatic\Checker
     */
    public static function createChecker() : Checker {
        return new Checker(new Client());
    }
}
