<?php
namespace RestaurantBundle\Models;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileMover
{
    public function moveUploadedFile(UploadedFile $file, $uploadBasePath)
    {
        $originalName = $file->getClientOriginalName();
        
        // use filemtime() to have a more determenistic way to determine the subpath, otherwise its hard to test.
        $relativePath = date('Y-m', filemtime($file->getPath()));
        $targetFileName = $relativePath . DIRECTORY_SEPARATOR . $originalName;
        $targetFilePath = $uploadBasePath . DIRECTORY_SEPARATOR . $targetFileName;
        $ext = $file->getClientOriginalExtension();
        $i=1;
        while (file_exists($targetFilePath)) {
            if ($ext) {
                $i=intval($i);
                if($i==1){
                    $prev="";
                }else{
                    $prev=$i-1;
                    $prev=intval($prev);
                }                
                $targetFilePath = str_replace($prev .".". $ext, $i .".". $ext, $targetFilePath);
            } else {
                $targetFilePath = $targetFilePath . $i++;
            }
        }
        
        $targetDir = $uploadBasePath . DIRECTORY_SEPARATOR . $relativePath;
        if (!is_dir($targetDir)) {
            $ret = mkdir($targetDir, 0777, true);
            if (!$ret) {
                throw new \RuntimeException("Could not create target directory to move temporary file into.");
            }
        }
        $file->move($targetDir, basename($targetFilePath));
        
        return str_replace($uploadBasePath . DIRECTORY_SEPARATOR, "", $targetFilePath);
    }
}