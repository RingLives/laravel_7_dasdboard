@extends('layouts.dashboard.index')
@section('page_heading',trans('others.mxp_menu_company_list'))
@section('section')

<style type="text/css">
    .panel-heading{
        display: none;
    }
    .panel-body{
        padding: 0px;
    }
</style>

@if(Session::has('client_company_added'))
    @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('client_company_added') ))
@elseif(Session::has('client_company_status'))
    @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('client_company_status') ))
@endif


<div class="create_form_btn" style="margin-bottom: 20px;">
    <a href="{{ Route('client_com_add_view') }}">
        <button class="btn btn-success">{{ trans('others.add_company_label') }}</button>
    </a>
</div>


<div class="col-sm-12">
    <div class="row">
        

        @section ('cotable_panel_body')

            @if(Session::has('role_delete_msg'))
                @include('widgets.alert', array('class'=>'danger', 'message'=> Session::get('role_delete_msg') ))
            @endif
            @if(Session::has('role_update_msg'))
                @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('role_update_msg') ))
            @endif
            @if(Session::has('company_delete'))
                @include('widgets.alert', array('class'=>'danger', 'message'=> Session::get('company_delete') ))
            @endif

            
            <div class="input-group add-on">
              <input class="form-control" placeholder="{{trans('others.search_placeholder')}}" name="srch-term" id="user_search" type="text">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
            <br>
    
            

            
            <table class="table table-bordered" id="tblSearch">
                <thead>
                    <tr>
                        <th class="">{{ trans('others.serial_no_label') }}</th>
                        <th class="">{{ trans('others.company_name_label') }}</th>
                        <th class="">{{ trans('others.enter_email_address') }}</th>
                        <th class="">{{ trans('others.company_phone_number_label') }}</th>
                        <th class="">{{ trans('others.company_label') }}</th>
                        <th class="">{{ trans('others.status_label') }}</th>
                        <th class="">{{ trans('others.action_label') }}</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1;  ?>
                    @foreach($clients as $client)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $client->first_name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone_no }}</td>
                                <td>
                                    @foreach($mxpCompanies as $company)
                                            @if($company->id == $client->company_id)
                                                {{ $company->name }}
                                            @endif
                                    @endforeach
                                </td>
                                
                                <td>
                                    @if($client->is_active == '1')
                                        {{ trans('others.action_active_label') }}
                                    @else
                                        {{ trans('others.action_inactive_label') }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ Route('client_com_update_view') }}/{{ $client->user_id }}"> @include('widgets.button', array('class'=>'success', 'value'=>trans('others.edit_button'))) </a>
                                    <a class="delete_id" href="{{ Route('client_com_delete_action') }}/{{ $client->user_id }}" > @include('widgets.button', array('class'=>'danger', 'value'=>trans('others.delete_button'))) </a>
                                </td>
                            </tr>    
                    @endforeach 
                </tbody>
            </table>    
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'cotable'))
    </div>
</div>
            
@stop
