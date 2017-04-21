<?php
namespace WhatsappBundle\Libaxolotl;
use \Exception;
class NoSessionException extends Exception
{
    public function NoSessionException($s) // [String s]
    {
        $this->message = $s;
    }
}
