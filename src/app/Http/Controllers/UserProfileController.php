<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\RoleManagement;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\MxpCompanyUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Message\StatusMessage;
use App\Http\Controllers\dataget\ListGetController;

class UserProfileController extends Controller
{
    public function profile(Request $request){

    	$roleManage = new RoleManagement();
        $roleList   = ListGetController::activeRoleList();

        $selectedUser = ListGetController::companyUser($request, Auth::user()->user_id);
        // echo '<pre>';
        // print_r($selectedUser);
        // die();
        return view('user_profile.profile', compact('selectedUser', 'roleList'));
    }

    public function profileUpdate(Request $request){

        $current_pass = Auth::user()->password;

        if(Hash::check($request->current_password, $current_pass)){
        	
        	$validator = Validator::make($request->all(), [
	        'personal_name'         => 'required',
            'password'              => 'required|confirmed|min:6',
            'personal_phone_number' => 'required',
	        ]);
	        

	        if ($validator->fails()) {
	            return redirect()->back()->withErrors($validator->messages());
	        }

        	$user_update                  = MxpCompanyUser::find($request->user_id);
	        $user_update->first_name      = $request->personal_name;
	        $user_update->phone_no        = $request->personal_phone_number;
	        $user_update->password        = bcrypt($request->password);
	        $user_update->save();	
	        StatusMessage::create('profile_update', 'Your Profile updated successfully');

        }else{

    		$validator = Validator::make($request->all(), [
	        'personal_name'         => 'required',
	        'personal_phone_number' => 'required',
	        ]);
	        

	        if ($validator->fails()) {
	            return redirect()->back()->withErrors($validator->messages());
	        }

        	$user_update                  = MxpCompanyUser::find($request->user_id);
	        $user_update->first_name      = $request->personal_name;
	        $user_update->phone_no        = $request->personal_phone_number;
	        $user_update->save();	
	        StatusMessage::create('profile_update', 'Your Profile updated successfully');
        }
			


        return Redirect()->route('user_profile_view');

    }
}
