<?php

namespace dnsomatic\Exception;

class InvalidResponse extends \Exception {
    protected $message = 'There is a problem with DNS-O-Matic response format.';
}
