@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Fb Post
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($fbPost, ['route' => ['admin.fb-posts.update', $fbPost->id], 'method' => 'patch']) !!}

                        @include('fb_posts.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
