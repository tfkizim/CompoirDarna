<?php
namespace WhatsappBundle\Libaxolotl\State;
class Textsecure_RecordStructure extends \ProtobufMessage
{
    /* Field index constants */
    const CURRENTSESSION = 1;
    const PREVIOUSSESSIONS = 2;

    /* @var array Field descriptors */
    protected static $fields = [
        self::CURRENTSESSION => [
            'name'     => 'currentSession',
            'required' => false,
            'type'     => 'Textsecure_SessionStructure',
        ],
        self::PREVIOUSSESSIONS => [
            'name'     => 'previousSessions',
            'repeated' => true,
            'type'     => 'Textsecure_SessionStructure',
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
        $this->values[self::CURRENTSESSION] = null;
        $this->values[self::PREVIOUSSESSIONS] = [];
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
     * Sets value of 'currentSession' property.
     *
     * @param Textsecure_SessionStructure $value Property value
     *
     * @return null
     */
    public function setCurrentSession(Textsecure_SessionStructure $value)
    {
        return $this->set(self::CURRENTSESSION, $value);
    }

    /**
     * Returns value of 'currentSession' property.
     *
     * @return Textsecure_SessionStructure
     */
    public function getCurrentSession()
    {
        return $this->get(self::CURRENTSESSION);
    }

    /**
     * Appends value to 'previousSessions' list.
     *
     * @param Textsecure_SessionStructure $value Value to append
     *
     * @return null
     */
    public function appendPreviousSessions(Textsecure_SessionStructure $value)
    {
        return $this->append(self::PREVIOUSSESSIONS, $value);
    }

    /**
     * Clears 'previousSessions' list.
     *
     * @return null
     */
    public function clearPreviousSessions()
    {
        return $this->clear(self::PREVIOUSSESSIONS);
    }

    /**
     * Returns 'previousSessions' list.
     *
     * @return Textsecure_SessionStructure[]
     */
    public function getPreviousSessions()
    {
        return $this->get(self::PREVIOUSSESSIONS);
    }

    /**
     * Returns 'previousSessions' iterator.
     *
     * @return ArrayIterator
     */
    public function getPreviousSessionsIterator()
    {
        return new \ArrayIterator($this->get(self::PREVIOUSSESSIONS));
    }

    /**
     * Returns element from 'previousSessions' list at given offset.
     *
     * @param int $offset Position in list
     *
     * @return Textsecure_SessionStructure
     */
    public function getPreviousSessionsAt($offset)
    {
        return $this->get(self::PREVIOUSSESSIONS, $offset);
    }

    /**
     * Returns count of 'previousSessions' list.
     *
     * @return int
     */
    public function getPreviousSessionsCount()
    {
        return $this->count(self::PREVIOUSSESSIONS);
    }
}