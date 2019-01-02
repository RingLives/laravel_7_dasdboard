@extends('layouts.dashboard.index')
@section('section')
    <link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <style>
        .unauthorized {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';

            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .unauthorized .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }
        .unauthorized .content {
            text-align: center;
            display: inline-block;
            width: 100%;
        }

        .unauthorized .title {
            font-size: 66px;
            margin-bottom: 40px;
        }

        .unauthorized .quote {
            font-size: 34px;

        }
        .unauthorized .linkBtn{
            float: left;
            width: 100%;
            padding-top: 30px;
            /*background: gray;*/
        }
        .unauthorized .linkBtn a{
            padding: 10px;
            border: 1px solid rgb(200,200,200);
            text-decoration: none;
            border-radius: 5px;
        }
        .unauthorized .linkBtn a:hover{
            background: rgb(200,200,200);
        }
    </style>

    <div class="col-sm-12 unauthorized">
        <div class="row">        
            <div class="content">
                <div class="title">Sorry! You are not <br> Authorized to access</div>
                <hr style="width:40%;">
                <div class="quote">Please contact with the admin.</div>     
            </div>            
            <!-- <div class="linkBtn">
                <a href="/logout">LOGOUT</a>    
            </div> -->
        </div>
    </div>            
@stop
