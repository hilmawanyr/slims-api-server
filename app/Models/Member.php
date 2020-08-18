<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model
{
    protected $table = 'member';

    public static function allMember(int $rows, int $offset) : object
    {
		$members = DB::table('member as mem')
						->selectRaw('
							mem.member_id, 
							mem.member_name, 
							mem.gender as gender_code, 
							IF(mem.gender = 1, "MALE", "FEMALE") as gender,
							mem.member_type_id,
							mty.member_type_name,
							mem.member_address,
							mem.inst_name as institution,
							mem.member_image,
							mem.pin,
							mem.member_phone,
							mem.member_since_date,
							mem.register_date,
							mem.expire_date')
						->join('mst_member_type as mty', 'mem.member_type_id', '=', 'mty.member_type_id')
						->offset($offset)
						->limit($rows)
						->get();
		return $members;
    }

    public static function getMember(string $id) : object
    {
    	$members = DB::table('member as mem')
						->selectRaw('
							mem.member_id, 
							mem.member_name, 
							mem.gender as gender_code, 
							IF(mem.gender = 1, "MALE", "FEMALE") as gender,
							mem.member_type_id,
							mty.member_type_name,
							mem.member_address,
							mem.inst_name as institution,
							mem.member_image,
							mem.pin,
							mem.member_phone,
							mem.member_since_date,
							mem.register_date,
							mem.expire_date')
						->join('mst_member_type as mty', 'mem.member_type_id', '=', 'mty.member_type_id')
						->where('mem.member_id', '=', $id)
						->get();
		return $members;
    }

    public static function memberByType(int $type, int $rows, int $offset) : object
    {
    	$members = DB::table('member as mem')
						->selectRaw('
							mem.member_id, 
							mem.member_name, 
							mem.gender as gender_code, 
							IF(mem.gender = 1, "MALE", "FEMALE") as gender,
							mem.member_type_id,
							mty.member_type_name,
							mem.member_address,
							mem.inst_name as institution,
							mem.member_image,
							mem.pin,
							mem.member_phone,
							mem.member_since_date,
							mem.register_date,
							mem.expire_date')
						->join('mst_member_type as mty', 'mem.member_type_id', '=', 'mty.member_type_id')
						->where('mem.member_type_id', '=', $type)
						->offset($offset)
						->limit($rows)
						->get();
		return $members;
    }
}
