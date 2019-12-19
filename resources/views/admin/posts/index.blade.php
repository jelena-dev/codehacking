@extends('layouts.admin')


@section('content')

<h1>Posts</h1>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>User</th>
            <th>Photo</th>
            <th>Category</th>
            <th>Title</th>
            <th>Body</th>
            <th>Created</th>
            <th>Updated</th>
        </tr>
    </thead>


    <tbody>
     @if($posts)
            @foreach($posts as $post)
                <tr>
                <td>{{$post->id}}</td>
                <td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->user->name}}</a></td>
                <td><img height="100" src="{{$post->photo ? $post->photo->file : ' https://24smi.org/public/media/dummy_image.png' }}" alt=""></td>
                <td>{{$post->category->name}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->body}}</td>
                <td>{{$post->created_at->diffForHumans()}}</td>
                <td>{{$post->updated_at->diffForHumans()}}</td> 
                <td><a href="{{route('home.post', $post->id)}}">View Post</a></td>
                <td><a href="{{route('admin.comments.show', $post->id)}}">View Comments</a></td>
                               
                
                
                </tr>

            @endforeach
        @endif
    </tbody>

</table>
@stop