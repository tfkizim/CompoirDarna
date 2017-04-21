<?php
namespace WhatsappBundle\Libaxolotl\Groups\State;
use  WhatsappBundle\Libaxolotl\Groups\State\SenderKeyState;
use  WhatsappBundle\Libaxolotl\InvalidKeyIdException;

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
class SenderKeyRecord
{
    protected $senderKeyStates;

    public function SenderKeyRecord($serialized = null)
    {
        $this->senderKeyStates = [];

        if ($serialized != null) {
            $senderKeyRecordStructure = new TextSecure_SenderKeyRecordStructure();

            $senderKeyRecordStructure->parseFromString($serialized);

            foreach ($senderKeyRecordStructure->getSenderKeyStates() as $structure) {
                $this->senderKeyStates[] = new SenderKeyState(null, null, null, null, null, null, $structure);
            }
        }
    }

    public function getSenderKeyState($keyId = null)
    {
        if (is_null($keyId)) {
            if (count($this->senderKeyStates) > 0) {
                return $this->senderKeyStates[0];
            } else {
                throw new InvalidKeyIdException('No key state in record');
            }
        } else {
            foreach ($this->senderKeyStates as $state) {
                if ($state->getKeyId() == $keyId) {
                    return $state;
                }
            }
            throw new InvalidKeyIdException("No keys for: $keyId");
        }
    }

    public function addSenderKeyState($id, $iteration, $chainKey, $signatureKey)
    {
        $this->senderKeyStates[] = new SenderKeyState($id, $iteration, $chainKey, $signatureKey);
    }

    public function setSenderKeyState($id, $iteration, $chainKey, $signatureKey)
    {
        unset($this->senderKeyStates);
        $this->senderKeyStates = [];
        $this->senderKeyStates[] = new SenderKeyState($id, $iteration, $chainKey, null, null, $signatureKey);
    }

    public function serialize()
    {
        $recordStructure = new TextSecure_SenderKeyRecordStructure();

        foreach ($this->senderKeyStates as $senderKeyState) {
            $recordStructure->appendSenderKeyStates($senderKeyState->getStructure());
        }

        return $recordStructure->serializeToString();
    }
}
