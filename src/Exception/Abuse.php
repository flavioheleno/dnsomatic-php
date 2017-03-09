<?php

namespace dnsomatic\Exception;

class Abuse extends \Exception {
    protected $message = 'The hostname is blocked for update abuse.';
}
