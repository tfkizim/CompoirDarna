<?php
namespace WhatsappBundle\Models;
class SenderKeyGroupData extends \ProtobufMessage
{
    const MESSAGE = 1;
    const SENDER_KEY = 2;
  /* @var array Field descriptors */
  protected static $fields = [
      self::MESSAGE => [
        'name'     => 'message',
        'required' => false,
        'type'     => 7,
      ],
      self::SENDER_KEY => [
          'name'     => 'sender_key',
          'required' => false,
          'type'     => 'SenderKeyGroupMessage',
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
      $this->values[self::SENDER_KEY] = null;
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

    public function getSenderKey()
    {
        return $this->values[self::SENDER_KEY];
    }

    public function setMessage($data)
    {
        $this->values[self::MESSAGE] = $data;
    }

    public function setSenderKey($sender_key)
    {
        $this->values[self::SENDER_KEY] = $sender_key;
    }
}