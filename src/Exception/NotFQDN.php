<?php

namespace dnsomatic\Exception;

class NotFQDN extends \Exception {
    protected $message = 'The hostname specified is not a fully-qualified domain name.';
}
