<?php
namespace WhatsappBundle\Libaxolotl\Ecc;
interface ECPrivateKey
{
    public function serialize();

    public function getType();
}
