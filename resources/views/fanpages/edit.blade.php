@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Fanpage
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($fanpage, ['route' => ['fanpages.update', $fanpage->id], 'method' => 'patch']) !!}

                        @include('fanpages.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection