<?php
namespace WhatsappBundle\Models;
class DocumentMessage extends \ProtobufMessage
{
    const URL = 1;
    const MIMETYPE = 2;
    const NAME = 3;
    const SHA256 = 4;
    const LENGTH = 5;
    const UNK_2 = 6;
    const REFKEY = 7;
    const FILENAME = 8;
    const THUMBNAIL = 9;
    /* @var array Field descriptors */
  protected static $fields = [
      self::URL => [
          'name'     => 'url',
          'required' => false,
          'type'     => 7,
      ],
      self::MIMETYPE => [
          'name'     => 'mimetype',
          'required' => false,
          'type'     => 7,
      ],
      self::NAME => [
          'name'     => 'name',
          'required' => false,
          'type'     => 7,
      ],
      self::LENGTH => [
          'name'     => 'length',
          'required' => false,
          'type'     => 5,
      ],
      self::SHA256 => [
          'name'     => 'sha256',
          'required' => false,
          'type'     => 7,
      ],
      self::UNK_2 => [
          'name'     => 'UNK_2',
          'required' => false,
          'type'     => 5,
      ],
      self::REFKEY => [
          'name'     => 'refkey',
          'required' => false,
          'type'     => 7,
      ],
      self::FILENAME => [
          'name'     => 'filename',
          'required' => false,
          'type'     => 7,
      ],
      self::THUMBNAIL => [
          'name'     => 'thumbnail',
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
      $this->values[self::URL] = null;
      $this->values[self::MIMETYPE] = null;
      $this->values[self::NAME] = null;
      $this->values[self::LENGTH] = null;
      $this->values[self::SHA256] = null;
      $this->values[self::UNK_2] = null;
      $this->values[self::REFKEY] = null;
      $this->values[self::FILENAME] = null;
      $this->values[self::THUMBNAIL] = null;
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

    public function getUrl()
    {
        return $this->values[self::URL];
    }

    public function getMimeType()
    {
        return $this->values[self::MIMETYPE];
    }

    public function getLength()
    {
        return $this->values[self::LENGTH];
    }

    public function getName()
    {
        return $this->values[self::NAME];
    }

    public function getUNK2()
    {
        return $this->values[self::UNK2];
    }

    public function getRefKey()
    {
        return $this->values[self::REFKEY];
    }

    public function getFilename()
    {
        return $this->values[self::FILENAME];
    }

    public function getThumbnail()
    {
        return $this->values[self::THUMBNAIL];
    }

    public function setUrl($newValue)
    {
        $this->values[self::URL] = $newValue;
    }

    public function setMimeType($newValue)
    {
        $this->values[self::MIMETYPE] = $newValue;
    }

    public function setName($newValue)
    {
        $this->values[self::NAME] = $newValue;
    }

    public function setSha256($newValue)
    {
        $this->values[self::SHA256] = $newValue;
    }

    public function setLength($newValue)
    {
        $this->values[self::LENGTH] = $newValue;
    }

    public function setRefKey($newValue)
    {
        $this->values[self::REFKEY] = $newValue;
    }

    public function setThumbnail($newValue)
    {
        $this->values[self::THUMBNAIL] = $newValue;
    }

    public function parseFromString($data)
    {
        parent::parseFromString($data);
        $this->setThumbnail(stristr($data, hex2bin('ffd8ffe0')));
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