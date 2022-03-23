@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Reply
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($reply, ['route' => ['replies.update', $reply->id], 'method' => 'patch']) !!}

                        @include('replies.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection