<?php
/**
 * Created by PhpStorm.
 * User: demo
 * Date: 2020/9/28
 * Time: 16:16
 */

namespace app\index\validate;
use app\index\service\common\Params;
use library\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function run()
    {
        $allParams = Params::getAll();
        $results = $this -> batch(false) -> check($allParams);
        if ( $results )
        {
            return true;
        }
        else
        {
            $exception = new ParameterException($this -> getError() , $this -> code);
            throw $exception;
        }
    }

    public function vaildate($allParams)
    {
        $results = $this -> batch(false) -> check($allParams);
        if ( $results ) {
            return true;
        } else  {
            $exception = new ParameterException($this -> getError() , $this -> code);
            throw $exception;
        }
    }

    public function isNotEmpty($value , $rule , $data , $field)
    {
        return empty($value) ? false : true;
    }

    public function checkInt($value)
    {
        return strlen(intval($value)) === strlen($value) ?
            true : false;
    }

    public function timeStamp($value)
    {
        return strlen(($value)) == 13;
    }
}