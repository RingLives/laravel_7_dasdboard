@extends('layouts.dashboard.index')
@section('page_heading',trans('others.heading_role_permission_list_label'))
@section('section')
           
<div class="col-sm-12">
    <div class="row">
        {{-- <div class="col-sm-5 col-sm-offset-3"> --}}
        @if(Session::has('com_user_role_assign'))
            @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('com_user_role_assign') ))
        @endif
            <?php $tmpRoleId =  0; ?>
            @foreach($permissionList as $permission)
                
                @if($permission->role_id != $tmpRoleId)
                     <?php $tmpRoleId =  $permission->role_id; ?>
                    <form role="form" action="{{ Route('role_permission_update_view') }}" method="post">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div class="col-sm-12">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="roleId" value="{{ $permission->role_id }}" readonly>
                                    <span class="form-control"> {{ $permission->role_name }}</span>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <select class="form-control">
                                        <option value="">{{ trans('others.option_permitted_route_list_label') }}</option>
                                        @foreach($permissionList as $menu)
                                            @if($menu->role_id == $tmpRoleId)
                                                <option value="" disabled>{{ $menu->menu_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-sm-2">
                                <input class="form-control btn btn-primary btn-outline" type="submit" value="UPDATE" >
                            </div>

                        </div>    
                    </form>
                @endif

               

            @endforeach
        {{-- </div> --}}
    </div>
</div>
            
@stop
