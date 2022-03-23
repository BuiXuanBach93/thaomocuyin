@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Fb Posts</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('admin.fb-posts.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('fb_posts.table')
                    <meta name="csrf-token" content="{{ csrf_token() }}">
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('9fe65d6c94fa3e5401f9', {
      cluster: 'ap1',
      forceTLS: true
    });

    var channel = pusher.subscribe('phukienone');
    channel.bind('comment', function(data) {
      alert(JSON.stringify(data));
    });
  </script>
