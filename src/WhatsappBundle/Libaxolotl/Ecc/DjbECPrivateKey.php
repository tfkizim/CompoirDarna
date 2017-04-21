<?php
namespace WhatsappBundle\Libaxolotl\Ecc;
use WhatsappBundle\Libaxolotl\Ecc\ECPrivateKey;
class DjbECPrivateKey implements ECPrivateKey
{
    protected $privateKey;    // byte[] --> php string now

    public function DjbECPrivateKey($privateKey) // [byte[] privateKey]
    {
        $this->privateKey = $privateKey;
    }

    public function serialize()
    {
        return $this->privateKey;
    }

    public function getType()
    {
        return Curve::DJB_TYPE;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }
}
