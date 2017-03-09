<?php

namespace dnsomatic\Exception;

class UnknownResponse extends \Exception {
    protected $message = 'The request response is unknown.';
}
