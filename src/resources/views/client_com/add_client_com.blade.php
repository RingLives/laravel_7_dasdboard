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
            

            <form role="form" action="{{ Route('client_com_add_action') }}" method="post">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <input class="form-control input_required" type="text" name="name" value="{{ old('name') }}" placeholder="{{ trans('others.company_name_label') }}"  >
                </div>
                <div class="form-group">
                    <input class="form-control input_required" type="email" name="email" value="{{ old('email') }}" placeholder="{{ trans('others.enter_email_address') }}"  >
                </div>
                <div class="form-group">
                    <input class="form-control input_required" type="text" name="phone" value="{{ old('phone') }}" placeholder="{{ trans('others.company_phone_number_label') }}"  >
                </div>
                <div class="form-group">
                    <input class="form-control input_required" type="text" name="address" value="{{ old('address') }}" placeholder="{{ trans('others.company_address_label') }}"  >
                </div>
               
                <div class="form-group">
                    <select class="form-control input_required" name="is_active" >
                        <option value="1">{{ trans('others.action_active_label') }}</option>   
                        <option value="0">{{ trans('others.action_inactive_label') }}</option>
                    </select>
                </div>
                <input type="hidden" name="group_id" value="{{ $request->session()->get('group_id') }}">
                {{-- <input type="hidden" name="company_id" value="{{ $request->session()->get('company_id') }}"> --}}

                @if(count($companies)>1)
                    <div class="form-group">
                        <select class="form-control input_required" name="company_id" >
                            <option value="">{{ trans('others.select_company_option_label') }}</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                @else

                    @foreach($companies as $company)
                                {{-- <div class="form-group">
                                    <input class="form-control " type="text" name="company_id" value="{{ $company->id }}" placeholder="{{ $company->name }}" disabled>
                                </div> --}}
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
                    <input class="form-control btn btn-primary btn-outline" type="submit" value="{{ trans('others.add_company_label') }}" >
                </div>
            </form>
        </div>
    </div>
</div>
            
@stop
