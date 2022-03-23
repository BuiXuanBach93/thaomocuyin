@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            News Tag
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($productTag, ['route' => ['newsTags.update', $productTag->id], 'method' => 'patch']) !!}

                        @include('news_tags.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
