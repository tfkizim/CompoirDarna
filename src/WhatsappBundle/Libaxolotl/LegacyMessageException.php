<?php
namespace WhatsappBundle\Libaxolotl;
use \Exception;
class LegacyMessageException extends Exception
{
    public function LegacyMessageException($detailMesssage) // [String s]
    {
        $this->message = $detailMesssage;
    }
}
