<?php

namespace dnsomatic\Exception;

class BadAuth extends \Exception {
    protected $message = 'The DNS-O-Matic username or password specified are incorrect.';
}
