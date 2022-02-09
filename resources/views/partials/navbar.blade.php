<ul class="navbar-nav mr-auto">
    <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
    @auth
{{--    <li @if(request()->is('admin/post*')) class="nav-item active" @else class="nav-item" @endif><a class="nav-link"--}}
{{--            href="{{route('post.index')}}">Post</a></li>--}}
{{--    <li @if(request()->is('admin/tag*'))  class="nav-item active" @else class="nav-item" @endif><a class="nav-link"--}}
{{--            href="{{route('tag.index')}}">Tag</a></li>--}}
{{--    <li @if(request()->is('admin/upload*')) class="nav-item active" @else class="nav-item" @endif><a class="nav-link"--}}
{{--            href="{{route('admin.upload-form')}}">Upload</a></li>--}}
    @endauth
</ul>

<ul class="navbar-nav ml-auto">
    @guest
        <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
    @else
    <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{\Illuminate\Support\Facades\Auth::user()->name}}
            <span class="caret"></span>
        </a>
        <div class="dropdown-menu" role="menu">
            <a href="/logout" class="dropdown-item">Logout</a>
        </div>
    </li>
    @endguest
</ul>
