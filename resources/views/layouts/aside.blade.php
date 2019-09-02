<div class="app-sidebar__user"><img class="app-sidebar__user-avatar"src="@if (isset(Auth::user()->picture)){{asset(Auth::user()->picture)}} @else {{asset('images/avatar128.png')}} @endif" alt="User Image">
    <div>
        <p class="app-sidebar__user-name">{{Auth::user()->name}}</p>
        <p class="app-sidebar__user-designation">{{Auth::user()->role}}</p>
    </div>
</div>
<ul class="app-menu">
    <li><a class="app-menu__item @if($current_page == 'create') active @endif" href="{{route('home')}}"><i class="app-menu__icon fa fa-plus"></i><span class="app-menu__label">Create New Incident</span></a></li>  
    <li><a class="app-menu__item @if($current_page == 'search') active @endif" href="{{route('incident.search')}}"><i class="app-menu__icon fa fa-search"></i><span class="app-menu__label">Search an Incident(s)</span></a></li>
    <li><a class="app-menu__item @if($current_page == 'kdbindex') active @endif" href="{{route('kdb.index')}}"><i class="app-menu__icon fa fa-database"></i><span class="app-menu__label">Knowledge Base</span></a></li>
    @if (Auth::user()->role == "Admin")
        <li><a class="app-menu__item @if($current_page == 'user') active @endif" href="{{route('user.index')}}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">User Management</span></a></li>       
    @endif
    </ul>