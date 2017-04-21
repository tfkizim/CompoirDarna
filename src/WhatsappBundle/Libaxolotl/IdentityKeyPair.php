<?php
namespace WhatsappBundle\Libaxolotl;
use \Exception;
use WhatsappBundle\Libaxolotl\State\Textsecure_SessionStructure_Chain_ChainKey;
use WhatsappBundle\Libaxolotl\State\Textsecure_SessionStructure_Chain_MessageKey;
use WhatsappBundle\Libaxolotl\State\Textsecure_SessionStructure_Chain;
use WhatsappBundle\Libaxolotl\State\Textsecure_SessionStructure_PendingKeyExchange;
use WhatsappBundle\Libaxolotl\State\Textsecure_SessionStructure_PendingPreKey;
use WhatsappBundle\Libaxolotl\State\Textsecure_SessionStructure;
use WhatsappBundle\Libaxolotl\State\Textsecure_RecordStructure;
use WhatsappBundle\Libaxolotl\State\Textsecure_PreKeyRecordStructure;
use WhatsappBundle\Libaxolotl\State\Textsecure_SignedPreKeyRecordStructure;
use WhatsappBundle\Libaxolotl\State\Textsecure_IdentityKeyPairStructure;
use WhatsappBundle\Libaxolotl\State\Textsecure_SenderKeyStateStructure_SenderChainKey;
use WhatsappBundle\Libaxolotl\State\Textsecure_SenderKeyStateStructure_SenderMessageKey;
use WhatsappBundle\Libaxolotl\State\Textsecure_SenderKeyStateStructure_SenderSigningKey;
use WhatsappBundle\Libaxolotl\State\Textsecure_SenderKeyStateStructure;
use WhatsappBundle\Libaxolotl\State\Textsecure_SenderKeyRecordStructure;
use WhatsappBundle\Libaxolotl\IdentityKey;
class IdentityKeyPair
{
    protected $publicKey;    // IdentityKey
    protected $privateKey;    // ECPrivateKey

    public function IdentityKeyPair($publicKey = null, $privateKey = null, $serialized = null) // [IdentityKey publicKey, ECPrivateKey privateKey]
    {
        if ($serialized == null) {
            $this->publicKey = $publicKey;
            $this->privateKey = $privateKey;
        } else {
            $structure = new Textsecure_IdentityKeyPairStructure();
            $structure->parseFromString($serialized);
            $this->publicKey = new IdentityKey($structure->getPublicKey(), 0);
            $this->privateKey = Curve::decodePrivatePoint($structure->getPrivateKey());
        }
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    public function serialize()
    {
        $struct = new Textsecure_IdentityKeyPairStructure();

        return $struct->setPublicKey((string) $this->publicKey->serialize())->setPrivateKey((string) $this->privateKey->serialize())->serializeToString();
    }
}
