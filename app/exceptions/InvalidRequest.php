<?php
class InvalidRequest extends Exception {
    public function __construct($message, $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __construct() {
        parent::__construct("message", $code, $previous);
    }
    
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
    public function customFunction() {
        echo "Função personalizada para esta exceção\n";
    }
}
?>