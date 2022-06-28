<?php


namespace Jason\Common\Cache;


use Illuminate\Support\Facades\Redis;

class GroupMall extends Cache
{
    static $connection = 'gm_public';
}