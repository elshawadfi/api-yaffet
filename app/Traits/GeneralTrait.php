<?php

namespace App\Traits ;

trait GeneralTrait
{
    public function getCurrentlang()
    {
        return app()->getLocale();
    }

    public function returnError($errNum,$msg)
    {
        return response()->json([
            'status' => false ,
            'errNum' => $errNum ,
            'msg' => $msg
        ]);
    }

    public function returnSuccessMessage($msg,$errNum)
    {
        return [
            'status' => true ,
            'errNum' => $errNum ,
            'msg' => $msg
        ];
    }

    public function returnData($key,$value,$msg,$errNum)
    {
        return response()->json([
            'status' => true ,
            'errNum' => $errNum ,
            'msg' => $msg ,
			'metal_name'=>$key,
            'data' => $value
        ]);
    }

    public function return3Data($key1,$value1,$key2,$value2,$key3,$value3)
    {
        return response()->json([
            $key1 => $value1 ,
            $key2 => $value2 ,
            $key3 => $value3 ,
        ]);
    }

    public function returntoken($token,$value,$id,$valueId,$msg,$errNum)
    {
        return response()->json([
            'status' => true ,
            'errNum' => $errNum ,
            'msg' => $msg ,
            $token => $value,
            $id =>$valueId
        ]);
    }


    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }

    public function getErrorCode($input)
    {
        if($input == "name")
        {
            return "E0011" ;
        }
        elseif($input == "password")
        {
            return "E002" ;
        }
        elseif($input == "mobile")
        {
            return "E003" ;
        }
        elseif($input == "email")
        {
            return "E004" ;
        }
        else
        {
            return "E005";
        }
    }

    public function returnValidationError($code = "E001",$validator)
    {
        return $this->returnError($code,$validator->errors()->first());
    }
}
