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

class Water extends Command
{
    /**
    /apps/svr/php-7.1.20/bin/php /apps/data/web/working/university/think water 吴双 /tmp/pdf/ /tmp/wushuang/
    /usr/local/php/bin/php /www/university/think water 吴双 /tmp/pdf/ /tmp/wushuang/
    */
    protected function configure()
    {
        $this
            // 命令的名字（"think" 后面的部分）
            ->setName('water')
            // 配置一个参数
            ->addArgument('text', Argument::REQUIRED, 'Who like ThinkPHP ?')
            ->addArgument('imgSrc', Argument::REQUIRED, 'Who like ThinkPHP ?')
            ->addArgument('waterImgSrc', Argument::REQUIRED, 'Who like ThinkPHP ?')
            ->addArgument('last_name', Argument::OPTIONAL, 'Your last name?')
            // 运行 "php think list" 时的简短描述
            ->setDescription('Creates new users.')
            // 运行命令时使用 "--help" 选项时的完整命令描述
            ->setHelp("This command allows you to create users...");
    }

    protected function execute(Input $input, Output $output)
    {
        $startTime = time();
        $text = $input->getArgument('text');
        $imgSrc = $input->getArgument('imgSrc');
        $waterImgSrc = $input->getArgument('waterImgSrc');
        $imgLists = $this -> getImgPathByDirName($imgSrc);
        array_map(function($img) use ($text , $imgSrc , $waterImgSrc){
            $this -> RunWater2($imgSrc , $waterImgSrc , $img , __FONT__ . 'snow.ttf' , $text);
        } , $imgLists);
        $endTime = time();
        echo $endTime - $startTime;
    }

    public function getImgPathByDirName($dirName)
    {
        if(is_dir($dirName)) {
            $fileNames = scandir($dirName);
            $imgLists = [];
            foreach ($fileNames as $file) {
                if($file=="." || $file==".."){continue;}
                $imgLists[] = $file;
            }
            return $imgLists;
        } else {
            return [];
        }
    }

    public function RunWater2($path, $out_img, $file_name, $font, $water_text='demo', $over_flag=false, $font_size=14, $water_w=140,$water_h=140, $angle=-45) {
        if(!is_dir($out_img)) {
            mkdir($out_img , 0777 , true);
        }
        $arr_in_name = explode(".", $file_name);
        $out_img = $out_img . $arr_in_name[0].".".$arr_in_name[1];
        //检查文件和水印
        if ($file_name == "" || $water_text == "") return '文件名为空或者水印为空!';
        //检测是否安装GD库
        if (false == function_exists("gd_info")) return "系统没有安装GD库，不能给图片加水印.";
        //设置输入、输出图片路径名
        $in_img = $path.$file_name;
        //检测图片是否存在
        if (!file_exists($in_img)) return "图片不存在！";
        $info = getimagesize($in_img);
        //通过编号获取图像类型
        $type = image_type_to_extension($info[2],false);
        //在内存中创建和图像类型一样的图像
        $fun = "imagecreatefrom".$type;
        //图片复制到内存
        $image = $fun($in_img);
        //设置字体颜色和透明度
        $color = imagecolorallocatealpha($image, 148, 148, 148, 50);
        $x_length = $info[0];
        $y_length = $info[1];

        //铺满屏幕
        for ($x = 10; $x < $x_length; $x) {
            for ($y = 20; $y < $y_length; $y) {
                imagettftext($image, $font_size, $angle, $x, $y, $color, $font, $water_text);
                $y += $water_h;
            }
            $x += $water_w;
        }
        //浏览器输出 保存图片的时候 需要去掉
        //header("Content-type:".$info['mime']);
        $fun = "image".$type;
//        $fun($image);
        //保存图片
        $fun($image, $out_img);
        //销毁图片
        imagedestroy($image);
    }

}