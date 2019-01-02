@extends('layouts.dashboard.index')
@section('page_heading',trans('others.heading_role_assign_label'))
@section('section')
<div class="col-sm-12">
    <div class="row">

    @if(count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        @foreach($errors->all() as $error)
                          <li><span>{{ $error }}</span></li>
                        @endforeach
                    </div>
            @endif
        {{--
        <div class="col-sm-5 col-sm-offset-3">
            --}}
        @if(Session::has('com_user_role_assign'))
            @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('com_user_role_assign') ))
        @endif
            <form action="{{ Route('role_permission_action') }}" method="post" role="form">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="col-sm-12">
                        <div class="col-sm-5">
                            
                            <div class="form-group">
                                <select class="form-control input_required" name="companyId" id="companyId" >
                                   <option value="">{{ trans('others.select_company_option_label')}}</option>    
                                    
                                    @foreach($companyList as $company)
                                            
                                            <option value="{{ $company->id }}">
                                                {{ $company->name }}
                                            </option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control input_required" name="roleId" id="roleId" onchange="getPermission(this)"  disabled>
                                    <option value="">{{ trans('others.select_role_option_label')}}</option>
                                </select>
                            </div>

                           
                        </div>
                        <br><br>
                        <div class="all_checkbox col-sm-12" id="all_checkbox">
                            <div style="float: left; width: 100%; margin-bottom: 20px; ">
                                <a style="cursor: pointer;" id="selectAllcheckBox">{{ trans('others.select_all_label')}}</a><br>
                                <a style="cursor: pointer;" id="unselectAllcheckBox">{{ trans('others.unselect_all_label')}}</a>
                            </div>

                            @foreach($menuList as $menu)
                                    @if(
                                        {{-- $menu->route_name != 'create_user_action' && --}}
                                        {{-- $menu->route_name != 'create_user_view' && --}}
                                        $menu->route_name != 'company_user_update_view' &&
                                        $menu->route_name != 'add_role_action' &&
                                        $menu->route_name != 'add_role_view' &&
                                        $menu->route_name != 'add_role_action' &&
                                        $menu->route_name != 'role_delete_action' &&
                                        $menu->route_name != 'role_update_view' &&
                                        $menu->route_name != 'role_update_action' &&
                                        $menu->route_name != 'create_company_acc_view' &&
                                        $menu->route_name != 'create_company_acc_action' &&
                                        $menu->route_name != 'company_list_view' &&
                                        $menu->route_name != 'company_user_update_action' &&
                                        $menu->route_name != 'company_user_delete_action' &&
                                        $menu->route_name != 'role_permission_view' &&
                                        $menu->route_name != 'role_permission_action' &&
                                        $menu->route_name != 'role_permission_update_view')
                                        
                                        <div class="col-sm-4">
                                            <label>
                                                <input disabled class="single_check_box" id="{{ $menu->menu_id }}" name="menu_list[]" type="checkbox" value="{{ $menu->menu_id }}"
                                                @foreach($roleMenuList as $checkmenu)
                                                        @if($checkmenu->menu_id == $menu->menu_id)
                                                        {{ 'checked' }}
                                                        @endif
                                                @endforeach
                                                >
                                                    {{ $menu->name }}
                                                </input>
                                            </label>
                                        </div>

                                    @endif
                            @endforeach
                        </div>
                        <br><br><br>
                        <div class="form-group col-sm-2">
                            <input class="form-control btn btn-primary btn-outline" type="submit" value="{{ trans('others.set_button') }}">
                            </input>
                        </div>
                    </div>
                </input>
            </form>
            {{--
        </div>
        --}}
    </div>
</div>
@stop
