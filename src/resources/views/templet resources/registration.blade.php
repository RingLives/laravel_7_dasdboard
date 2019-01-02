@extends ('layouts.plane')
@section ('body')
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
            <br /><br /><br />
               @section ('register_panel_title','Please Register if you didn\'t')
               @section ('register_panel_body')
                        <form role="form" action="">
                            <fieldset>
                                
                                <div class="form-group">
                                    <input class="form-control" placeholder="Group Name" name="group_name" type="text" value="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="ESTD" name="estd" type="text" value="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="text" value="">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Confirm Password" name="confirm_password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="{{ url ('dashboard') }}" class="btn btn-lg btn-success btn-block">Register</a>
                            </fieldset>
                        </form>
                    
                @endsection
                @include('widgets.panel', array('as'=>'register', 'header'=>true))
            </div>
        </div>

    </div>
@stop