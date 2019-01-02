<?php

namespace App\Http\Controllers\dataget;

use App\Http\Controllers\Controller;
use App\Mxp_role;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListGetController extends Controller {
	public static function activeRoleList() {

		$roleList = Mxp_role::get()->where('is_active', '1');
		return $roleList;
	}

	public static function companyUserList(Request $request) {
		$group_id = $request->session()->get('group_id');

		if ($request->session()->get('user_type') == "super_admin") {
			$companyUser = DB::table('mxp_users')
				->select('mxp_users.is_active as active_user', 'mxp_users.*', 'mxp_role.name as role_name', 'mxp_companies.*')
				->leftjoin('mxp_companies', 'mxp_users.company_id', '=', 'mxp_companies.id')
				->leftjoin('mxp_role', 'mxp_role.id', '=', 'mxp_users.user_role_id')
				->get()
				->where('type', 'company_user')
				->where('group_id', $group_id)
				->sortByDesc("user_id");
		} else {
			$groupId = $group_id;

			$companyUser = DB::table('mxp_users')
				->select('mxp_users.is_active as active_user', 'mxp_users.*', 'mxp_role.name as role_name', 'mxp_companies.*')
				->leftjoin('mxp_companies', 'mxp_users.company_id', '=', 'mxp_companies.id')
				->leftjoin('mxp_role', 'mxp_role.id', '=', 'mxp_users.user_role_id')
				->get()
				->where('type', 'company_user')
				->where('group_id', $groupId)
				->sortByDesc("user_id");
		}

		return $companyUser;
	}

	public static function companyUser(Request $request, $id) {

		$companyUser = DB::table('mxp_users')
			->select('mxp_users.is_active as active_user', 'mxp_users.*', 'mxp_role.name', 'mxp_companies.*')
			->leftjoin('mxp_companies', 'mxp_users.company_id', '=', 'mxp_companies.id')
			->leftjoin('mxp_role', 'mxp_role.id', '=', 'mxp_users.user_role_id')
			->get()
			->where('user_id', $id)
			->first();

		return $companyUser;
	}

	public static function companyList() {

		$group_id = Auth::user()->user_id;
		$companies = DB::table('mxp_companies')
				->where([
					['group_id',$group_id],
					['is_active', '=', 1]
				])
				->get();

		return $companies;

	}

	public static function getCompany($com_id) {
		// return DB::select('call get_company_by_id("'.$com_id.'")');
		return DB::select('select * from mxp_companies where id=' . $com_id . ' and is_active = 1');
	}

}
