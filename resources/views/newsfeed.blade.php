@extends("layout.dashboard")

@section('dashboard_content')

    @if($posts->count() > 0)
        @foreach($posts as $post)
            <!-- Post Content
            ================================================= -->
            <div class="post-content">
                <div class="post-container">
                <img src="{{$post->user->image === null ? asset('/images/default_profile_image.png') : $post->user->image}}" alt="profile image" alt="user"class="profile-photo-md pull-left">
                <div class="post-detail">
                    <div class="user-info">
                        <div>
                            <h5 style = "display: flex">
                                <a href="{{route('timeline', $post->user_id)}}" class="profile-link">{{ucwords($post->user->firstname ." ". $post->user->lastname)}}</a>
                                @if($post->visibility == "public")
                                    <span style = "margin-left: 10px; margin-top: 1px; color: #2196f3;" class = "fa fa-globe"><small style = "margin-left: 2px;">Public</small></span>
                                @elseif($post->visibility == "me")
                                    <span style = "margin-left: 10px; margin-top: 1px; color: black;" class = "fa fa-lock"><small style = "margin-left: 2px;">Only Me</small></span>
                                @else
                                    <span style = "margin-left: 10px; margin-top: 1px; color: black;" class = "fa fa-group"><small style = "margin-left: 2px;">Friends</small></span>
                                @endif

                                @auth
                                    @if(auth()->user()->id !== $post->user_id)
                                        <form action = "{{route('user.follow', $post->user_id)}}" method = "post">
                                            @csrf
                                            <button class = "button_rep following" style = "display: inline-block" type = "submit">{{($followers->where("user_id", "=", $post->user_id)->count() > 0)? "following":"follow"}}</button>
                                        </form>                                    
                                    @endif
                                @endauth
                            </h5>
                        </div>
                    <p class="text-muted">{{$post->created_at->diffForHumans()}}</p>
                    </div>
                    
                    <div class="more">
                        <div class="dropdown">
                            <a href="#" data-toggle="dropdown"><span class = "glyphicon glyphicon-option-horizontal"></span></a>
                            <ul class="dropdown-menu">
                                 @auth
                                    @if(auth()->user()->id !== $post->user_id)
                                        <form action = "{{route('user.follow', $post->user_id)}}" method = "post">
                                            @csrf
                                            <li>
                                                <a>
                                                    <button class = "button_rep" style = "display: inline-block" type = "submit"> 
                                                        {{($followers->where("user_id", "=", $post->user_id)->count() > 0)? "Unfollow":"Follow"}}
                                                    </button>
                                                </a>
                                            </li>
                                        </form>                                    
                                    @endif
                                @endauth
                              
                                @auth
                                    @if(auth()->user()->id === $post->user_id)
                                        <li>
                                            <form action = "{{route('post.delete', $post->id)}}" method = "post">
                                                @csrf
                                                {{method_field('DELETE')}}
                                                <button class = "button_rep" type = "submit">Delete Post</button>
                                            </form>
                                        </li>
                                    @else
                                        <li class = "message message-user" data-id = "{{$post->user_id}}"><a>Message</a></li>
                                    @endif
                                   
                                @endauth
                            </ul>
                        </div>
                    </div>
                    @if($post->image !== null && count(json_decode($post->image)) > 0 || $post->video !== null && count(json_decode($post->video)) > 0)
                        <?php  
                            $class = ["one-media-grid","two-media-grid", "three-media-grid","four-media-grid","five-media-grid"];
                        ?>

                        <div class = "post-media-size-container">
                            <div class = "post-media-container {{(count(json_decode($post->image)) + count(json_decode($post->video)) > 5) ? $class[4] : $class[count(json_decode($post->image)) + count(json_decode($post->video)) - 1]}}">
                                <?php $counter = 0 ?>
                                @foreach(json_decode($post->image) as $image)
                                    <?php $counter++ ?>
                                    @if($counter <= 5)
                                        @if($counter == 5)
                                            <div class = "media{{$counter}} post-media" style = "position: relative">
                                                <img src="{{$image}}" alt="post-image" class="img-responsive post-image">
                                                @if(count(json_decode($post->image)) > 5)
                                                    <div class = 'post-media-remains'>+ {{count(json_decode($post->image)) + count(json_decode($post->video)) - 5}}</div>
                                                @endif
                                            </div>                                            
                                        @else
                                            <div class = "media{{$counter}} post-media">
                                                <img src="{{$image}}" alt="post-image" class="img-responsive post-image">
                                            </div>
                                        @endif
                                    @endif
                                @endforeach

                                @if($counter <= 5)
                                    @foreach(json_decode($post->video) as $video)

                                        <?php $counter++ ?>
                                        @if($counter <= 5)
                                            @if($counter == 5)
                                                <div class = "media{{$counter}} post-media" style = "position: relative">
                                                    <video muted = "muted" name="media" class = "img-responsive post-video">
                                                      <source src="{{$video}}" type="video/mp4">
                                                    </video>
                                                    @if(count(json_decode($post->image)) > 5)
                                                        <div class = 'post-media-remains'>+ {{count(json_decode($post->image)) - 5}}</div>
                                                    @endif
                                                </div>                                            
                                            @else
                                                <div class = "media{{$counter}} post-media">
                                                     <video muted = "muted"  name="media" class = "img-responsive post-video">
                                                      <source src="{{$video}}" type="video/mp4">
                                                    </video>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    @endif
                    <div class="line-divider"></div>
                    <div class="post-text">
                    <p>{{$post->message}}</p>
                    </div>
                    <div class="line-divider"></div>
                    <div class = "comment-container" style = "width: 100%; display: flex">
                        <div style = "width: 30%"></div>
                        <div style = "width:70%">
                            <div style = "float:right; cursor: pointer"><a class = "refresh-comment" data-post = "{{$post->id}}">Refresh Comments</a></div>
                            <div id = "comment_{{$post->id}}">
                                <?php $comments = $post->comments()->orderBy("created_at", "desc")->paginate(3)?>
                                @foreach($comments as $comment)
                                    <div class="post-comment">
                                        <div>
                                            <img src="{{$comment->user()->get()[0]->image === null ? asset('/images/default_profile_image.png') : $comment->user()->get()[0]->image}}" alt="" class="profile-photo-sm">
                                        </div>
                                        <p style = "position: relative;">
                                            <a href="{{route('timeline', $comment->user()->get()[0]->id)}}" class="profile-link">
                                                {{ucwords($comment->user()->get()[0]->firstname)}} 
                                            </a> 
                                            <span class = "message">{{$comment->comment}}</span>
                                            <span class = "comment-like-container">
                                                <i class="icon ion-thumbsup" data-post = "{{$post->id}}" data-comment = "{{$comment->id}}"></i>
                                                @if($comment->likes()->get()->count() > 0)
                                                <span>{{$comment->likes()->get()->count()}}</span>
                                                @endif
                                            </span>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            <div style = "float:right; cursor: pointer"><a class = "view-more-comment" data-post = "{{$post->id}}" data-loaded = "{{$comments->count()}}">View More...</a></div>
                            @auth
                            <div class="post-comment">
                                <div>
                                    <img src="{{auth()->user()->image === null ? asset('/images/default_profile_image.png') : auth()->user()->image}}" alt="profile image" alt="user"class="profile-photo-sm">
                                </div>
                                    <input type="text" class="form-control post-comment-field" placeholder="Post a comment" data-post-id = "{{$post->id}}">
                            </div>
                            @endauth
                        </div>
                    </div>
                    <div class="reaction">
                        <form action = "{{route("post.likes", $post->id)}}" method = "post">
                            @csrf
                            <div>
                                <a class="btn text-green">
                                    <form action = "{{route('post.likes', $post->id)}}" method = "post">
                                        @csrf
                                        <button type = "submit" class = "button_rep"><i class="icon ion-thumbsup"></i></button>
                                    </form>
                                    
                                    @if($post->likes->count() > 0) <span>{{$post->likes->count()}}</span> @endif
                                </a>
                            </div>
                            @auth
                                @if(auth()->user()->likes()->where("post_id", "=", $post->id)->count() > 0)
                                    <div class = "text-green text-sm">You liked this {{auth()->user()->likes()->where("post_id", "=", $post->id)->get()[0]->updated_at->diffForHumans()}}</div>
                                @endif
                            @endauth
                        </form>
                    </div>
                </div>
                </div>
            </div>
        @endforeach
        {{$posts->links()}}
    @else
        <div class = "alert alert-warning">
            <strong >There are not pending posts</strong>
        </div>
    @endif
   
  
@endsection