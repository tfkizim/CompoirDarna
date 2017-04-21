<?php
namespace WhatsappBundle\Libaxolotl\Kdf;
use WhatsappBundle\Libaxolotl\Kdf\HKDF;

class HKDFv3 extends HKDF
{
    protected function getIterationStartOffset()
    {
        return 1;
    }
}
