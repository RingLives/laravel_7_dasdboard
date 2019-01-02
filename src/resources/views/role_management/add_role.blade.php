@extends('layouts.dashboard.index')
@section('page_heading',trans('others.mxp_menu_add_new_role'))
@section('section')
    <div class="row clearfix">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="card" >
                <div class="col-sm-5 col-sm-offset-3">
                
                    @if(count($errors) > 0)
                        <div class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $error)
                              <li><span>{{ $error }}</span></li><br>
                            @endforeach
                        </div>
                    @endif

                    @if(Session::has('new_role_create'))
                        @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('new_role_create') ))
                    @endif

                    <form role="form" action="{{ Route('add_role_action') }}" method="post">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}" required>

                        <div class="form-group input_required">
                            <select style="width:100%" name="company_ids[]" class="selections " multiple="multiple">
                                @foreach($companies as $company)
                                    <option value="">{{ trans('others.select_company_option_label')}}</option>
                                    <option value="{{ $company->id }}" placeholder="Select company" required>{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <input class="form-control input_required" type="text" name="role_name" value="{{ old('role_name') }}" placeholder="{{ trans('others.role_name_placeholder') }}" required>
                        </div>

                        <div class="form-group">
                            <select class="form-control input_required" name="is_active" required >
                                <option value="1">{{ trans('others.action_active_label') }}</option>
                                <option value="0">{{ trans('others.action_inactive_label') }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input class="form-control btn btn-primary btn-outline" type="submit" value="{{ trans('others.save_button') }}" >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // $(".selections").select2();
    </script>
@endsection
