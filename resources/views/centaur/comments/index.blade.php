@extends('Centaur::layout')

@section('title', 'Comments')

@section('content')
<!--<script>$(document).ready(function() {
  $('#tablica').DataTable();
});</script>-->
    <div class="page-header">
        <div class='btn-toolbar pull-right'>
            <a class="btn btn-primary btn-lg" href="{{ route('comments.create') }} ">
                <span class="glyphicon" aria-hidden="true"></span>
                Approve pending: {{$count  = DB::table('comments')->where('status', 2)->count()}}
            </a>
        </div>
        <h1>Comments</h1>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-responsive">
                <table class="table table-hover" id="tablica">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Content</th>
                            <th>Created</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
					@if($comments->count() > 0)
						@foreach ($comments as $comment)

                            <tr>
                                <td>{{ str_limit($comment->post->title, 20, '...') }}</td>
                                <td>{{ $comment->user->email }}</td>
                                <td>{{ str_limit($comment->content,20,'...')}}</td>
                                <td>{{ date('d.m.Y', strtotime($comment->created_at)) }}</td>
                                <td>
                                  @switch($comment->status)
                                    @case(1)
                                      Approved
                                    @break
                                    @case(2)
                                      Pending
                                    @break
                                    @default
                                      Denied
                                  @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-default">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                        Approve
                                    </a>
                                    <a href="{{ route('comments.show', $comment->id) }}" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                        Deny
                                    </a>
                                    <a href="{{ route('comments.destroy', $comment->id) }}" class="btn btn-danger action_confirm" data-method="delete" data-token="{{ csrf_token() }}">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                        Delete
                                    </a>
                                </td>
                            </tr>

                        @endforeach
					@else
						<td colspan="4">Trenutno nema unesenih komentara!!!</td>
					@endif
                     <tr>
					 	<td colspan="4">{!! $comments->links() !!}</td>

					 </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
