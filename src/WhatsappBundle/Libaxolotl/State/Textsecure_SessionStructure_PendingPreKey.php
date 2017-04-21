<?php
namespace WhatsappBundle\Libaxolotl\State;
class Textsecure_SessionStructure_PendingPreKey extends \ProtobufMessage
{
    /* Field index constants */
    const PREKEYID = 1;
    const SIGNEDPREKEYID = 3;
    const BASEKEY = 2;

    /* @var array Field descriptors */
    protected static $fields = [
        self::PREKEYID => [
            'name'     => 'preKeyId',
            'required' => false,
            'type'     => 5,
        ],
        self::SIGNEDPREKEYID => [
            'name'     => 'signedPreKeyId',
            'required' => false,
            'type'     => 5,
        ],
        self::BASEKEY => [
            'name'     => 'baseKey',
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
        $this->values[self::PREKEYID] = null;
        $this->values[self::SIGNEDPREKEYID] = null;
        $this->values[self::BASEKEY] = null;
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
     * Sets value of 'preKeyId' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setPreKeyId($value)
    {
        return $this->set(self::PREKEYID, $value);
    }

    /**
     * Returns value of 'preKeyId' property.
     *
     * @return int
     */
    public function getPreKeyId()
    {
        return $this->get(self::PREKEYID);
    }

    /**
     * Sets value of 'signedPreKeyId' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setSignedPreKeyId($value)
    {
        return $this->set(self::SIGNEDPREKEYID, $value);
    }

    /**
     * Returns value of 'signedPreKeyId' property.
     *
     * @return int
     */
    public function getSignedPreKeyId()
    {
        return $this->get(self::SIGNEDPREKEYID);
    }

    /**
     * Sets value of 'baseKey' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setBaseKey($value)
    {
        return $this->set(self::BASEKEY, $value);
    }

    /**
     * Returns value of 'baseKey' property.
     *
     * @return string
     */
    public function getBaseKey()
    {
        return $this->get(self::BASEKEY);
    }
}