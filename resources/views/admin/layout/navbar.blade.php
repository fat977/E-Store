<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="{{ asset('assets/admin/images/logo.svg') }}" class="mr-2" alt="logo"/></a>
      <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ url('assets/admin/images/logo-mini.svg') }}" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
      <ul class="navbar-nav mr-lg-2">
        <li class="nav-item nav-search d-none d-lg-block">
          <div class="input-group">
            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
              <span class="input-group-text" id="search">
                <i class="icon-search"></i>
              </span>
            </div>
            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
          </div>
        </li>
      </ul>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
            <i class="icon-bell mx-0"></i>
          </a>
          @if (auth()->user()->unreadNotifications->count() > 0)
            <span class="count text-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
          @endif

          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
            <h4 class="p-3">Notifications</h4>
            @if (auth()->user()->unreadNotifications->count() > 0)
              @foreach (auth()->user()->unreadNotifications as $notification)
                <a class="dropdown-item preview-item" href="{{ url('admin/order/view-orders',$notification->data['id']) }}">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="ti-info-alt mx-0"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                      
                        <h6 class="preview-subject font-weight-normal">
                          
                          {{ $notification->data['title'] }}
                          {{ $notification->data['user'] }}
                        </h6>
                      
                      <p class="font-weight-light small-text mb-0 text-muted">
                        {{ $notification->created_at }}
                      </p>
                  </div>
                </a>
              @endforeach
              <a class="p-3" href="{{ route('MarkAsRead_all') }}">Read All</a>
            @else
              <p class="px-4 text-danger">There is no any notifications</p>
            @endif


           {{--  <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-success">
                  <i class="ti-info-alt mx-0"></i>
                </div>
              </div>

                @foreach (auth()->user()->unreadNotifications as $notification)
                <div class="preview-item-content" style="width: 250px;">

                  <div class="main-notification-list Notification-scroll">
                      <a class="d-flex p-3 border-bottom"
                          href="{{ url('order/orders') }}/{{ $notification->data['id'] }}">
                          {{-- <div class="notifyimg bg-pink">
                              <i class="la la-file-alt text-white"></i>
                          </div>
                          <div class="mr-3">
                              <h5 class="notification-label mb-1">
                                  {{ $notification->data['title'] }}
                                  {{ $notification->data['user'] }}
                              </h5>
                              <div class="notification-subtext">{{ $notification->created_at }}</div>
                          </div>
                      </a>
                  </div>
                </div>
                @endforeach
            </a> --}}
          </div>
        </li>
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            <img src="{{ url('assets/admin/images/faces/face28.jpg') }}" alt="profile"/>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="{{ route('update-details') }}">
              <i class="ti-settings text-primary"></i>
              Settings
            </a>
            <a class="dropdown-item" href="{{ route('logout') }}">
              <i class="ti-power-off text-primary"></i>
              Logout
            </a>
          </div>
        </li>
        <li class="nav-item nav-settings d-none d-lg-flex">
          <a class="nav-link" href="#">
            <i class="icon-ellipsis"></i>
          </a>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="icon-menu"></span>
      </button>
    </div>
  </nav>