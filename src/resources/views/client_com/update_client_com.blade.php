@extends('layouts.dashboard.index')
{{-- @section('page_heading','Add Role') --}}
@section('section')
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-5 col-sm-offset-3">
            @if(count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        @foreach($errors->all() as $error)
                          <li><span>{{ $error }}</span></li>
                        @endforeach
                    </div>
            @endif

            @if(Session::has('company_creation'))
                @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('company_creation') ))
            @endif
            

            <form role="form" action="{{ Route('client_com_update_action') }}/{{ $clientCom->user_id }}" method="post">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="form-group">
                    <input class="form-control input_required" type="text" name="name" value="{{ $clientCom->first_name }}" placeholder="{{ trans('others.company_name_label') }}"  >
                </div>
                <div class="form-group">
                    <input class="form-control input_required" type="text" name="address" value="{{ $clientCom->address }}" placeholder="{{ trans('others.company_address_label') }}"  >
                </div>
                <div class="form-group">
                    <input class="form-control input_required" type="email" value="{{ $clientCom->email }}" placeholder="{{ trans('others.enter_email_address') }}" disabled>
                </div>
                <div class="form-group">
                    <input class="form-control input_required" type="text" name="phone" value="{{ $clientCom->phone_no }}" placeholder="{{ trans('others.company_phone_number_label') }}"  >
                </div>
                <div class="form-group">
                    <select class="form-control input_required" name="is_active" >
                        <option value="0">{{ trans('others.action_inactive_label') }}</option>
                        <option @if($clientCom->is_active == 1) {{ 'selected' }} @endif value="1">{{ trans('others.action_active_label') }}</option>
                    </select>
                </div>
                <input type="hidden" name="group_id" value="{{ $request->session()->get('group_id') }}">


                @if(count($companies)>1)
                    <div class="form-group">
                        <select class="form-control input_required" name="company_id" >
                            <option value="">{{ trans('others.select_company_option_label') }}</option>
                            @foreach($companies as $company)
                                <option @if($company->id == $clientCom->company_id) {{ 'selected' }} @endif value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                @else

                    @foreach($companies as $company)
                                <div class="form-group">
                                    <select class="form-control input_required" name="company_id" disabled>
                                        {{-- <option value="">Select Role</option> --}}
                                        @foreach($companies as $company)
                                            <option selected value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                    @endforeach
                    
                @endif

                


                <div class="form-group">
                    <input class="form-control btn btn-primary btn-outline" type="submit" value="{{ trans('others.update_company_button') }}" >
                </div>
            </form>
        </div>
    </div>
</div>
            
@stop
