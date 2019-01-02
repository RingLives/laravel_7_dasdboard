<?php

namespace App\Http\Controllers;

use App\Http\Controllers\dataget\ListGetController;
use App\Http\Controllers\Message\StatusMessage;
use App\Http\Controllers\RoleManagement;
use App\MxpCompany;
use App\MxpCompanyUser;
use App\buyer;
use App\userbuyer;
use Auth;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller {

	public function __construct(Request $request) {

	}

	public function createUserForm(Request $request) {

		$roleManage = new RoleManagement();

		$group_id = $request->session()->get('group_id');

		if ($request->session()->get('user_type') == "company_user") {
			$companyList = MxpCompany::get()->where('id', Auth::user()->company_id);
		} else {
			$companyList = MxpCompany::get()->where('group_id', $group_id);
		}
		// $buyers = buyer::all();
		$buyers = [];
		return view('user_management.create_user', compact('companyList','buyers'));

	}
	public function createUser(Request $request) {
		$roleManage = new RoleManagement();

		// Form InputValidation
		$messages = [
			'personal_name.required' => 'Person name Is required.',
			'company_id.required' => 'Company id Is required.',
			'role_id.required' => 'Role Is required.',
			'email.required' => 'Email Is required.',
			'email.unique' => 'Email Is already entered.',
			'password.required' => 'Password Is required.',
			'password.min:6' => 'Password minimum 6 character.',
			'password.confirmed' => 'Two Password Doesnot match.',
			'is_active.required' => 'Active filed required.'
		];
		$validator = Validator::make($request->all(), [
			'personal_name' => 'required',
			'company_id' => 'required',
			'role_id' => 'required',
			'email' => 'required|email|unique:mxp_users',
			'password' => 'required|confirmed|min:6',
			'is_active' => 'required',
		],$messages);
		if ($validator->fails()) {
			return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
		}

		$group_id = $request->session()->get('group_id');

		$validationError = $validator->messages();
		$createUser = new MxpCompanyUser();
		$createUser->first_name = $request->personal_name;
		$createUser->type = "company_user";
		// $createUser->group_id     = Auth::user()->user_id;
		$createUser->group_id = $group_id;
		$createUser->company_id = $request->company_id;
		$createUser->email = $request->email;
		$createUser->password = bcrypt($request->password);
		$createUser->phone_no = $request->personal_phone_number;
		$createUser->is_active = $request->is_active;
		$createUser->user_role_id = $request->role_id;
		$createUser->save();
		if(isset($createUser->user_id) && !empty($createUser->user_id)){
			userbuyer::where("id_user",$createUser->user_id)->delete();
			if(isset($request->id_buyer) && !empty($request->id_buyer)){
				foreach ($request->id_buyer as $idbuyer) {
					$userbuyer = new userbuyer();
					$userbuyer->id_buyer = $idbuyer;
					$userbuyer->id_user = $createUser->user_id;
					$userbuyer->save();
				}
			}
		}

		StatusMessage::create('new_user_create', 'New User Created Successfully');

		// return view('user_management.create_user', compact('roleList'));
		return Redirect()->Route('create_user_view');
	}

	public function userList(Request $request) {

		$companyUser = ListGetController::companyUserList($request);

		return view('user_management.user_list', compact('companyUser'));

	}

	public function updateUserForm(Request $request) {
		$roleManage = new RoleManagement();
		$roleList = ListGetController::activeRoleList();

		$companyUser = ListGetController::companyUser($request, $request->id);

		$selectedUser = $companyUser;
		$buyers = buyer::all();
		$userbuyerlist = userbuyer::where("id_user",$request->id)->get();
		$buyerSelectedList = [];
		if(isset($userbuyerlist) & !empty($userbuyerlist)){
			foreach ($userbuyerlist as $usrlist) {
			$buyerSelectedList[] = $usrlist->id_buyer;
			}
		}
		return view('user_management.update_user', compact('selectedUser', 'roleList', 'buyers', 'buyerSelectedList'));
	}
	public function updateUser(Request $request) {
		$messages = [
			'personal_name.required' => 'Person name Is required.',
			'company_id.required' => 'Company id Is required.',
			'role_id.required' => 'Role Is required.',
			'email.required' => 'Email Is required.',
			'email.unique' => 'Email Is already entered.',
			'password.required' => 'Password Is required.',
			'password.confirmed' => 'Two Password Doesnot match.',
			'password.min.string' => 'Password minimum 6 character.',
			'is_active.required' => 'Active filed required.'
		];
		if (!isset($request->password)) {
			$validator = Validator::make($request->all(), [
				'personal_name' => 'required',
				'email' => 'required|email',
				'personal_phone_number' => 'required',
				'is_active' => 'required',
			],$messages);
		} else if (isset($request->password)) {
			$validator = Validator::make($request->all(), [
				'personal_name' => 'required',
				'email' => 'required|email',
				'password' => 'required|string|min:6',
				'personal_phone_number' => 'required',
				'is_active' => 'required',
			],$messages);
		}

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator->messages());
		}

		$user_update = MxpCompanyUser::find($request->user_id);
		$user_update->first_name = $request->personal_name;
		$user_update->phone_no = $request->personal_phone_number;
		$user_update->email = $request->email;
		if (isset($request->password)) {
			$user_update->password = bcrypt($request->password);
		}
		$user_update->is_active = $request->is_active;
		$user_update->user_role_id = $request->roleId;
		$user_update->save();
		if(isset($request->user_id) && !empty($request->user_id)){
			userbuyer::where("id_user",$request->user_id)->delete();
			if(isset($request->id_buyer) && !empty($request->id_buyer)){
				foreach ($request->id_buyer as $idbuyer) {
					$userbuyer = new userbuyer();
					$userbuyer->id_buyer = $idbuyer;
					$userbuyer->id_user = $request->user_id;
					$userbuyer->save();
				}
			}
		}
		return redirect()->Route('user_list_view');
	}
	public function deleteUser(Request $request) {

		$user_update = MxpCompanyUser::find($request->id);
		$user_update->delete();
		return redirect()->Route('user_list_view');
	}

}
