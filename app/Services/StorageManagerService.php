<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Exception;
class StorageManagerService
{
    /**
     * @var string[] $allowedFiles
     */
    public static $allowedFiles = ['doc', 'docx', 'pdf', 'ppt', 'pptx'];

    /**
     * @var string[] $allowedImages
     */
    public static $allowedImages = ['png', 'jpg', 'jpeg', 'gif', 'jpe'];

    /**
     * @var string[] $allowedVideos
     */
    public static $allowedVideos = ['mp4', 'mpeg'];

    /**
     * @var string[] $allowedAudios
     */
    public static $allowedAudios = ['mp3', 'wav', 'ogg', 'flac', 'aac'];

    /**
     * @var string[] $placeholders
     */
    public static $placeholders = ['avatar.png','avatar.jpg','placeholder.png','placeholder.jpg','default.png','default.jpg'];

    /**
     * StorageManagerService constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $file
     * @throws Exception
     */
    private function checkAllowedType($file)
    {
        if(!in_array($file->extension(),self::$allowedFiles)&&
            !in_array($file->extension(),self::$allowedImages)&&
            !in_array($file->extension(),self::$allowedVideos)&&
            !in_array($file->extension(),self::$allowedAudios)
        ){
            throw new Exception(__('File type not allowed'));
        }
    }

    private function createDirectoryIfNotExist($directoryName,$disk = 'public')
    {
        if(!Storage::disk($disk)->exists($directoryName)){
            Storage::disk($disk)->makeDirectory($directoryName);
        }
    }

    /**
     * @param $file
     * @param $directory_name
     * @return string
     * @throws Exception
     */
    public function uploadPublicFile($file,$directory_name,$old_file_name = null): string
    {
        try{
            $this->checkAllowedType($file);
            $this->createDirectoryIfNotExist($directory_name);
            $originalClientName = method_exists($file,'getClientOriginalName')?cleanStr($file->getClientOriginalName()):\Str::uuid()->toString().'.'.$file->extension();
            $fileName = !empty($old_file_name) && !str_contains($old_file_name,'placeholder')?$old_file_name:time(). '-'. $originalClientName;
            Storage::disk('public')->putFileAs($directory_name,$file,$fileName);
            return $fileName;
        }
        catch (Exception $exception){
            throw $exception;
        }
    }

    /**
     * @param $file
     * @param string $directory_name
     * @return string
     * @throws Exception
     */
    public function uploadPrivateFile($file,$directory_name): string
    {
        try{
            $this->checkAllowedType($file);
            $this->createDirectoryIfNotExist($directory_name,'private');
            $fileName = time(). '-'. cleanStr($file->getClientOriginalName());

            Storage::disk('private')->putFileAs($directory_name,$file,$fileName);

            return $fileName;
        }
        catch (Exception $exception){
            throw $exception;
        }
    }

    /**
     * @param $file
     * @param string $directory_name
     * @return bool
     * @throws Exception
     */
    public function deletePublicFile($file,$directory_name):bool
    {
        try{
            if(!in_array($file,self::$placeholders)){
                if(Storage::disk('public')->exists($directory_name.'/'.$file)){
                    Storage::disk('public')->delete($directory_name.'/'.$file);
                    return true;
                }
            }
            return false;
        }
        catch (Exception $exception){
            throw $exception;
        }
    }

    /**
     * @param $file
     * @param string $directory_name
     * @return bool
     * @throws Exception
     */
    public function deletePrivateFile($file,$directory_name):bool
    {
        try{
            if(Storage::disk('private')->exists($directory_name.'/'.$file)){
                Storage::disk('private')->delete($directory_name.'/'.$file);
                return true;
            }
            return false;
        }
        catch (Exception $exception){
            throw $exception;
        }
    }
}
