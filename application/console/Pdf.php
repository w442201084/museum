<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/11/5
 * Time: 15:55
 */

namespace app\console;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\Output;

class Pdf extends Command
{
    /**
    /apps/svr/php-7.1.20/bin/php /apps/data/web/working/university/think pdf /tmp/123.pdf /tmp/pdf/
    /usr/local/php/bin/php /www/university/think pdf /tmp/123.pdf /tmp/pdf/
     */
    protected function configure()
    {
        $this
            // 命令的名字（"think" 后面的部分）
            ->setName('pdf')
            // 配置一个参数
            ->addArgument('pdfSrc', Argument::REQUIRED, 'Who like ThinkPHP ?')
            ->addArgument('saveImgSrc', Argument::REQUIRED, 'Who like ThinkPHP ?')
            ->addArgument('last_name', Argument::OPTIONAL, 'Your last name?')
            // 运行 "php think list" 时的简短描述
            ->setDescription('Creates new users.')
            // 运行命令时使用 "--help" 选项时的完整命令描述
            ->setHelp("This command allows you to create users...");
    }

    protected function execute(Input $input, Output $output)
    {
        $pdfSrc = $input->getArgument('pdfSrc');
        $saveImgSrc = $input->getArgument('saveImgSrc');
        $this -> pdf2png($pdfSrc , $saveImgSrc);
    }

    public function pdf2png($pdf, $path)
    {
        if(!is_dir($path)) {
            mkdir($path , 0777 , true);
        }
        if (!extension_loaded('imagick')) {
            return -1;
        }
        if (!file_exists($pdf)) {
            return -2;
        }
        $imgPath = $imgBasePath = [];
        $im = new \Imagick();
        $im->setResolution(144, 144); //设置分辨率 值越大分辨率越高
        $im -> readImage($pdf);
        $im->setCompressionQuality(1);
        $seq = 0;
        foreach ($im as $k => $v) {
            $v->setImageFormat('png');
            $fileName = $path . ++$seq . '.png';
            if ($v->writeImage($fileName) == true) {
//                $imgBasePath[] = $this -> imgToBase64($fileName);
                $imgPath[] = $fileName;
            }
        }
        return $imgPath;
    }

    public function imgToBase64($imgPath)
    {
        if( file_exists($imgPath) ) {
            if($fp = fopen($imgPath,"rb", 0))
            {
                $gambar = fread($fp,filesize($imgPath));
                fclose($fp);
                $base64 = chunk_split(base64_encode($gambar));
                return $base64;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
}