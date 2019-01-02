<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Message\StatusMessage;
use App\Model\MxpClientCompany;
use App\MxpCompany;
use Illuminate\Http\Request;
use Validator;

class ClientController extends Controller
{

    public function clientComList(Request $request)
    {

        $clients = MxpClientCompany::get()->where('type', 'client_com')->where('group_id', $request->session()->get('group_id'));

        $mxpCompanies = MxpCompany::get()->where('group_id', '=', $request->session()->get('group_id'));


        return view('client_com.client_com_list', ['clients' => $clients, 'mxpCompanies' => $mxpCompanies]);
    }

    public function createClientComForm(Request $request)
    {

        if ($request->session()->get('user_type') == 'super_admin') {
            $companies = MxpCompany::get()->where('group_id', $request->session()->get('group_id'));
        } else if ($request->session()->get('user_type') == 'company_user') {
            $companies = MxpCompany::get()->where('id', $request->session()->get('company_id'));
        }
       
        return view('client_com.add_client_com', ['companies' => $companies, 'request' => $request]);
    }

    public function createClientCom(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'email'      => 'required|email|unique:mxp_users',
            // 'phone'      => 'required',
            'address'    => 'required',
            'is_active'  => 'required',
            'group_id'   => 'required',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
        }

        $com             = new MxpClientCompany();
        $com->first_name = $request->name;
        $com->type       = 'client_com';
        $com->email      = $request->email;
        $com->phone_no   = $request->phone;
        $com->address    = $request->address;
        $com->is_active  = $request->is_active;
        $com->group_id   = $request->group_id;
        $com->company_id = $request->company_id;
        $com->save();

        StatusMessage::create('client_company_added', 'New Client/Company Added Successfully');
        return Redirect()->Route('client_com_list_view');

    }

    public function updateClientComForm(Request $request)
    {

        $clientCom = MxpClientCompany::whereUser_id($request->id)->first();

        if ($request->session()->get('user_type') == 'super_admin') {
            $companies = MxpCompany::get()->where('group_id', $request->session()->get('group_id'));
        } else if ($request->session()->get('user_type') == 'company_user') {
            $companies = MxpCompany::get()->where('id', $request->session()->get('company_id'));
        }

        return view('client_com.update_client_com', ['clientCom' => $clientCom, 'companies' => $companies, 'request' => $request]);
    }

    public function updateClientCom(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'       => 'required',
            'phone'      => 'required',
            'address'    => 'required',
            'is_active'  => 'required',
            'group_id'   => 'required',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator->messages());
        }

        $com             = MxpClientCompany::find($request->id);
        $com->first_name = $request->name;
        $com->phone_no   = $request->phone;
        $com->address    = $request->address;
        $com->is_active  = $request->is_active;
        $com->company_id = $request->company_id;
        $com->save();

        StatusMessage::create('client_company_status', 'New Client/Company Updated Successfully');
        return Redirect()->Route('client_com_list_view');

    }

    public function deleteClientCom(Request $request)
    {

        $com             = MxpClientCompany::find($request->id);
        $com->delete();

        StatusMessage::create('client_company_status', 'New Client/Company Updated Successfully');
        return Redirect()->Route('client_com_list_view');
    }

    public function addUrgentClientAction(Request $request)
    {              
        $com             = new MxpClientCompany();
        $com->first_name = $request->name;
        $com->type       = 'client_com';
        $com->email      = $request->email;
        $com->phone_no   = $request->phone;
        $com->address    = $request->address;
        $com->is_active  = $request->is_active;
        $com->group_id   = $request->group_id;
        $com->company_id = $request->company_id;
        $com->save();


        $clients = MxpClientCompany::get()->where('type', '=', 'client_com')->where('group_id', '=', $request->group_id);
        $selectForClient = '<select class="form-control input_required" name="client" id="client" class="client">
                                <option value="">Select Client</option>
                                <option value="-1" data-toggle="modal" data-target="#myModal">Create new Client</option>';
        foreach($clients as $client)
        {
            $selectForClient .= '<option value="'.$client->user_id.'"> '.$client->first_name.' </option>';
        }
        $selectForClient .= '</select>';
        print_r($selectForClient);
    }
}


