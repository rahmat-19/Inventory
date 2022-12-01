<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo gambar">
                @if(auth()->user()->role == 'admin')
                <img src="/images/asnet_logo.png" class="logo" id="logo" alt="">
                <span class="nav_logo-name"><img src="/images/asnet.png" class="logo-name" id="logo-img" alt=""></span>
                @else
                <img src="/images/{{auth()->user()->categories()->pluck('id')[0] != 1 || auth()->user()->role == 'admin' ? 'asnet' : 'sengked'}}_logo.png" class="logo" id="logo" alt="">
                <span class="nav_logo-name"><img src="/images/{{auth()->user()->categories()->pluck('id')[0] != 1 || auth()->user()->role == 'admin' ? 'asnet' : 'sengked'}}.png" class="logo-name" id="logo-img" alt=""></span>
                @endif
            </a>

            <div class="nav_list">

                <a href="{{Route('dashboard')}}" class="nav_link  {{Request::is('/') ? 'active' : ''}}">
                    <img src="/images/icon/home.svg" alt="" class="nav_icon">
                    <span class="nav_name">Dashboard</span>
                </a>

                @can('admin')

                <a href="{{Route('user.index')}}" class="nav_link  {{Request::is('user*') ? 'active' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="nav_name">Users</span>
                </a>

                @else

                <a href="{{Route('barang-masuk.index')}}" class="nav_link  {{Request::is('barang-masuk*') ? 'active' : ''}}">
                    <img src="/images/icon/layers.svg" alt="" class="nav_icon">
                    <span class="nav_name">Barang Masuk</span>
                </a>
                <a href="{{Route('barang-keluar.index')}}" class="nav_link {{Request::is('barang-keluar*') ? 'active' : ''}}">
                    <img src="/images/icon/shuffle.svg" alt="" class="nav_icon">
                    <span class="nav_name">Barang Keluar</span>
                </a>

                @if(auth()->user()->categories()->pluck('id')[0] != 1)
                <a href="{{Route('device.index')}}" class="nav_link {{Request::is('device*') ? 'active' : ''}}">
                    <img src="/images/icon/airplay.svg" alt="" class="nav_icon">
                    <span class="nav_name">Device</span>
                </a>
                @else
		<a href="{{Route('history.index')}}" class="nav_link {{Request::is('history*') ? 'active' : ''}}">
                    <img src="/images/icon/file-text.svg" alt="" class="nav_icon">
                    <span class="nav_name">History</span>
                </a>
                @endif

                @endcan

                <a href="{{Route('penanggung-jawab.index')}}" class="nav_link  {{Request::is('penanggung-jawab*') ? 'active' : ''}}">
                    <img src="/images/icon/users.svg" alt="" class="nav_icon">
                    <span class="nav_name">Penanggung Jawab</span>
                </a>
            </div>
        </div>
        <div class="px-3">
            <a href="{{Route('logout')}}" class="nav_link aaa nav-logot">
                <img src="/images/icon/log-out.svg" alt="" class="nav_icon me-4">
                <span class="nav_name">SignOut</span>
            </a>
        </div>
    </nav>
</div>
