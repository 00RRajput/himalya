<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait BaseTrait
{
    public $district_id;

    function getState($table, $select, $where)
    {
        $record =  DB::table($table)->select($select)->where($where)->first();
        if (is_null($record)) {
            return  DB::table($table)->insertGetId($where);
        } else {
            return $record->$select;
        }
    }

    function getDistrict($fld_district, $fld_state_id)
    {

        $record =  DB::table('x_districts')->where('fld_district', $fld_district)->first();
        if (is_null($record)) {
            return   DB::table('x_districts')->insertGetId([
                'fld_state_id' => $fld_state_id,
                'fld_district' => $fld_district,
                "fld_status" => 1,
            ]);
        } else {
            $this->district_id = $record->fld_did;
            return $record->fld_did;
        }
    }

    function getTownId($fld_town, $fld_state_id)
    {
        $record =  DB::table('x_towns')->where('fld_town', $fld_town)->first();
       
        if (is_null($record)) {
            return   DB::table('x_towns')->insertGetId([
                'fld_state_id' => $fld_state_id,
                'fld_district_id' =>$this->district_id,
                'fld_town' => $fld_town,
                "fld_status" => 1,
            ]);
        } else {
            // $this->district_id = $record->fld_tid;
            return $record->fld_tid;
        }
    }

    function getMandiId($mandiName, $sid, $tid){
        $record =  DB::table('x_mandis')->where('fld_mandi', $mandiName)->first();
       
        if (is_null($record)) {
            return DB::table('x_mandis')->insertGetId([
                'fld_state_id' => $sid,
                'fld_district_id' => $this->district_id,
                'fld_town_id' => $tid,
                'fld_mandi' => $mandiName
            ]);
        } else {
            // $this->district_id = $record->fld_mid;
            return $record->fld_mid;
        }
    }

    function getOutletId ($outletName, $pid, $userid, $sid, $did, $tid)
    {
        $record =  DB::table('recce_outlets')->where('fld_outlet', $outletName)->first();
       
        if (is_null($record)) {
            return DB::table('recce_outlets')->insertGetId([
                'fld_pid' => $pid,
                'fld_uid' => Auth::user()->fld_uid,
                'fld_state_id' => $sid,
                'fld_district_id' => $did,
                'fld_town_id' => $tid,
                'fld_outlet' => $outletName,
                'fld_direct_install'=> 1
            ]);
        } else {
            $this->district_id = $record->fld_district_id;
            return $record->fld_oid;
        }
    }

    function getWsId($wsName, $pid, $sid, $tid, $mId, $oId) {
        $record =  DB::table('mandi_wholesalers')->where('fld_wholesaler', $wsName)->first();
       
        if (is_null($record)) {
            return DB::table('mandi_wholesalers')->insertGetId([
                'fld_pid' => $pid,
                'fld_state_id' => $sid,
                // 'fld_district_id' => $this->district_id,
                'fld_town_id' => $tid,
                'fld_mandi_id' => $mId,
                'fld_outlet_id' => $oId,
                'fld_wholesaler'=> $wsName
            ]);
        } else {
            // $this->district_id = $record->fld_oid;
            return $record->fld_wsid;
        }
    }

    function getPrmId($wsName, $pid, $sid, $tid, $mId, $oId) {
        $record =  DB::table('mandi_wholesalers')->where('fld_wholealer', $wsName)->first();
       
        if (is_null($record)) {
            return DB::table('mandi_wholesalers')->insertGetId([
                'fld_pid' => $pid,
                'fld_state_id' => $sid,
                'fld_district_id' => $this->district_id,
                'fld_town_id' => $tid,
                'fld_mandi_id' => $mId,
                'fld_outlet_id' => $oId,
                'fld_wholealer'=> $wsName
            ]);
        } else {
            // $this->district_id = $record->fld_oid;
            return $record->fld_wsid;
        }
    }

    function getTehsilId($fld_tehsil, $insertData)
    {
        $record =  DB::table('x_tehsils')->select('fld_tid')->where(['fld_tehsil' => $fld_tehsil])->first();
        if (is_null($record)) {
            return  DB::table('x_tehsils')->insertGetId($insertData);
        } else {
            return $record->fld_tid;
        }
    }

    function getVillageId($fld_village, $insertData)
    {
        $record =  DB::table('x_villages')->select('fld_vid')->where(['fld_village' => $fld_village])->first();
        if (is_null($record)) {
            return  DB::table('x_villages')->insertGetId($insertData);
        } else {
            return $record->fld_vid;
        }
    }
    function getDBData($table, $select, $where)
    {
        $record =  DB::table($table)->select($select)->where($where)->first();
        if (is_null($record)) {
            return  DB::table($table)->insertGetId($where);
        } else {
            return $record->$select;
        }
    }

    /**
     * 2nd---> If same user has same project_id
     *  Then only update the state id and project id for that user on which table ---> user
     * else
     *  use -1 and 2 in the user name and insert that user in user table.
     */

    public function getUserDetails($username, $project_id, $sid, $row)
    {
        $user = $this->checkUserExist($username, $project_id);
        if (is_null($user)) {
            return $this->addNewUser($username, $sid, $project_id);
        } elseif ($user->fld_project_id == $project_id) {
            DB::table('users')->where('fld_uid', $user->fld_uid)->update(['fld_state_id' => $sid]);
            return ['fld_uid' => $user->fld_uid, 'username' => $user->fld_username];
        } else {
            // User Exist but not matching project id
            $newUserName  = $username . '-' . $user->total_same_username + $row;
            return $this->addNewUser($newUserName, $sid, $project_id);
        }
    }

    function checkUserExistForProject($username, $project_id)
    {
        return  DB::table('users')
            ->select('*', DB::raw('COUNT("fld_username") as total_same_username'))
            ->where('fld_username', $username)
            ->where('fld_pid', $project_id)
            ->groupBy('fld_username')->first();
    }
    function checkUserExist($username)
    {
        return  DB::table('users')
            ->select('*', DB::raw('COUNT("fld_username") as total_same_username'))
            ->where('fld_username', $username)
            ->groupBy('fld_username')->first();
    }

    function addNewUser($username, $sid, $project_id): array
    {
        $user_id = DB::table('users')->insertGetId([
            'fld_name' => $username,
            'fld_username' => $username,
            'fld_password' => Hash::make(123456),
            'fld_state_id' => $sid,
            'fld_project_id' => $project_id,
            'fld_role' => 2,
            'fld_status' => 1
        ]);
        return ['fld_uid' => $user_id, 'username' => $username];
    }
}
