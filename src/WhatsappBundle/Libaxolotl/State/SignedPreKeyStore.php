<?php
namespace WhatsappBundle\Libaxolotl\State;
use WhatsappBundle\Libaxolotl\InvalidKeyException;
abstract class SignedPreKeyStore
{
    abstract public function loadSignedPreKey($signedPreKeyId);

 // [int signedPreKeyId]

    abstract public function loadSignedPreKeys();

    abstract public function storeSignedPreKey($signedPreKeyId, $record);

 // [int signedPreKeyId, SignedPreKeyRecord record]

    abstract public function containsSignedPreKey($signedPreKeyId);

 // [int signedPreKeyId]

    abstract public function removeSignedPreKey($signedPreKeyId);

 // [int signedPreKeyId]
}
