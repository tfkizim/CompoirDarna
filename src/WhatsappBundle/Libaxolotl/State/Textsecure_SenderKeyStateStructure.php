<?php
namespace WhatsappBundle\Libaxolotl\State;
class Textsecure_SenderKeyStateStructure extends \ProtobufMessage
{
    /* Field index constants */
    const SENDERKEYID = 1;
    const SENDERCHAINKEY = 2;
    const SENDERSIGNINGKEY = 3;
    const SENDERMESSAGEKEYS = 4;

    /* @var array Field descriptors */
    protected static $fields = [
        self::SENDERKEYID => [
            'name'     => 'senderKeyId',
            'required' => false,
            'type'     => 5,
        ],
        self::SENDERCHAINKEY => [
            'name'     => 'senderChainKey',
            'required' => false,
            'type'     => 'Textsecure_SenderKeyStateStructure_SenderChainKey',
        ],
        self::SENDERSIGNINGKEY => [
            'name'     => 'senderSigningKey',
            'required' => false,
            'type'     => 'Textsecure_SenderKeyStateStructure_SenderSigningKey',
        ],
        self::SENDERMESSAGEKEYS => [
            'name'     => 'senderMessageKeys',
            'repeated' => true,
            'type'     => 'Textsecure_SenderKeyStateStructure_SenderMessageKey',
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
        $this->values[self::SENDERKEYID] = null;
        $this->values[self::SENDERCHAINKEY] = null;
        $this->values[self::SENDERSIGNINGKEY] = null;
        $this->values[self::SENDERMESSAGEKEYS] = [];
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
     * Sets value of 'senderKeyId' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setSenderKeyId($value)
    {
        return $this->set(self::SENDERKEYID, $value);
    }

    /**
     * Returns value of 'senderKeyId' property.
     *
     * @return int
     */
    public function getSenderKeyId()
    {
        return $this->get(self::SENDERKEYID);
    }

    /**
     * Sets value of 'senderChainKey' property.
     *
     * @param Textsecure_SenderKeyStateStructure_SenderChainKey $value Property value
     *
     * @return null
     */
    public function setSenderChainKey(Textsecure_SenderKeyStateStructure_SenderChainKey $value)
    {
        return $this->set(self::SENDERCHAINKEY, $value);
    }

    /**
     * Returns value of 'senderChainKey' property.
     *
     * @return Textsecure_SenderKeyStateStructure_SenderChainKey
     */
    public function getSenderChainKey()
    {
        return $this->get(self::SENDERCHAINKEY);
    }

    /**
     * Sets value of 'senderSigningKey' property.
     *
     * @param Textsecure_SenderKeyStateStructure_SenderSigningKey $value Property value
     *
     * @return null
     */
    public function setSenderSigningKey(Textsecure_SenderKeyStateStructure_SenderSigningKey $value)
    {
        return $this->set(self::SENDERSIGNINGKEY, $value);
    }

    /**
     * Returns value of 'senderSigningKey' property.
     *
     * @return Textsecure_SenderKeyStateStructure_SenderSigningKey
     */
    public function getSenderSigningKey()
    {
        return $this->get(self::SENDERSIGNINGKEY);
    }

    /**
     * Appends value to 'senderMessageKeys' list.
     *
     * @param Textsecure_SenderKeyStateStructure_SenderMessageKey $value Value to append
     *
     * @return null
     */
    public function appendSenderMessageKeys(Textsecure_SenderKeyStateStructure_SenderMessageKey $value)
    {
        return $this->append(self::SENDERMESSAGEKEYS, $value);
    }

    /**
     * Clears 'senderMessageKeys' list.
     *
     * @return null
     */
    public function clearSenderMessageKeys()
    {
        return $this->clear(self::SENDERMESSAGEKEYS);
    }

    /**
     * Returns 'senderMessageKeys' list.
     *
     * @return Textsecure_SenderKeyStateStructure_SenderMessageKey[]
     */
    public function getSenderMessageKeys()
    {
        return $this->get(self::SENDERMESSAGEKEYS);
    }

    /**
     * Returns 'senderMessageKeys' iterator.
     *
     * @return ArrayIterator
     */
    public function getSenderMessageKeysIterator()
    {
        return new \ArrayIterator($this->get(self::SENDERMESSAGEKEYS));
    }

    /**
     * Returns element from 'senderMessageKeys' list at given offset.
     *
     * @param int $offset Position in list
     *
     * @return Textsecure_SenderKeyStateStructure_SenderMessageKey
     */
    public function getSenderMessageKeysAt($offset)
    {
        return $this->get(self::SENDERMESSAGEKEYS, $offset);
    }

    /**
     * Returns count of 'senderMessageKeys' list.
     *
     * @return int
     */
    public function getSenderMessageKeysCount()
    {
        return $this->count(self::SENDERMESSAGEKEYS);
    }
}