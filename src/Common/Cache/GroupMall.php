<?php


namespace Jason\Common\Cache;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Jason\Utils\Tools;

class GroupMall extends Cache
{
    public static $redisConnection = 'gm_public';

    public static $dbConnection = 'crm_public';

    public static function getGroupById(string $id): array
    {
        $key = "group:$id";
        if ($cache = (array)parent::get($key)) {
            return $cache;
        }

        self::getAllGroup();

        return (array)parent::get($key);
    }

    public static function getGroupByCode(int $code): array
    {
        $key = "group:$code";
        if ($cache = (array)parent::get($key)) {
            return $cache;
        }

        self::getAllGroup();

        return (array)parent::get($key);
    }

    public static function getAllGroup(): array
    {
        $key = 'group:list';
        if (!$cache = (array)parent::get($key)) {
            $list = [];
            $connection = self::$dbConnection;
            $groupCollection = DB::connection($connection)->table('GM_group')->orderBy(DB::raw('code + 0'))->get();
            foreach ($groupCollection as $group) {
                $id = $group->id;
                $code = $group->code;
                $format = [
                    'id'                 => $group->id,
                    'code'               => $group->code,
                    'name'               => $group->name,
                    'logoUrl'            => $group->logo_url,
                    'introduction'       => $group->introduction,
                    'contactName'        => $group->contact_name,
                    'contactPhone'       => $group->contact_phone,
                    'customCrmType'      => $group->custom_crm_type,
                    'bonusName'          => $group->bonus_name,
                    'status'             => $group->status,
                    'created_at'         => (string)$group->created_at,
                    'updated_at'         => (string)$group->updated_at,
                    'customCrmTypeHuman' => '',
                ];
                $list[] = $format;

                parent::put("group:$id", $format);
                parent::put("group:$code", $format);
            }
            if ($list) {
                parent::put($key, $list);

                return $list;
            }
        }

        return $cache;
    }

    public static function getMallById(string $id): array
    {
        $key = "mall:$id";
        if ($cache = (array)parent::get($key)) {
            return $cache;
        }

        self::getAllMall();

        return (array)parent::get($key);
    }

    public static function getMallByCode(int $code): array
    {
        $key = "mall:$code";
        if ($cache = (array)parent::get($key)) {
            return $cache;
        }

        self::getAllMall();

        return (array)parent::get($key);
    }

    public static function getAllMall(): array
    {
        $key = 'mall:list';
        if (!$cache = (array)parent::get($key)) {
            $list = [];
            $connection = self::$dbConnection;
            $mallCollection = DB::connection($connection)->table('GM_mall')->orderBy(DB::raw('code + 0'))->get();
            $allGroup = self::getAllGroup();
            $groupIdCodeMap = Arr::pluck($allGroup, 'code', 'id');
            $groupIdNameMap = Arr::pluck($allGroup, 'name', 'id');
            foreach ($mallCollection as $mall) {
                $id = $mall->id;
                $code = $mall->code;
                $systemConfig = json_decode($mall->system_config ?: '', true);
                $groupId = $mall->group_id;
                $format = [
                    'id'           => $id,
                    'groupId'      => $groupId,
                    'code'         => $code,
                    'offlineCode'  => $mall->offline_code,
                    'logo'         => $mall->logo,
                    'name'         => $mall->name,
                    'province'     => $mall->province,
                    'city'         => $mall->city,
                    'district'     => $mall->district,
                    'region'       => $mall->region,
                    'longitude'    => $mall->longitude,
                    'latitude'     => $mall->latitude,
                    'address'      => $mall->address,
                    'servicePhone' => $mall->service_phone,
                    'contactName'  => $mall->contact_name,
                    'contactPhone' => $mall->contact_phone,
                    'systemConfig' => $systemConfig ? Tools::camelNull2str($systemConfig) : [],
                    'status'       => $mall->status,
                    'created_at'   => (string)$mall->created_at,
                    'updated_at'   => (string)$mall->updated_at,
                    'Group'        => [
                        'name' => $groupIdNameMap[$groupId] ?? '',
                        'code' => $groupIdCodeMap[$groupId] ?? 0,
                    ],
                ];
                $list[] = $format;

                parent::put("mall:$id", $format);
                parent::put("mall:$code", $format);
            }
            if ($list) {
                parent::put($key, $list);

                return $list;
            }
        }

        return $cache;
    }
}