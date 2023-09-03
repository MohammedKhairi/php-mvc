<?php
namespace app\core;
use app\core\Application;

class Image
{

    public $uts='';
    public string $dir = '';

    public function __construct() {
        $this->uts = time();
        $this->dir = Dir.'/';
    }
    public function getImageExtension($filename){
        $n=explode('.',$filename);
        $exe=end($n);
        return strtolower($exe);
    }
    public function resize($file, $max_size = 700)
    {
        $filename=$file['tmp_name'];
        $type = $file['type'];
        switch ($type) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($filename);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filename);
                break;
            default:
                break;
        }
        #
        $src_w=imagesx($image);
        $src_h=imagesy($image);
        #
        if($src_w > $src_h){
            if($src_w < $max_size) 
                $max_size=$src_w;

            $dst_w=$max_size;
            $dst_h=($src_h / $src_w) * $max_size; 
        }
        else{
            if($src_h < $max_size) 
                $max_size=$src_h ;

            $dst_h=$max_size;
            $dst_w=($src_h / $src_h) * $max_size; 
        }
        #
        $dst_w=round($src_w);
        $dst_h=round($src_h);
        #
        $dst_image=imagecreatetruecolor($dst_w,$dst_h );
        
        if("image/png"==$type){
            imagealphablending($dst_image,false); 
            imagesavealpha($dst_image ,true);
         }
        #
       imagecopyresampled($dst_image,$image,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
       #
       imagedestroy($image);
        #
        switch ($type) {
            case 'image/jpeg':
                imagejpeg($dst_image,$filename,90);
                break;
            case 'image/png':
                imagepng($dst_image,$filename,90);
                break;
            default:
                # code...
                break;
        }
       imagedestroy($dst_image);
        return $filename; 

    }
    public function upload($file,$folder=''){
        #
        $path= $this->getFilePath($folder);
        #
        $exe=$this->getImageExtension($file['name']);
        $filename=$this->uts.'.'.$exe;
        if(move_uploaded_file($file['tmp_name'],$path.$filename))
            return $filename;
        else
            return false;
    }
    public function getImage($name,$folder=''){
    return  $this->getFilePath().$name; 
    }
    public function getFilePath($type=''):string{ 
        $folder='';
        switch ($type){
            case 'emp':
                $folder='emp.pic';
                break;
            case 'std':
                $folder='std.pic';
                break;
            case 'user':
                $folder='user.pic';
                break;
            default:
                $folder='uploads';
                break;
        }
        #
        return  $this->dir.$folder.'/';

    }
    public function cropResizeUpload($file,$dst_w=300,$dst_h=200){
        $tempName = $file["tmp_name"];            
        // Set the desired dimensions for resizing and cropping
        $targetWidth = $dst_w;
        $targetHeight = $dst_h;
        
        // Load the original image using GD
        $imageInfo = getimagesize($tempName);
        $mime = $imageInfo["mime"];
        
        if ($mime == "image/jpeg") {
            $originalImage = imagecreatefromjpeg($tempName);
        } elseif ($mime == "image/png") {
            $originalImage = imagecreatefrompng($tempName);
        } elseif ($mime == "image/gif") {
            $originalImage = imagecreatefromgif($tempName);
        } else {
            echo "Unsupported image format.";
            exit;
        }
        
        // Create a new image with the desired dimensions
        $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);
        
        // Resize and crop the image
        imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $targetWidth, $targetHeight, imagesx($originalImage), imagesy($originalImage));
        
        // Save the resized and cropped image to a new file
        $exe=$this->getImageExtension($file['name']);
        $filename=$this->uts.'.'.$exe;
        $outputFilePath = $this->getFilePath().$filename;
        
        if ($mime == "image/jpeg") {
            imagejpeg($resizedImage, $outputFilePath);
        } elseif ($mime == "image/png") {
            imagepng($resizedImage, $outputFilePath);
        } elseif ($mime == "image/gif") {
            imagegif($resizedImage, $outputFilePath);
        }
        
        // Free up memory
        imagedestroy($originalImage);
        imagedestroy($resizedImage);
        
        return $filename;
        


    }

}