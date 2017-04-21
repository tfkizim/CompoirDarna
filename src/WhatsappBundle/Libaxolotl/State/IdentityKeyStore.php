<?php
namespace WhatsappBundle\Libaxolotl\State;
use WhatsappBundle\Libaxolotl\IdentityKey;
use WhatsappBundle\Libaxolotl\IdentityKeyPair;
abstract class IdentityKeyStore
{
    abstract public function getIdentityKeyPair();

    abstract public function getLocalRegistrationId();

    abstract public function saveIdentity($recipientId, $identityKey);

 // [long recipientId, IdentityKey identityKey]

    abstract public function isTrustedIdentity($recipientId, $identityKey);

 // [long recipientId, IdentityKey identityKey]
}
