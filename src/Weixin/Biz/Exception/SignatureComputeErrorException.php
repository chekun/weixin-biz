<?php 

namespace Weixin\Biz\Exception;

use Exception;

class SignatureComputeErrorException 
{

    public functoon __construct()
    {
        parent::__construct('SHA签名失败', -40003);
    }

}