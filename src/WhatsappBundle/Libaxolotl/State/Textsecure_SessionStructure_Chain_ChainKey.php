<?php
namespace WhatsappBundle\Libaxolotl\State;
class Textsecure_SessionStructure_Chain_ChainKey extends \ProtobufMessage
{
    /* Field index constants */
    const INDEX = 1;
    const KEY = 2;

    /* @var array Field descriptors */
    protected static $fields = [
        self::INDEX => [
            'name'     => 'index',
            'required' => false,
            'type'     => 5,
        ],
        self::KEY => [
            'name'     => 'key',
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
        $this->values[self::INDEX] = null;
        $this->values[self::KEY] = null;
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
     * Sets value of 'index' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setIndex($value)
    {
        return $this->set(self::INDEX, $value);
    }

    /**
     * Returns value of 'index' property.
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->get(self::INDEX);
    }

    /**
     * Sets value of 'key' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setKey($value)
    {
        return $this->set(self::KEY, $value);
    }

    /**
     * Returns value of 'key' property.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->get(self::KEY);
    }
}