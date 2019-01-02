@extends('layouts.app')
{{-- @section('title','Dashboard') --}}
@section('content')
	<div class="container-fluid">        
            <div class="block-header">
                <h2>@yield('page_heading')</h2>
            </div>

            <div class="row clearfix">
                @yield('section')
            </div>
    </div>
@endsection
