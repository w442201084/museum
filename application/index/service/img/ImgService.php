<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/10/29
 * Time: 18:41
 */

namespace app\index\service\img;


use library\exception\FileUploadException;

class ImgService
{
    const FILE_UPLOAD_ALLOW_TYPES = [
        'image/png',
        'image/jpeg',
    ];

    /**
     * @desc 图片允许上传最大尺寸 | byte
     */
    const FILE_UPLOAD_MAX_SIZE = 1024 * 1024;

    protected static function getImgUploadPath()
    {
        return __IMAGE__;
    }

    public static function upload($files)
    {
        if( $files['file']['size'] > self::FILE_UPLOAD_MAX_SIZE ) {
            throw new FileUploadException('图片上传大小超过上限，最多允许上传1M', 100701);
        }
        if( !in_array($files['file']['type'] , self::FILE_UPLOAD_ALLOW_TYPES) ) {
            throw new FileUploadException('图片上传类型错误', 100702);
        }
        list(, $fileExt) = explode('.' , $_FILES["file"]["name"]);
        $fileName = md5(time() . rand_str()) . '.' . $fileExt;
        $dirPath = $savePath = static :: getImgUploadPath();
        if( !is_dir($dirPath) ) {
            mkdir($dirPath , 0777 , true);
        }
        $savePath = $dirPath . DIRECTORY_SEPARATOR . $fileName;
        $status = move_uploaded_file($_FILES["file"]["tmp_name"],$savePath);
        if($status) {
            return ['fileName' => $fileName , 'filePath' =>   config('common.img_prefix') . DIRECTORY_SEPARATOR . $fileName];
        } else {
            throw new FileUploadException('图片保存过程中出现异常' , 100703);
        }
    }

}