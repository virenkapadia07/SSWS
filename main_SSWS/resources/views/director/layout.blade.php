<!doctype html>
<html>
  <head>
    <input type="hidden" id="_token" value={{ csrf_token() }}>
    <title>Director Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" id="main-stylesheet"  href="admin/styles/shards-dashboards.1.1.0.min.css">
    <link rel="stylesheet" href="admin/styles/extras.1.1.0.min.css">

  </head>
  <body class="h-100">
    <div class="container-fluid">
      <div class="row">
        <!-- Main Sidebar -->
        <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
          <div class="main-navbar">
            <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
              <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
                <div class="d-table m-auto">
                  <span class="d-none d-md-inline ml-1">Director Dashboard</span>
                </div>
              </a>
            </nav>
          </div>
          <div class="nav-wrapper">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="home">
                  <i class="material-icons">home</i>
                  <span>Home</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="search">
                  <i class="material-icons">search</i>
                  <span>Search</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="#">
                  <i class="material-icons">settings</i>
                  <span>Settings</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link " href="DirectorLogout">
                  <i class="material-icons text-danger">logout</i>
                  <span class="text-danger">Logout</span>
                </a>
              </li>
            </ul>
          </div>
        </aside>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
          <div class="main-navbar sticky-top bg-white">
            <!-- Main Navbar -->
            <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
              <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
                <div class="input-group input-group-seamless ml-3">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                            <span style="font-size:38px;color:#3d5170;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                Student & Staff Welfare System
                            </span>
                    </div>
                  </div>
                  {{-- <input class="navbar-search form-control" type="text" placeholder="Search..." aria-label="Search"> --}}
                </div>
              </form>
              <ul class="navbar-nav border-left flex-row ">

                <?php
                    $notification=DB::table('student_applications')->where('notification',NULL)->get();
                    $count=$notification->count();
                ?>
                <li class="nav-item border-right dropdown notifications">
                  <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="nav-link-icon__wrapper">
                      <i class="material-icons">&#xE7F4;</i>
                      @if ($count>0)
                        <span class="badge badge-pill badge-danger">{{$count}}</span>
                      @else
                        <span class="badge badge-pill badge-danger"></span>
                      @endif
                    </div>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
                    @if ($count>0)
                          @foreach ($notification as $n)
                          <?php
                            $name=DB::table('student_info')->where('enrollment',$n->enrollment)->get();
                          ?>

                            <a class="dropdown-item" onclick="getN({{$n->id}})">
                                <div class="notification__icon-wrapper">
                                    <div class="notification__icon">
                                    <i class="material-icons">message</i>
                                    </div>
                                </div>
                                <div class="notification__content">
                                    <span class="notification__category">{{$name[0]->name}} requested for leave</span>
                                    <p>{{$n->type_of_leave}}</p>
                                </div>
                            </a>
                            @endforeach
                      @else
                            <div class="notification__content"  align="center">
                                <span class="notification__category">No New Notifications</span>
                            </div>
                      @endif
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle mr-2" src="admin/images/avatars/0.jpg" alt="User Avatar">
                    <span class="d-none d-md-inline-block">Director</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-small">
                    <a class="dropdown-item" href="components-blog-posts.html">
                      <i class="material-icons">settings</i>Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="DirectorLogout">
                      <i class="material-icons text-danger">&#xE879;</i> Logout</a>
                  </div>
                </li>
              </ul>
            </nav>
          </div>
          <div class="main-content-container container-fluid px-4">
                @yield('content')
          </div>

        </main>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
<script>
    function getN(id)
    {

        var token=document.getElementById('_token').value;
        var url="show";
        var form=document.createElement('form');
        document.body.appendChild(form);
        form.method='post';
        form.action=url;
        var input=document.createElement('input');
        input.type='hidden';
        input.name='_token';
        input.value=token;
        form.appendChild(input);
        var input=document.createElement('input');
        input.type='hidden';
        input.name='id';
        input.value=id;
        form.appendChild(input);
        form.submit();
    }
</script>

</html>
