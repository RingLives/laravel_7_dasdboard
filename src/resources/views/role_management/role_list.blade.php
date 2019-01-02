@extends('layouts.dashboard.index')
@section('page_heading',trans('others.mxp_menu_role_list'))
@section('section')
           
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-12">
            @section ('cotable_panel_title',trans('others.list_of_responsible_person_label'))
            @section ('cotable_panel_body')

            @if(Session::has('role_delete_msg'))
                @include('widgets.alert', array('class'=>'danger', 'message'=> Session::get('role_delete_msg') ))
            @endif
            @if(Session::has('role_update_msg'))
                @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('role_update_msg') ))
            @endif



            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-sm-1">{{trans('others.serial_no_label')}}</th>
                        <th class="col-sm-4">{{trans('others.mxp_menu_role')}}</th>
                        <th class="col-sm-4">{{trans('others.company_name_label')}}</th>
                        <th class="col-sm-4">{{trans('others.status_label')}}</th>
                        <th class="col-sm-2">{{trans('others.action_label')}}</th> 
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1;  ?>
                    @foreach($roleList as $role)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->c_name }}</td>
                                <td>
                                    @if($role->is_active == '1')
                                        {{trans('others.action_active_label')}}
                                    @else
                                        {{trans('others.action_inactive_label')}}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ Route('role_update_action') }}/{{ $role->cm_group_id }}"> @include('widgets.button', array('class'=>'success', 'value'=>trans('others.update_button'))) </a>
                                    <a href="{{ Route('role_delete_action') }}/{{ $role->id }}"> @include('widgets.button', array('class'=>'danger', 'value'=>trans('others.delete_button'))) </a>
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
            
@stop
