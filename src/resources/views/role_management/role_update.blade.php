@extends('layouts.dashboard.index')
@section('page_heading',trans('others.heading_update_role_label'))
@section('section')
           
<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-5 col-sm-offset-3">
            @if(count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        @foreach($errors->all() as $error)
                          <li><span>{{ $error }}</span></li><br>
                        @endforeach
                    </div>
            @endif


            
            <form role="form" action="{{ Route('role_update_action') }}/{{-- {{ $request->id }} --}}" method="post">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="cm_group_id" value="{{ $companysAllRoles[0]->cm_group_id }}">

                <div class="form-group">
                    <select style="width:100%" name="company_ids[]" class="selections" multiple="multiple">
                        <option value="">{{ trans('others.select_company_option_label')}}</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{(in_array($company->id, $onlyRoleCompanys)? 'selected':'')}}>{{$company->name}}</option>
                        @endforeach
                    </select>
                </div>


               


                <div class="form-group">
                    <input class="form-control" type="text" name="role_name" value="{{ $companysAllRoles[0]->roleName }}" placeholder="{{ $companysAllRoles[0]->roleName }}" required>
                </div>

                <div class="form-group">
                    <select class="form-control" name="is_active" required>
                        <option value="1" {{($companysAllRoles[0]->is_active == 1)? 'selected' : '' }}>{{ trans('others.action_active_label') }}</option>
                        <option value="0" {{($companysAllRoles[0]->is_active == 0)? 'selected' : '' }}>{{ trans('others.action_inactive_label') }}</option>
                </div>

                <div class="form-group">
                    <input class="form-control btn btn-primary btn-outline" type="submit" value="{{ trans('others.update_button') }}" >
                </div>
            </form>
        </div>
    </div>
</div>
   

<script type="text/javascript">
    $(".selections").select2();
</script>         
@stop
