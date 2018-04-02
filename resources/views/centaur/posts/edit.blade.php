@extends('Centaur::layout')

@section('title')
Edit {{ $post->title }} Post
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit {{ $post->title }} Post</h3>
            </div>
            <div class="panel-body">
                <form accept-charset="UTF-8" role="form" method="post" action="{{ route('posts.update', $post->id) }}">
                <fieldset>
                    <div class="form-group {{ ($errors->has('title')) ? 'has-error' : '' }}">
                        <input class="form-control" placeholder="Title" name="title" type="text" value="{{ $post->title }}" />
                        {!! ($errors->has('title') ? $errors->first('title', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    <div class="form-group {{ ($errors->has('content')) ? 'has-error' : '' }}">
						<textarea class="form-control" name="content" placeholder="Post content" rows="10">{{ $post->content }}</textarea>
                        {!! ($errors->has('content') ? $errors->first('content', '<p class="text-danger">:message</p>') : '') !!}
                    </div>
                    
                    {{ csrf_field() }}
					{{ method_field('PUT')}}
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Update">
                </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@stop