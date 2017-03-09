<?php

namespace dnsomatic\Exception;

class IgnoredRequest extends \Exception {
    protected $message = 'The request was ignored because the agent that does not follow specifications.';
}
