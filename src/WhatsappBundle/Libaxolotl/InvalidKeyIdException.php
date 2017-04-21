<?php
namespace WhatsappBundle\Libaxolotl;
use \Exception;
class InvalidKeyIdException extends Exception
{
    public function InvalidKeyIdException($detailMessage) // [String detailMessage]
    {
        $this->message = $detailMessage;
    }
}
