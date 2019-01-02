@extends('layouts.dashboard.index')
@section('page_heading',trans('others.heading_user_list_label'))
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
              <input class="form-control" placeholder="Search{{ trans('others.search_placeholder') }}" name="srch-term" id="user_search" type="text">
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
                        <th class="">{{ trans('others.company_phone_number_label') }}</th>
                        <th class="">{{ trans('others.company_description_label') }}</th>
                        <th class="">{{ trans('others.company_address_label') }}</th>
                        <th class="">{{ trans('others.status_label') }}</th>
                        <th class="">{{ trans('others.action_label') }}</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php $i=1;  ?>
                    @foreach($companyList as $company)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $company->name }}</td>
                                <td>{{ $company->phone }}</td>
                                <td>{{ $company->description }}</td>
                                <td>{{ $company->address }}</td>
                                
                                <td>
                                    @if($company->is_active == '1')
                                        {{ trans('others.action_active_label') }}
                                    @else
                                        {{ trans('others.action_inactive_label') }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ Route('update_company_acc_view') }}/{{ $company->id }}"> @include('widgets.button', array('class'=>'success', 'value'=>trans('others.edit_button'))) </a>
                                    <a class="delete_id" href="{{ Route('delete_company_acc_action') }}/{{ $company->id }}" > @include('widgets.button', array('class'=>'danger', 'value'=>trans('others.delete_button'))) </a>
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
