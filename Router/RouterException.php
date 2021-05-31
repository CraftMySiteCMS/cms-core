<?php

namespace CMS\Router;

class RouterException extends \Exception {

    protected $message = 'Unknown exception';     // Exception message
    protected $code    = 500;                     // User-defined exception code

    public function __construct($message = null, $code = 500) {
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }
        parent::__construct($message, $code);
    }
}