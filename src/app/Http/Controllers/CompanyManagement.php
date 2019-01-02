<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MxpCompany;
use App\Http\Controllers\Message\StatusMessage;
use Auth;
use App\Http\Controllers\dataget\ListGetController;
use Validator;

class CompanyManagement extends Controller
{
    public function companyAccOpeningForm(){
    	return view('company.open_company');
    }

	public function openCompanyAcc(Request $request){

        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'address'            => 'required',
            'phone'                 => 'required',
            'is_active'             => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
        }

		$com = new MxpCompany();
    	$com->group_id = Auth::user()->user_id;
    	$com->name = $request->name;
    	$com->description = $request->description;
    	$com->address = $request->address;
    	$com->phone = $request->phone;
    	$com->is_active = $request->is_active;
    	$com->save();

    	StatusMessage::create('company_creation', 'New Company Account Created Successfully');
    	return Redirect()->back();
	}

	public function companyList(){
		  
        $companyList = MxpCompany::get()->where('group_id', Auth::user()->user_id);
        return view('company.company_list', compact('companyList'));
	}


    public function updateCompanyAccForm(Request $request){
        $company = ListGetController::getCompany($request->com_id);
        $company = $company[0];

        return view('company.company_update', ['company' => $company]);
    }
    public function updateCompanyAcc(Request $request){
        

        $validator = Validator::make($request->all(), [
            'name'         => 'required',
            'address'            => 'required',
            'phone'                 => 'required',
            'is_active'             => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
        }

        $companyUpdate = MxpCompany::find($request->com_id);
        $companyUpdate->name = $request->name;
        $companyUpdate->phone = $request->phone;
        $companyUpdate->address = $request->address;
        $companyUpdate->description = $request->description;
        $companyUpdate->is_active = $request->is_active;
        $companyUpdate->save();
        StatusMessage::create('company_update', "Company Info Updated Successfully");

        return redirect()->back();
    }
    public function deleteCompanyAcc(Request $request){
        $companyDelete = MxpCompany::find($request->com_id)->delete();

        StatusMessage::create('company_delete', "Company Info Deleted Successfully");
        return redirect()->back();   
    }
}
