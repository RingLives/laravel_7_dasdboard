@extends('layouts.dashboard.index')
@section('page_heading','Set Task Access')
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

            @if(Session::has('new_taskrole_create'))
                @include('widgets.alert', array('class'=>'success', 'message'=> Session::get('new_taskrole_create') ))
            @endif

            <form role="form" action="{{ Route('permission_task_assign_action') }}" method="post">

                <input type="hidden" name="_token" value="{{ csrf_token() }}" required>

                @foreach($rolesList as $role)

					<div class="row">
						<div class="form-group">
							<label for="role_{{$role->id}}">Select Task For {{ $role->name }}</label>
							<div class="form-group">
							    <select class="form-control selections" name="task_{{ $role->id }}[]" multiple="true">
							    	@foreach($tasksList as $task)
							        	<option value="{{ $task->id_mxp_task }}" <?php 
                                    if(isset($taskRoleData[$role->id]) && !empty($taskRoleData[$role->id])){
                                        if(in_array($task->id_mxp_task, $taskRoleData[$role->id])){
                                            print 'selected="selected"';
                                        }
                                    }
                                    ?>>{{ $task->name }}</option>
							        @endforeach
							    </select>
							</div>
						</div>
					</div>

                @endforeach

                <div class="form-group">
                    <input class="task_role_btn form-control btn btn-primary btn-outline" type="submit" value="{{ trans('others.save_button') }}" >
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".selections").select2();
</script>
<style type="text/css">
    .task_role_btn{
        margin-top: 15px;
        margin-bottom: 80px;
    }
    .task_role_btn.btn-primary.btn-outline{
        color:#fff;
    }
</style>
@stop
