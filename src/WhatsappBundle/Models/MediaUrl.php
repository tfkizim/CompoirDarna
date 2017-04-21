<?php
namespace WhatsappBundle\Models;

class MediaUrl extends \ProtobufMessage
{
    const MESSAGE = 1; //full message with the url
    const URL = 2; // only the url
    const UNK_1 = 3;
    const UNK_2 = 4;
    const DESCRIPTION = 5; //Metadata description
    const TITLE = 6; //Page title
    protected static $fields = [
        self::MESSAGE => [
            'name'     => 'message',
            'required' => false,
            'type'     => 7,
        ],
        self::URL => [
            'name'     => 'url',
            'required' => false,
            'type'     => 7,
        ],
        self::UNK_1 => [
            'name'     => 'unknown1',
            'required' => false,
            'type'     => 5,
        ],
        self::UNK_1 => [
            'name'     => 'unknown2',
            'required' => false,
            'type'     => 7,
        ],
        self::DESCRIPTION => [
            'name'     => 'description',
            'required' => false,
            'type'     => 7,
        ],
        self::TITLE => [
            'name'     => 'title',
            'required' => false,
            'type'     => 7,
        ],
    ];

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
        $this->values[self::MESSAGE] = null;
        $this->values[self::URL] = null;
        $this->values[self::UNK_1] = null;
        $this->values[self::UNK_2] = null;
        $this->values[self::DESCRIPTION] = null;
        $this->values[self::TITLE] = null;
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

    public function getMessage()
    {
        return $this->values[self::MESSAGE];
    }

    public function getUrl()
    {
        return $this->values[self::URL];
    }

    public function getUnknown1()
    {
        return $this->values[self::UNK_1];
    }

    public function getUnknown2()
    {
        return $this->values[self::UNK_2];
    }

    public function getDescription()
    {
        return $this->values[self::DESCRIPTION];
    }

    public function getTitle()
    {
        return $this->values[self::TITLE];
    }

    public function setMessage($value)
    {
        $this->values[self::MESSAGE] = $value;
    }

    public function setUrl($value)
    {
        $this->values[self::URL] = $value;
    }

    public function setUnknown1($value)
    {
        $this->values[self::UNK_1] = $value;
    }

    public function setUnknown2($value)
    {
        $this->values[self::UNK_2] = $value;
    }

    public function setDescription($value)
    {
        $this->values[self::DESCRIPTION] = $value;
    }

    public function setTitle($value)
    {
        $this->values[self::TITLE] = $value;
    }
}