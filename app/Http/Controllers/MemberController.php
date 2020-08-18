<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;


class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return members with limit 25 rows
     * 
     * @param [Illuminate\Http\Request] $request
     * @return [array]
     */
    public function index(Request $request) : array
    {
        $rows = $request->input('rows') ? $request->input('rows') : 25;
        $page = $request->input('page') ? ($request->input('page') == 1 ? 0 : $request->input('page')) : 0;

        $members = Member::allMember($rows, $page);

        $response['code']       = '1';
        $response['status']     = 'request success';
        $response['message']    = 'successfully return random member';
        $response['total_rows'] = $members->count();
        $response['data']       = $members;

        return $response;
    }

    /**
     * Get spesific member by their ID
     * 
     * @param [string] $id
     * @return [array]
     */
    public function getSpesificMember(string $id) : array
    {
        $member = Member::getMember($id);

        if ($member->count() == 0) {
            $response['code']       = '23';
            $response['status']     = 'empty response';
            $response['message']    = 'data you are search is not found';

        } else {
            $response['code']       = '1';
            $response['status']     = 'request success';
            $response['message']    = 'successfully return requested data';
            $response['data']       = $member;
        }  
        
        return $response;
    }

    /**
     * Get members by their member type
     * 
     * @param [Illuminate\Http\Request] $request
     * @param [int] $type
     * @return [array]
     */
    public function getMemberByType(Request $request, int $typeID) : array
    {
        $rows = $request->input('rows') ? $request->input('rows') : 25;
        $page = $request->input('page') ? ($request->input('page') == 1 ? 0 : $request->input('page')) : 0;

        $member = Member::memberByType($typeID, $rows, $page);

        if ($member->count() == 0) {
            $response['code']       = '23';
            $response['status']     = 'empty response';
            $response['message']    = 'data you are search is not found';

        } else {
            $response['code']       = '1';
            $response['status']     = 'request success';
            $response['message']    = 'successfully return requested data';
            $response['data']       = $member;
        }  
        
        return $response;
    }
}
