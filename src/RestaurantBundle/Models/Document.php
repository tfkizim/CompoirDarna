<?php

namespace RestaurantBundle\Models;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * @Entity
 */
class Document
{
    /** @var File  - not a persistent field! */
    private $file;
    
    /** @var string
     * @Column(type="string")
     */
    private $filePersistencePath;
    
    /** @var string */
    protected static $uploadDirectory = null;
    
    static public function setUploadDirectory($dir)
    {
        if (!is_dir($dir)) {
            if (false === @mkdir($dir, 0777, true)) {
                throw new FileException(sprintf('Unable to create the "%s" directory', $dir));
            }
        } elseif (!is_writable($dir)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory', $dir));
        }
        self::$uploadDirectory = $dir;
    }
    
    static public function getUploadDirectory()
    {
        if (self::$uploadDirectory === null) {
            throw new \RuntimeException("Trying to access upload directory for profile files");
        }
        return self::$uploadDirectory;
    }
    
    /**
     * Assumes 'type' => 'file'
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }
    
    public function getFile()
    {
        return new File(self::getUploadDirectory() . "/" . $this->filePersistencePath);
    }
    
    public function getFilePersistencePath()
    {
        return $this->filePersistencePath;
    }
    
    public function processFile()
    {
        if (! ($this->file instanceof UploadedFile) ) {
            return false;
        }
        $uploadFileMover = new UploadFileMover();
        $this->filePersistencePath = $uploadFileMover->moveUploadedFile($this->file, self::getUploadDirectory());
    }
}