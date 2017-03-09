<?php

namespace dnsomatic\Exception;

class BadAgent extends \Exception {
    protected $message = 'The user-agent is blocked.';
}
