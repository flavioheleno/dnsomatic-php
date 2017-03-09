<?php

namespace dnsomatic\Exception;

class InvalidIPAddress extends \Exception {
    protected $message = 'The resolved IP Address is invalid.';
}
