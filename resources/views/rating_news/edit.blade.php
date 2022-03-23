@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Rating News
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($ratingNews, ['route' => ['ratingNews.update', $ratingNews->id], 'method' => 'patch']) !!}

                        @include('rating_news.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection