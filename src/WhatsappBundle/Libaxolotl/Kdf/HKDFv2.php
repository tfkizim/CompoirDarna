<?php
namespace WhatsappBundle\Libaxolotl\Kdf;
use WhatsappBundle\Libaxolotl\Kdf\HKDF;
class HKDFv2 extends HKDF
{
    protected function getIterationStartOffset()
    {
        return 0;
    }
}
