<?php

namespace Config;

use CodeIgniter\Config\BaseService;

class CheckSession extends \CodeIgniter\Config\BaseConfig
{
    public $expireTime = 3600; // 1 ชั่วโมง
}