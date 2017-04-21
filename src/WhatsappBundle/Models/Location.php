<?php
namespace WhatsappBundle\Models;
class Location extends \ProtobufMessage
{
    const LATITUDE = 1;
    const LONGITUDE = 2;
    const NAME = 3;
    const DESCRIPTION = 4;
    const URL = 5;
    const THUMBNAIL = 6;
    /* @var array Field descriptors */
    protected static $fields = [
      self::LATITUDE => [
          'name'     => 'Latitude',
          'required' => false,
          'type'     => 1,
      ],
      self::LONGITUDE => [
          'name'     => 'Longitude',
          'required' => false,
          'type'     => 1,
      ],
      self::NAME => [
          'name'     => 'Name',
          'required' => false,
          'type'     => 7,
      ],
      self::DESCRIPTION => [
          'name'     => 'Description',
          'required' => false,
          'type'     => 7,
      ],
      self::URL => [
          'name'     => 'Url',
          'required' => false,
          'type'     => 7,
      ],
      self::THUMBNAIL => [
          'name'     => 'Thumbnail',
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
      $this->values[self::LATITUDE] = null;
      $this->values[self::LONGITUDE] = null;
      $this->values[self::NAME] = null;
      $this->values[self::DESCRIPTION] = null;
      $this->values[self::URL] = null;
      $this->values[self::THUMBNAIL] = null;
  }

    public function parseFromString($data)
    {
        parent::parseFromString($data);
        $this->setThumbnail(stristr($data, hex2bin('ffd8ffe0')));
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

    public function getLatitude()
    {
        return $this->values[self::LATITUDE];
    }

    public function getLongitude()
    {
        return $this->values[self::LONGITUDE];
    }

    public function getThumbnail()
    {
        return $this->values[self::THUMBNAIL];
    }

    public function getName()
    {
        return $this->values[self::NAME];
    }

    public function getDescription()
    {
        return $this->values[self::DESCRIPTION];
    }

    public function getUrl()
    {
        return $this->values[self::URL];
    }

    public function setName($value)
    {
        $this->values[self::NAME] = $value;
    }

    public function setDescription($value)
    {
        $this->values[self::DESCRIPTION] = $value;
    }

    public function setUrl($value)
    {
        $this->values[self::URL] = $value;
    }

    public function setLatitude($value)
    {
        $this->values[self::LATITUDE] = $value;
    }

    public function setLongitude($value)
    {
        $this->values[self::LONGITUDE] = $value;
    }

    public function setThumbnail($value)
    {
        $this->values[self::THUMBNAIL] = $value;
    }

    protected function WriteUInt32($val)
    {
        $result = '';
        $num1 = null;
        while (true) {
            $num1 = ($val & 127);
            $val >>= 7;
            if ($val != 0) {
                $num2 = $num1 | 128;
                $result .= chr($num2);
            } else {
                break;
            }
        }
        $result .= chr($num1);

        return $result;
    }

    public function serializeToString()
    {
        $thumb = $this->getThumbnail();
        $this->setThumbnail(null);
        $data = parent::serializeToString();
        $data .= hex2bin('8201');
        $data .= $this->WriteUInt32(strlen($thumb));
        $data .= $thumb;
        $this->setThumbnail($thumb);

        return $data;
    }
}