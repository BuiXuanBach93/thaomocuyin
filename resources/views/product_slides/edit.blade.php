@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Product Slide
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($productSlide, ['route' => ['productSlides.update', $productSlide->id], 'method' => 'patch']) !!}

                        @include('product_slides.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection