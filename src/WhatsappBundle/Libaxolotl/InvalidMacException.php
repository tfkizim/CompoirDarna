<?php
namespace WhatsappBundle\Libaxolotl;
use \Exception;
class InvalidMacException extends Exception
{
    public function InvalidMacException($detailMessage) // [String detailMessage]
    {
        $this->message = $detailMessage;
    }
}
