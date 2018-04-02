@extends('Centaur::layout')

@section('title', 'Create New Post')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Create New Post</h3>
            </div>
            <div class="panel-body">
                <form accept-charset="UTF-8" role="form" method="post" action="{{ route('posts.store') }}">
                <fieldset>
                    <div class="form-group {{ ($errors->has('title')) ? 'has-error' : '' }}">
                        <input class="form-control" placeholder="Title" name="title" type="text" value="{{ old('title') }}" />
                        {!! ($errors->has('title') ? $errors->first('title', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group {{ ($errors->has('content')) ? 'has-error' : '' }}">
						<textarea class="form-control" name="content" placeholder="Post content" rows="10">{{ old('content')}}</textarea>
                        {!! ($errors->has('content') ? $errors->first('content', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    
                    {{ csrf_field() }}
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Create">
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@stop