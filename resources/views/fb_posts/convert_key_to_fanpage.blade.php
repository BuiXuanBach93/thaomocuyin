@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Check fanpage
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.fb-posts.convert_key_to_fanpage']) !!}

                        <div class="form-group col-sm-12">
                            {!! Form::label('keys', 'keys:') !!}
                            {!! Form::textArea('keys', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('contain', 'Contain: (Tiếng Việt không dấu)') !!}
                            {!! Form::text('contain', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('admin.fb-posts.index') !!}" class="btn btn-default">Cancel</a>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
