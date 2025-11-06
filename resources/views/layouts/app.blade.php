<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Job Portal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container">
        <a class="navbar-brand" href="/">Job Portal</a>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            
            @guest
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Register</a>
              </li>
            @endguest

            @auth
              <li class="nav-item">
                <a class="nav-link" href="#">Halo, {{ Auth::user()->name }}</a>
              </li>
              
              @if(Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('jobs.index') }}">Kelola Jobs</a>
                </li>
              @endif

              <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type-="submit" class="btn btn-link nav-link">Logout</button>
                </form>
              </li>
            @endauth
          </ul>
        </div>
      </div>
    </nav>

    <main class="container py-4">
        
        @yield('content') 
        
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>