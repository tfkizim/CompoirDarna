<?php
namespace WhatsappBundle\Libaxolotl\State;
class Textsecure_SenderKeyStateStructure_SenderSigningKey extends \ProtobufMessage
{
    /* Field index constants */
    const _PUBLIC = 1;
    const _PRIVATE = 2;

    /* @var array Field descriptors */
    protected static $fields = [
        self::_PUBLIC => [
            'name'     => 'public',
            'required' => false,
            'type'     => 7,
        ],
        self::_PRIVATE => [
            'name'     => 'private',
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
        $this->values[self::_PUBLIC] = null;
        $this->values[self::_PRIVATE] = null;
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
     * Sets value of 'public' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPublic($value)
    {
        return $this->set(self::_PUBLIC, $value);
    }

    /**
     * Returns value of 'public' property.
     *
     * @return string
     */
    public function getPublic()
    {
        return $this->get(self::_PUBLIC);
    }

    /**
     * Sets value of 'private' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setPrivate($value)
    {
        return $this->set(self::_PRIVATE, $value);
    }

    /**
     * Returns value of 'private' property.
     *
     * @return string
     */
    public function getPrivate()
    {
        return $this->get(self::_PRIVATE);
    }
}