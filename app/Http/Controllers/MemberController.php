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
     * @param {Request} $request
     * @return {array}
     */
    public function index(Request $request) : array
    {
        $rows = $request->input('rows') ? $request->input('rows') : 25;
        $page = $request->input('page') ? ($request->input('page') == 1 ? 0 : $request->input('page')) : 0;

        $members = Member::allMember($rows, $page);

        $response['code']       = '1';
        $response['status']     = 'request success';
        $response['message']    = 'successfully return random article';
        $response['total_rows'] = $members->count();
        $response['data']       = $members;

        return $response;
    }
}
