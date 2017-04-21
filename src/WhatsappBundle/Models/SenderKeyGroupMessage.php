<?php
namespace WhatsappBundle\Models;

class SenderKeyGroupMessage extends \ProtobufMessage
{
    const GROUP_ID = 1;
    const SENDER_KEY = 2;
  /* @var array Field descriptors */
  protected static $fields = [
      self::GROUP_ID => [
          'name'     => 'group_id',
          'required' => false,
          'type'     => 7,
      ],
      self::SENDER_KEY => [
          'name'     => 'sender_key',
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
      $this->values[self::GROUP_ID] = null;
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

    public function getGroupId()
    {
        return $this->values[self::GROUP_ID];
    }

    public function getSenderKey()
    {
        return $this->values[self::SENDER_KEY];
    }

    public function setGroupId($id)
    {
        $this->values[self::GROUP_ID] = $id;
    }

    public function setSenderKey($sender_key)
    {
        $this->values[self::SENDER_KEY] = $sender_key;
    }
}