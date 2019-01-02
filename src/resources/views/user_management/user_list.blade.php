@extends('layouts.dashboard.index')
@section('page_heading',trans('others.mxp_menu_user_list'))
@section('section')

<style type="text/css">
    .panel-heading{
        display: none;
    }
    .panel-body{
        padding: 0px;
    }
</style>

<div class="col-sm-12">
    <div class="row">
        {{-- <div class="col-sm-12"> --}}
            {{-- @section ('cotable_panel_title','List of Responsible people') --}}
            <div class="input-group add-on">
              <input class="form-control" placeholder="{{ trans('others.search_placeholder') }}" name="srch-term" id="user_search" type="text">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
            <br>

            @section ('cotable_panel_body')

            @if(Session::has('role_delete_msg'))
                @include('widgets.alert', array('class'=>'danger', 'message'=> Session::get('role_delete_msg') ))
            @endif
            @if(Session::has('role_update_msg'))
                @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('role_update_msg') ))
            @endif

            
            <table class="table table-bordered" id="tblSearch">
                <thead>
                    <tr>
                        <th class="">{{ trans('others.serial_no_label') }}</th>
                        {{-- <th class="col-sm-1">ID</th> --}}
                        <th class="">{{ trans('others.employee_name_label') }}</th>
                        <th class="">{{ trans('others.personal_phone_number_label') }}</th>
                        <th class="">{{ trans('others.enter_email_address') }}</th>
                        <th class="">{{ trans('others.mxp_menu_role') }}</th>
                        <th class="">{{ trans('others.company_label') }}</th>
                        <th class="">{{ trans('others.status_label') }}</th>
                        <th class="">{{ trans('others.action_label') }}</th>
                </thead>
                <tbody>
                    
                    <?php $i=1;  ?>
                    @foreach($companyUser as $user)
                            <tr>
                                <td>{{ $i++ }}</td>
                                {{-- <td>{{ $user->id }}</td> --}}
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->phone_no }}</td>
                                <td>{{ $user->email }}</td>{{-- 
                                <td>{{ $user->company_name }}</td>
                                <td>{{ $user->company_phone }}</td>
                                <td>{{ $user->company_address }}</td> --}}
                                <td>{{ $user->role_name }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @if($user->active_user == '1')
                                        {{ trans('others.action_active_label') }}
                                    @else
                                        {{ trans('others.action_inactive_label') }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ Route('company_user_update_view') }}/{{ $user->user_id }}"> @include('widgets.button', array('class'=>'success', 'value'=>trans('others.edit_button'))) </a>
                                    {{-- <a onclick="userDeleteConfirmation('{{ Route('company_user_delete_action') }}/{{ $user->user_id }}')" href="{{ Route('company_user_delete_action') }}/{{ $user->user_id }}"> @include('widgets.button', array('class'=>'danger', 'value'=>'Delete&nbsp;')) </a> --}}
                                    <a class="delete_id" href="{{ Route('company_user_delete_action') }}/{{ $user->user_id }}" {{-- href="{{ Route('company_user_delete_action') }}/{{ $user->user_id }}" --}}> @include('widgets.button', array('class'=>'danger', 'value'=>trans('others.delete_button'))) </a>
                                </td>
                            </tr>    
                    @endforeach 
                    
                    
                </tbody>
            </table>    
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))
        {{-- </div> --}}
    </div>
</div>
            
@stop
