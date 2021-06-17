@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold font-medium mb-1">{{$user->name}}</h1>
                <p>Posted {{$posts->count()}} {{Str::plural('post',$posts->count())}}
                 and received {{$user->receivedLikes->count()}} {{Str::plural('like',$user->receivedLikes->count())}}</p>
            </div>
            
            @if ($posts->count())
                @foreach($posts as $post)
                    <div class="mb-4" >
                        <a href="{{route('users.posts',$post->user)}}" class="font-bold">{{$post->user->username}}</a>
                        <span class="text-gray-600 text-sm">{{$post->created_at->diffForHumans()}}</span>
                        <p class="mb-2">{{$post->body}}</p>

                        <div class="flex items-center">
                        @auth
                            @if(!$post->likedBy(auth()->user()))
                                <form action="{{route('posts.likes',$post->id)}}" method="post" class="mr-1">
                                @csrf
                                    <button type="submit" class="text-blue-500">Like</button>
                                </form>
                            @else
                                <form action="{{route('posts.likes',$post)}}" method="post" class="mr-1">
                                @method('DELETE')
                                @csrf
                                    <button type="submit" class="text-blue-500">Unlike</button>
                                </form>
                            @endif
                        @endauth
                            <span>{{$post->likes->count()}} {{Str::plural('like', $post->likes->count())}}</span>
                        </div>
                        @auth
                        @if($post->ownedBy(auth()->user()))
                        <div>
                            <form action="{{route('posts.destroy',$post)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button text="submit" class="text-blue-500">Delete</button>
                            </form>
                        </div>
                        @endif
                        @endauth

                    </div>
                    <hr class="mb-4">
                @endforeach
                {{$posts->links()}}
            @else
                <p>There are no posts.</p>
            @endif
        </div>
    </div>
@endsection