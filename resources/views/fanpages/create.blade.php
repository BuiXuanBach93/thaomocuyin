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
                    {!! Form::open(['route' => 'admin.fanpages.store']) !!}

                    <div class="form-group col-sm-12">
                        {!! Form::label('fanpage_id', 'fanpage_ids:') !!}
                        {!! Form::textArea('fanpage_id', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-12">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('admin.fanpages.index') !!}" class="btn btn-default">Cancel</a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
