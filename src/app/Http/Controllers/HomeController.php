<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\MxpTaskRole;
use App\userbuyer;
use App\Http\Controllers\Source\User\RoleDefine;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\IpCheckCOntroller;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		// $this->middleware('checkLocation');
	}
	
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		return redirect('/dashboard');
	}

	public function dashboard() {

		// IpCheckCOntroller::checkPermission();

		// $taskRoleData = array();
		// $user_role_id = session()->get('user_role_id');
		// if(isset($user_role_id) && !empty($user_role_id)){
		// 	$selectedTaskRole = DB::select('SELECT * FROM `mxp_task_role` WHERE `role_id` = '.$user_role_id);
		// 	if(isset($selectedTaskRole) && !empty($selectedTaskRole)){
		// 	    foreach ($selectedTaskRole as $srk => $srvalue) {
		// 	        if(isset($srvalue->task) && !empty($srvalue->task)){
		// 	            $taskRoleData = explode(",", $srvalue->task);
		// 	        }
		// 	    }
		// 	}
		// }
		// $taskAccessList = array();
		// if(isset($taskRoleData) && !empty($taskRoleData)){
		// 	foreach ($taskRoleData as $taskKey => $taskValue) {
		// 		$selectedTaskRole = DB::select('SELECT `name` FROM `mxp_task` WHERE `id_mxp_task` = '.$taskValue);
		// 		if(isset($selectedTaskRole[0]->name) && !empty($selectedTaskRole[0]->name)){
		// 			$taskAccessList[] = $selectedTaskRole[0]->name;
		// 		}
		// 	}
		// }

		$company_id = '';
		if (session()->get('user_id') == 1 && session()->get('user_type') == "super_admin") {
			$user_role_id = 1;
		} else {
			$user_role_id = session()->get('user_role_id');
		}
		$company_id = session()->get('company_id');

		$menus_array = array();
		if (isset($user_role_id)) {
			$menus = DB::select('call get_user_menu_by_role("' . $user_role_id . '","' . $company_id . '")');

			$i = 0;
			foreach ($menus as $key => $value) {

				$child_menu = DB::select('call get_child_menu_list("' . $value->menu_id . '","' . $user_role_id . '","' . $company_id . '")');
                    $lower=strtolower($value->name);
                    $final_key=str_replace(' ', '_', $lower);
                    $menu_trans=trans("others.mxp_menu_"."$final_key");
				if (!empty($child_menu)) {

					$menus_array[$i]['name'] = $menu_trans;
					$menus_array[$i]['route_name'] = $value->route_name;
					$menus_array[$i]['order_id'] = $value->order_id;
					$menus_array[$i]['menu_id'] = $value->menu_id;
					$j = 0;
					foreach ($child_menu as $cm) {
						$lower_sub=strtolower($cm->name);
                        $final_key_sub=str_replace(' ', '_', $lower_sub);
                        $menu_trans_sub=trans("others.mxp_menu_"."$final_key_sub");
						$menus_array[$i]['subMenu'][$j]['name'] = $menu_trans_sub;
						$menus_array[$i]['subMenu'][$j]['route_name'] = $cm->route_name;
						$menus_array[$i]['subMenu'][$j]['order_id'] = $cm->order_id;
						$menus_array[$i]['subMenu'][$j]['menu_id'] = $cm->menu_id;
						$j++;
					}
				} 
				$i++;
			}

		}
		session()->put('UserMenus', $menus_array);

		// $userbuyer = userbuyer::where("id_user",Auth::user()->user_id)->get();
		// $buyerList = [];
		// if(isset($userbuyer) && !empty($userbuyer)){
		// 	foreach ($userbuyer as $buyerusr) {
		// 		$buyerList[] = $buyerusr->id_buyer;
		// 	}
		// }

		// if(isset($buyerList) && !empty($buyerList)){
		// 	$selectBuyer = DB::table('mxp_party')->where('status',1)->whereIn('id_buyer',$buyerList)->get();
		// }else if(Auth::user()->type == 'super_admin'){
		// 	$selectBuyer = DB::table('mxp_party')->where('status',1)->get();
		// }else{
		// 	$selectBuyer = [];
		// }
		$user = Auth::user();

		// $notification = NotificationController::getAllNotification($status=1, $limit= 3);
		// var_dump("<pre>");var_dump($notification);die();
		// session()->put('notification', $notification);

		return view('layouts.dashboard_2.index',compact('user','notification'));
	}
}
