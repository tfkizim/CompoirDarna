<?php
namespace WhatsappBundle\Libaxolotl\State;
class Textsecure_SessionStructure_Chain extends \ProtobufMessage
{
    /* Field index constants */
    const SENDERRATCHETKEY = 1;
    const SENDERRATCHETKEYPRIVATE = 2;
    const CHAINKEY = 3;
    const MESSAGEKEYS = 4;

    /* @var array Field descriptors */
    protected static $fields = [
        self::SENDERRATCHETKEY => [
            'name'     => 'senderRatchetKey',
            'required' => false,
            'type'     => 7,
        ],
        self::SENDERRATCHETKEYPRIVATE => [
            'name'     => 'senderRatchetKeyPrivate',
            'required' => false,
            'type'     => 7,
        ],
        self::CHAINKEY => [
            'name'     => 'chainKey',
            'required' => false,
            'type'     => 'Textsecure_SessionStructure_Chain_ChainKey',
        ],
        self::MESSAGEKEYS => [
            'name'     => 'messageKeys',
            'repeated' => true,
            'type'     => 'Textsecure_SessionStructure_Chain_MessageKey',
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
        $this->values[self::SENDERRATCHETKEY] = null;
        $this->values[self::SENDERRATCHETKEYPRIVATE] = null;
        $this->values[self::CHAINKEY] = null;
        $this->values[self::MESSAGEKEYS] = [];
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
     * Sets value of 'senderRatchetKey' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSenderRatchetKey($value)
    {
        return $this->set(self::SENDERRATCHETKEY, $value);
    }

    /**
     * Returns value of 'senderRatchetKey' property.
     *
     * @return string
     */
    public function getSenderRatchetKey()
    {
        return $this->get(self::SENDERRATCHETKEY);
    }

    /**
     * Sets value of 'senderRatchetKeyPrivate' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSenderRatchetKeyPrivate($value)
    {
        return $this->set(self::SENDERRATCHETKEYPRIVATE, $value);
    }

    /**
     * Returns value of 'senderRatchetKeyPrivate' property.
     *
     * @return string
     */
    public function getSenderRatchetKeyPrivate()
    {
        return $this->get(self::SENDERRATCHETKEYPRIVATE);
    }

    /**
     * Sets value of 'chainKey' property.
     *
     * @param Textsecure_SessionStructure_Chain_ChainKey $value Property value
     *
     * @return null
     */
    public function setChainKey(Textsecure_SessionStructure_Chain_ChainKey $value)
    {
        return $this->set(self::CHAINKEY, $value);
    }

    /**
     * Returns value of 'chainKey' property.
     *
     * @return Textsecure_SessionStructure_Chain_ChainKey
     */
    public function getChainKey()
    {
        return $this->get(self::CHAINKEY);
    }

    /**
     * Appends value to 'messageKeys' list.
     *
     * @param Textsecure_SessionStructure_Chain_MessageKey $value Value to append
     *
     * @return null
     */
    public function appendMessageKeys(Textsecure_SessionStructure_Chain_MessageKey $value)
    {
        return $this->append(self::MESSAGEKEYS, $value);
    }

    /**
     * Clears 'messageKeys' list.
     *
     * @return null
     */
    public function clearMessageKeys()
    {
        return $this->clear(self::MESSAGEKEYS);
    }

    /**
     * Returns 'messageKeys' list.
     *
     * @return Textsecure_SessionStructure_Chain_MessageKey[]
     */
    public function getMessageKeys()
    {
        return $this->get(self::MESSAGEKEYS);
    }

    /**
     * Returns 'messageKeys' iterator.
     *
     * @return ArrayIterator
     */
    public function getMessageKeysIterator()
    {
        return new \ArrayIterator($this->get(self::MESSAGEKEYS));
    }

    /**
     * Returns element from 'messageKeys' list at given offset.
     *
     * @param int $offset Position in list
     *
     * @return Textsecure_SessionStructure_Chain_MessageKey
     */
    public function getMessageKeysAt($offset)
    {
        return $this->get(self::MESSAGEKEYS, $offset);
    }

    /**
     * Returns count of 'messageKeys' list.
     *
     * @return int
     */
    public function getMessageKeysCount()
    {
        return $this->count(self::MESSAGEKEYS);
    }
}