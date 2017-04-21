<?php
namespace WhatsappBundle\Libaxolotl\State;
class Textsecure_SenderKeyStateStructure_SenderChainKey extends \ProtobufMessage
{
    /* Field index constants */
    const ITERATION = 1;
    const SEED = 2;

    /* @var array Field descriptors */
    protected static $fields = [
        self::ITERATION => [
            'name'     => 'iteration',
            'required' => false,
            'type'     => 5,
        ],
        self::SEED => [
            'name'     => 'seed',
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
        $this->values[self::ITERATION] = null;
        $this->values[self::SEED] = null;
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
     * Sets value of 'iteration' property.
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setIteration($value)
    {
        return $this->set(self::ITERATION, $value);
    }

    /**
     * Returns value of 'iteration' property.
     *
     * @return int
     */
    public function getIteration()
    {
        return $this->get(self::ITERATION);
    }

    /**
     * Sets value of 'seed' property.
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setSeed($value)
    {
        return $this->set(self::SEED, $value);
    }

    /**
     * Returns value of 'seed' property.
     *
     * @return string
     */
    public function getSeed()
    {
        return $this->get(self::SEED);
    }
}