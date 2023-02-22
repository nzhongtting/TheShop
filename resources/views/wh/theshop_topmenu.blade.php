	  
	  <nav id="navbar" class="navbar">
      <ul>
      <li><a href="/cart">Cart<span id='result_cnt'></span></a></li>
      <li class="dropdown">
        <a href="#"><span>{{ Auth::user()->name }}</span> 
        <i class="bi bi-chevron-down"></i>
        </a>
        <ul>
              <li><a href="/AdminPage">Admin</a></li>
              <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign Out</a></li>
          </ul>
        </li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
    </form>
