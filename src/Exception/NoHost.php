<?php

namespace dnsomatic\Exception;

class NoHost extends \Exception {
    protected $message = 'The hostname passed could not be matched to any services configured.';
}
