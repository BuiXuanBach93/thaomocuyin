@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Provider
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($provider, ['route' => ['admin.providers.update', $provider->id], 'method' => 'patch']) !!}

                        @include('providers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection