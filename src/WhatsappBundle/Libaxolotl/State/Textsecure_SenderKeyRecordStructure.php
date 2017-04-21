<?php
namespace WhatsappBundle\Libaxolotl\State;
class Textsecure_SenderKeyRecordStructure extends \ProtobufMessage
{
    /* Field index constants */
    const SENDERKEYSTATES = 1;

    /* @var array Field descriptors */
    protected static $fields = [
        self::SENDERKEYSTATES => [
            'name'     => 'senderKeyStates',
            'repeated' => true,
            'type'     => 'Textsecure_SenderKeyStateStructure',
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
        $this->values[self::SENDERKEYSTATES] = [];
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
     * Appends value to 'senderKeyStates' list.
     *
     * @param Textsecure_SenderKeyStateStructure $value Value to append
     *
     * @return null
     */
    public function appendSenderKeyStates(Textsecure_SenderKeyStateStructure $value)
    {
        return $this->append(self::SENDERKEYSTATES, $value);
    }

    /**
     * Clears 'senderKeyStates' list.
     *
     * @return null
     */
    public function clearSenderKeyStates()
    {
        return $this->clear(self::SENDERKEYSTATES);
    }

    /**
     * Returns 'senderKeyStates' list.
     *
     * @return Textsecure_SenderKeyStateStructure[]
     */
    public function getSenderKeyStates()
    {
        return $this->get(self::SENDERKEYSTATES);
    }

    /**
     * Returns 'senderKeyStates' iterator.
     *
     * @return ArrayIterator
     */
    public function getSenderKeyStatesIterator()
    {
        return new \ArrayIterator($this->get(self::SENDERKEYSTATES));
    }

    /**
     * Returns element from 'senderKeyStates' list at given offset.
     *
     * @param int $offset Position in list
     *
     * @return Textsecure_SenderKeyStateStructure
     */
    public function getSenderKeyStatesAt($offset)
    {
        return $this->get(self::SENDERKEYSTATES, $offset);
    }

    /**
     * Returns count of 'senderKeyStates' list.
     *
     * @return int
     */
    public function getSenderKeyStatesCount()
    {
        return $this->count(self::SENDERKEYSTATES);
    }
}