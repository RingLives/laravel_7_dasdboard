<?php

namespace App\Http\Controllers;

use App\Http\Controllers\dataget\ListGetController;
use App\Http\Controllers\Message\StatusMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\MxpUserRoleMenu;
use App\MxpCompanyUser;
use App\Mxp_role;
use App\MxpMenu;
use Validator;

class RoleManagement extends Controller
{   
   
    public function addRoleForm(Request $request){
        $companies = ListGetController::companyList($request);

        return view('role_management.add_role',['companies' => $companies]);
    }
    public function addRole(Request $request)
    {            
        $this->validate($request, [
            'company_ids'=> 'required|min:1',
            'role_name' => 'required|min:3',
            'is_active' => 'required|min:1|max:1'
            ]);

        $temp_group_id = self::getRandomGroupId();

        $this->saveRole($request, $temp_group_id);

        StatusMessage::create('new_role_create', 'New Role Created Successfully');
        $companies = ListGetController::companyList($request);

        return view('role_management.add_role',['companies' => $companies]);
    }

    private function saveRole(Request $request, $temp_group_id)
    {
        $company_ids   = $request->company_ids;
        $name      = $request->role_name;
        $is_active = $request->is_active;

        foreach ($company_ids as $company_id) {
            $role               = new Mxp_role();
            $role->name         = $name;
            $role->company_id   = $company_id;
            $role->cm_group_id  = $temp_group_id;
            $role->is_active    = $is_active;
            $role->save();
        }
    }


    public function roleList(Request $request)
    {

        $group_id = $request->session()->get('group_id');
        
        $roleList = DB::select('call get_all_role_list_by_group_id('.$group_id.')');

        return view('role_management.role_list', compact('roleList', 'roleList'));
    }

    public function deleteRole(Request $request)
    {

        $del = Mxp_role::find($request->id);
        $del->delete();

        $delUserRoleMenu = MxpUserRoleMenu::where('role_id', $request->id);
        $delUserRoleMenu->delete();
        
        StatusMessage::create('role_delete_msg', "Role ID " . $request->id . " is Deleted");

        return redirect()->Route('role_list_view');
    }

    public function updateForm(Request $request)
    {

        $super_admin_id = Auth::user()->user_id;
        $companies = ListGetController::companyList($request);

        $companysAllRoles = DB::select('call get_roles_by_company_id('.$super_admin_id.','.$request->id.')');

        $onlyRoleCompanys = [];
        foreach ($companysAllRoles as $role) {
            array_push($onlyRoleCompanys, $role->company_id);
        }

        return view('role_management.role_update', compact('companies', 'companysAllRoles', 'onlyRoleCompanys'));
    }

    public function updateRole(Request $request)
    {
        $this->validate($request, [
                'role_name' => 'required|min:3',
                'is_active' => 'required|min:1|max:1'
                ]);

        Mxp_role::where('cm_group_id' , $request->cm_group_id)->delete();

        // foreach ($request->company_ids as $companyId) {
        //     Mxp_role::where('cm_group_id' , $request->cm_group_id)->delete();
        // }

        $this->saveRole($request, $request->cm_group_id);

        StatusMessage::create('role_update_msg', "Role ID " . $request->id . " is Updated");

        return redirect()->Route('role_list_view');
    }
    

    public function rolePermissionForm(Request $request)
    {   

        $companyList = ListGetController::companyList();
        
        $menuList = MxpMenu::get()->sortBy('name');

        $roleMenuList = DB::table('mxp_user_role_menu')
                        ->where('role_id', $request->roleId)
                        ->select('menu_id')
                        ->get();
        

        if(isset($request->roleId)){
            $role_id_select = $request->roleId;
            return view('role_management.role_permission', compact('companyList', 'roleList', 'menuList', 'role_id_select', 'roleMenuList'));
        }

        return view('role_management.role_permission', compact('companyList',  'menuList', 'roleMenuList'));

    }

    public function rolePermissionList(){
        $permissionList = DB::table('mxp_user_role_menu')
                        ->leftJoin('mxp_role', 'mxp_role.id', '=', 'mxp_user_role_menu.role_id')
                        ->leftJoin('mxp_menu', 'mxp_menu.menu_id', '=', 'mxp_user_role_menu.menu_id')
                        ->select('mxp_user_role_menu.*', 'mxp_role.name as role_name', 'mxp_menu.name as menu_name')
                        ->get();
        return view('role_management.role_permission_list', compact('permissionList'));
    }  

    public function rolePermission(Request $request)
    {   

        $validator = Validator::make($request->all(), [
            'companyId'     => 'required',
            'roleId'         => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
        }


        $this->deleteMatchedRole($request->roleId);
        if(isset($request->menu_list)){
            for ($i = 0; $i < count($request->menu_list); $i++) {

                $setPermission            = new MxpUserRoleMenu();
                $setPermission->role_id   = $request->roleId;
                $setPermission->menu_id   = $request->menu_list[$i];
                $setPermission->company_id   = $request->companyId;
                $setPermission->is_active = "1";
                $setPermission->save();
            } 
        }
        return $this->rolePermissionForm($request);

    }

    public function getPermissions(Request $request){

        $roleMenuList = DB::table('mxp_user_role_menu')
                        ->where('role_id', $request->roleId)
                        ->select('menu_id')
                        ->get();
        $RMList = array();
        foreach ($roleMenuList as $list) {
            array_push($RMList, $list->menu_id);
        }

        $RMLcollection = collect($RMList);

        return $RMLcollection;

    }

    public function deleteMatchedRole($roleId)
    {
        $delete = MxpUserRoleMenu::where('role_id', $roleId);
        $delete->delete();
    } 
    
    public function getRoleList(Request $req){
        
        return json_encode(Mxp_role::get()->where('company_id', '=', $req->comId));
    }
}



 
