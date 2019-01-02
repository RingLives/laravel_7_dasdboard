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

            @if(Session::has('company_update'))
                @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('company_update') ))
            @endif

            <form role="form" action="{{ Route('update_company_acc_action') }}" method="post">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="com_id" value="{{ $company->id }}">


                <div class="form-group">
                    <input class="form-control input_required" type="text" name="name" value="{{ $company->name }}" placeholder="{{ trans('others.company_name_label') }}"  >
                </div>
                <div class="form-group">
                    <input class="form-control input_required" type="text" name="phone" value="{{ $company->phone }}" placeholder="{{ trans('others.company_phone_number_label') }}"  >
                </div>
                <div class="form-group">
                    <input class="form-control input_required" type="text" name="address" value="{{ $company->address }}" placeholder="{{ trans('others.company_address_label') }}"  >
                </div>
                <div class="form-group">
                    <input class="form-control " type="text" name="description" value="{{ $company->description }}" placeholder="{{ trans('others.company_description_label') }}"  >
                </div>
               
                <div class="form-group">
                    <select class="form-control input_required" name="is_active">
                        <option value="0">{{ trans('others.action_inactive_label') }}</option>
                        <option @if($company->is_active == 1) {{ 'selected' }} @endif value="1">{{ trans('others.action_active_label') }}</option>
                    </select>
                </div>

                {{-- <div class="form-group">
                    <select class="form-control input_required" name="role_id" >
                        <option value="">Select Role</option>
                        @foreach($roleList as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div> --}}


                <div class="form-group">
                    <input class="form-control btn btn-primary btn-outline" type="submit" value="{{ trans('others.update_button') }}" >
                </div>
            </form>
        </div>
    </div>
</div>
            
@stop
