<?php
namespace WhatsappBundle\Libaxolotl\State;
class Textsecure_SessionStructure extends \ProtobufMessage
{
    /* Field index constants */
    const SESSIONVERSION = 1;
    const LOCALIDENTITYPUBLIC = 2;
    const REMOTEIDENTITYPUBLIC = 3;
    const ROOTKEY = 4;
    const PREVIOUSCOUNTER = 5;
    const SENDERCHAIN = 6;
    const RECEIVERCHAINS = 7;
    const PENDINGKEYEXCHANGE = 8;
    const PENDINGPREKEY = 9;
    const REMOTEREGISTRATIONID = 10;
    const LOCALREGISTRATIONID = 11;
    const NEEDSREFRESH = 12;
    const ALICEBASEKEY = 13;

    /* @var array Field descriptors */
    protected static $fields = [
        self::SESSIONVERSION => [
            'name'     => 'sessionVersion',
            'required' => false,
            'type'     => 5,
        ],
        self::LOCALIDENTITYPUBLIC => [
            'name'     => 'localIdentityPublic',
            'required' => false,
            'type'     => 7,
        ],
        self::REMOTEIDENTITYPUBLIC => [
            'name'     => 'remoteIdentityPublic',
            'required' => false,
            'type'     => 7,
        ],
        self::ROOTKEY => [
            'name'     => 'rootKey',
            'required' => false,
            'type'     => 7,
        ],
        self::PREVIOUSCOUNTER => [
            'name'     => 'previousCounter',
            'required' => false,
            'type'     => 5,
        ],
        self::SENDERCHAIN => [
            'name'     => 'senderChain',
            'required' => false,
            'type'     => 'Textsecure_SessionStructure_Chain',
        ],
        self::RECEIVERCHAINS => [
            'name'     => 'receiverChains',
            'repeated' => true,
            'type'     => 'Textsecure_SessionStructure_Chain',
        ],
        self::PENDINGKEYEXCHANGE => [
            'name'     => 'pendingKeyExchange',
            'required' => false,
            'type'     => 'Textsecure_SessionStructure_PendingKeyExchange',
        ],
        self::PENDINGPREKEY => [
            'name'     => 'pendingPreKey',
            'required' => false,
            'type'     => 'Textsecure_SessionStructure_PendingPreKey',
        ],
        self::REMOTEREGISTRATIONID => [
            'name'     => 'remoteRegistrationId',
            'required' => false,
            'type'     => 5,
        ],
        self::LOCALREGISTRATIONID => [
            'name'     => 'localRegistrationId',
            'required' => false,
            'type'     => 5,
        ],
        self::NEEDSREFRESH => [
            'name'     => 'needsRefresh',
            'required' => false,
            'type'     => 8,
        ],
        self::ALICEBASEKEY => [
            'name'     => 'aliceBaseKey',
            'required' => false,
            'type'     => 7,
        ],
    ];

    /**
     * Constructs new message container and clears its internal state.
     *
     * @return null
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones.
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::SESSIONVERSION] = null;
        $this->values[self::LOCALIDENTITYPUBLIC] = null;
        $this->values[self::REMOTEIDENTITYPUBLIC] = null;
        $this->values[self::ROOTKEY] = null;
        $this->values[self::PREVIOUSCOUNTER] = null;
        $this->values[self::SENDERCHAIN] = null;
        $this->values[self::RECEIVERCHAINS] = [];
        $this->values[self::PENDINGKEYEXCHANGE] = null;
        $this->values[self::PENDINGPREKEY] = null;
        $this->values[self::REMOTEREGISTRATIONID] = null;
        $this->values[self::LOCALREGISTRATIONID] = null;
        $this->values[self::NEEDSREFRESH] = null;
        $this->values[self::ALICEBASEKEY] = null;
    }

    /**
     * Returns field descriptors.
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'sessionVersion' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setSessionVersion($value)
    {
        return $this->set(self::SESSIONVERSION, $value);
    }

    /**
     * Returns value of 'sessionVersion' property.
     *
     * @return int
     */
    public function getSessionVersion()
    {
        return $this->get(self::SESSIONVERSION);
    }

    /**
     * Sets value of 'localIdentityPublic' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setLocalIdentityPublic($value)
    {
        return $this->set(self::LOCALIDENTITYPUBLIC, $value);
    }

    /**
     * Returns value of 'localIdentityPublic' property.
     *
     * @return string
     */
    public function getLocalIdentityPublic()
    {
        return $this->get(self::LOCALIDENTITYPUBLIC);
    }

    /**
     * Sets value of 'remoteIdentityPublic' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRemoteIdentityPublic($value)
    {
        return $this->set(self::REMOTEIDENTITYPUBLIC, $value);
    }

    /**
     * Returns value of 'remoteIdentityPublic' property.
     *
     * @return string
     */
    public function getRemoteIdentityPublic()
    {
        return $this->get(self::REMOTEIDENTITYPUBLIC);
    }

    /**
     * Sets value of 'rootKey' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setRootKey($value)
    {
        return $this->set(self::ROOTKEY, $value);
    }

    /**
     * Returns value of 'rootKey' property.
     *
     * @return string
     */
    public function getRootKey()
    {
        return $this->get(self::ROOTKEY);
    }

    /**
     * Sets value of 'previousCounter' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setPreviousCounter($value)
    {
        return $this->set(self::PREVIOUSCOUNTER, $value);
    }

    /**
     * Returns value of 'previousCounter' property.
     *
     * @return int
     */
    public function getPreviousCounter()
    {
        return $this->get(self::PREVIOUSCOUNTER);
    }

    /**
     * Sets value of 'senderChain' property.
     *
     * @param Textsecure_SessionStructure_Chain $value Property value
     *
     * @return null
     */
    public function setSenderChain(Textsecure_SessionStructure_Chain $value)
    {
        return $this->set(self::SENDERCHAIN, $value);
    }

    /**
     * Returns value of 'senderChain' property.
     *
     * @return Textsecure_SessionStructure_Chain
     */
    public function getSenderChain()
    {
        return $this->get(self::SENDERCHAIN);
    }

    /**
     * Appends value to 'receiverChains' list.
     *
     * @param Textsecure_SessionStructure_Chain $value Value to append
     *
     * @return null
     */
    public function appendReceiverChains(Textsecure_SessionStructure_Chain $value)
    {
        return $this->append(self::RECEIVERCHAINS, $value);
    }

    /**
     * Clears 'receiverChains' list.
     *
     * @return null
     */
    public function clearReceiverChains()
    {
        return $this->clear(self::RECEIVERCHAINS);
    }

    /**
     * Returns 'receiverChains' list.
     *
     * @return Textsecure_SessionStructure_Chain[]
     */
    public function getReceiverChains()
    {
        return $this->get(self::RECEIVERCHAINS);
    }

    /**
     * Returns 'receiverChains' iterator.
     *
     * @return ArrayIterator
     */
    public function getReceiverChainsIterator()
    {
        return new \ArrayIterator($this->get(self::RECEIVERCHAINS));
    }

    /**
     * Returns element from 'receiverChains' list at given offset.
     *
     * @param int $offset Position in list
     *
     * @return Textsecure_SessionStructure_Chain
     */
    public function getReceiverChainsAt($offset)
    {
        return $this->get(self::RECEIVERCHAINS, $offset);
    }

    /**
     * Returns count of 'receiverChains' list.
     *
     * @return int
     */
    public function getReceiverChainsCount()
    {
        return $this->count(self::RECEIVERCHAINS);
    }

    /**
     * Sets value of 'pendingKeyExchange' property.
     *
     * @param Textsecure_SessionStructure_PendingKeyExchange $value Property value
     *
     * @return null
     */
    public function setPendingKeyExchange(Textsecure_SessionStructure_PendingKeyExchange $value)
    {
        return $this->set(self::PENDINGKEYEXCHANGE, $value);
    }

    /**
     * Returns value of 'pendingKeyExchange' property.
     *
     * @return Textsecure_SessionStructure_PendingKeyExchange
     */
    public function getPendingKeyExchange()
    {
        return $this->get(self::PENDINGKEYEXCHANGE);
    }

    /**
     * Sets value of 'pendingPreKey' property.
     *
     * @param Textsecure_SessionStructure_PendingPreKey $value Property value
     *
     * @return null
     */
    public function setPendingPreKey(Textsecure_SessionStructure_PendingPreKey $value)
    {
        return $this->set(self::PENDINGPREKEY, $value);
    }

    /**
     * Returns value of 'pendingPreKey' property.
     *
     * @return Textsecure_SessionStructure_PendingPreKey
     */
    public function getPendingPreKey()
    {
        return $this->get(self::PENDINGPREKEY);
    }

    public function clearPendingPreKey()
    {
        $this->values[self::PENDINGPREKEY] = null;
    }

    /**
     * Sets value of 'remoteRegistrationId' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setRemoteRegistrationId($value)
    {
        return $this->set(self::REMOTEREGISTRATIONID, $value);
    }

    /**
     * Returns value of 'remoteRegistrationId' property.
     *
     * @return int
     */
    public function getRemoteRegistrationId()
    {
        return $this->get(self::REMOTEREGISTRATIONID);
    }

    /**
     * Sets value of 'localRegistrationId' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setLocalRegistrationId($value)
    {
        return $this->set(self::LOCALREGISTRATIONID, $value);
    }

    /**
     * Returns value of 'localRegistrationId' property.
     *
     * @return int
     */
    public function getLocalRegistrationId()
    {
        return $this->get(self::LOCALREGISTRATIONID);
    }

    /**
     * Sets value of 'needsRefresh' property.
     *
     * @param bool $value Property value
     *
     * @return null
     */
    public function setNeedsRefresh($value)
    {
        return $this->set(self::NEEDSREFRESH, $value);
    }

    /**
     * Returns value of 'needsRefresh' property.
     *
     * @return bool
     */
    public function getNeedsRefresh()
    {
        return $this->get(self::NEEDSREFRESH);
    }

    /**
     * Sets value of 'aliceBaseKey' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setAliceBaseKey($value)
    {
        return $this->set(self::ALICEBASEKEY, $value);
    }

    /**
     * Returns value of 'aliceBaseKey' property.
     *
     * @return string
     */
    public function getAliceBaseKey()
    {
        return $this->get(self::ALICEBASEKEY);
    }
}