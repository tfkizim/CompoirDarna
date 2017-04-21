<?php
namespace WhatsappBundle\Libaxolotl\State;
use WhatsappBundle\Libaxolotl\InvalidKeyException;
use WhatsappBundle\Libaxolotl\Ecc\Curve;
use WhatsappBundle\Libaxolotl\Ecc\ECKeyPair;
use WhatsappBundle\Libaxolotl\Ecc\ECPrivateKey;
use WhatsappBundle\Libaxolotl\Ecc\ECPublicKey;
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
class PreKeyRecord
{
    protected $structure;    // PreKeyRecordStructure

    public function PreKeyRecord($id = null, $keyPair = null, $serialized = null) // [int id, ECKeyPair keyPair]
    {
        $this->structure = new Textsecure_PreKeyRecordStructure();
        if ($serialized == null) {
            $this->structure->setId($id)->setPublicKey((string) $keyPair->getPublicKey()->serialize())->setPrivateKey((string) $keyPair->getPrivateKey()->serialize());
        } else {
            try {
                $this->structure->parseFromString($serialized);
            } catch (Exception $ex) {
                throw new Exception('Cannot unserialize PreKEyRecordStructure');
            }
        }
    }

    public function getId()
    {
        return $this->structure->getId();
    }

    public function getKeyPair()
    {
        $publicKey = Curve::decodePoint($this->structure->getPublicKey(), 0);
        $privateKey = Curve::decodePrivatePoint($this->structure->getPrivateKey());

        return new ECKeyPair($publicKey, $privateKey);
    }

    public function serialize()
    {
        return $this->structure->serializeToString();
    }
}
