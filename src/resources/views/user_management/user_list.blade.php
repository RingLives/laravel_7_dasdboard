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

    @if(Session::has('role_delete_msg'))
        @include('widgets.alert', array('class'=>'danger', 'message'=> Session::get('role_delete_msg') ))
    @endif
    @if(Session::has('role_update_msg'))
        @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('role_update_msg') ))
    @endif

    <div class="body">
        <div class="row clearfix">
            <div class="col-sm-12">
                <div class="card">
                    <div class="header">
                        <div class="input-group add-on">
                            <input class="form-control" placeholder="{{ trans('others.search_placeholder') }}" name="srch-term" id="user_search" type="text">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        @section ('cotable_panel_body')
                            <table class="table table-bordered" id="tblSearch">
                                <thead>
                                    {{-- <th>{{ trans('others.serial_no_label') }}</th>
                                    <th>{{ trans('others.employee_name_label') }}</th>
                                    <th>{{ trans('others.personal_phone_number_label') }}</th>
                                    <th>{{ trans('others.enter_email_address') }}</th>
                                    <th>{{ trans('others.mxp_menu_role') }}</th>
                                    <th>{{ trans('others.company_label') }}</th>
                                    <th>{{ trans('others.status_label') }}</th>
                                    <th>{{ trans('others.action_label') }}</th> --}}
                                    <th>a</th>
                                    <th>a</th>
                                    <th>a</th>
                                    <th>a</th>
                                    <th>a</th>
                                    <th>a</th>
                                    <th>a</th>
                                    <th>a</th>
                                </thead>
                                <tbody>                            
                                    <?php $i=1;  ?>
                                    @foreach($companyUser as $user)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $user->first_name }}</td>
                                            <td>{{ $user->phone_no }}</td>
                                            <td>{{ $user->email }}</td>
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
                                                <a class="delete_id" href="{{ Route('company_user_delete_action') }}/{{ $user->user_id }}" > @include('widgets.button', array('class'=>'danger', 'value'=>trans('others.delete_button'))) </a>
                                            </td>
                                        </tr>    
                                    @endforeach
                                </tbody>
                            </table>
                        @endsection
                        @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))
                    </div>
                </div>
            </div>
        </div>
    </div>            
@endsection
