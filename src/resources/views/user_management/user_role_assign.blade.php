@extends('layouts.dashboard.index')
@section('page_heading','Assign Role')
@section('section')
           
<div class="col-sm-12">
    <div class="row">

    @if(count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        @foreach($errors->all() as $error)
                          <li><span>{{ $error }}</span></li><br>
                        @endforeach
                    </div>
            @endif
        {{-- <div class="col-sm-5 col-sm-offset-3"> --}}
        @if(Session::has('com_user_role_assign'))
            @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('com_user_role_assign') ))
        @endif
            
            {{-- @foreach($companyUserList as $companyUser) --}}
                <form role="form" action="{{ Route('assign_role_action') }}" method="post">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <div class="col-sm-12">
                        <div class="col-sm-5">
                            <div class="form-group">
                                {{-- <input class="form-control" type="hidden" name="companyUserId" value="{{ $companyUser->user_id }}" readonly>
                                <input class="form-control" type="hidden" name="company_user_name" value="{{ $companyUser->first_name }}" readonly>
                                <span class="form-control"> {{ $companyUser->first_name }} of {{ $companyUser->company_name }} </span> --}}

                                

                                
                                <select class="form-control" name="companyUserId" required>
                                    <option value="">Select Role</option>
                                    @foreach($companyUserList as $companyUser)
                                        <option value="{{ $companyUser->user_id }}">{{ $companyUser->first_name }} of {{ $companyUser->company_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <select class="form-control" name="roleId" required>
                                    <option value="">Select Role</option>
                                    @foreach($roleList as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-sm-2">
                            <input class="form-control btn btn-primary btn-outline" type="submit" value="SET" >
                        </div>

                    </div>

                    
                </form>
            {{-- @endforeach --}}
        {{-- </div> --}}
    </div>
</div>
            
@stop
