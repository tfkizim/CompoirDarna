<?php
namespace WhatsappBundle\Libaxolotl\Ecc;
interface ECPublicKey
{
    public function serialize();

    public function getType();
}
