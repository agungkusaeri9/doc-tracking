<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @can('Surat Umum Create', 'Surat Khusus Create')
            <li class="nav-item">
                <a class="btn btn-primary mx-3 mb-3" data-toggle="collapse" href="#letter" aria-expanded="false"
                    aria-controls="letter">

                    <span class="menu-title">Kirim Surat</span>
                </a>
                <div class="collapse" id="letter">
                    <ul class="bg-white flex-column sub-menu unstyled-list" style="list-style: none">
                        @can('Surat Umum Create')
                            <li class="nav-item"> <a class="nav-link my-0 py-1 text-dark" href="{{ route('letters.create') }}">
                                    Umum </a>
                            </li>
                        @endcan
                        @can('Surat Khusus Create')
                            <li class="nav-item"> <a class="nav-link my-1 py-0 text-dark"
                                    href="{{ route('documents.create') }}">
                                    Khusus </a></li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcan
        @can('Dashboard')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="material-icons-two-tone">dashboard</i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
        @endcan

        @can('Notifikasi Index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('notifications.index') }}">
                    <i class="material-icons-two-tone">notifications</i>
                    <span class="menu-title">Notifikasi</span>
                </a>
            </li>
        @endcan


        @can('Category Index', 'Category Create', 'Category Update', 'Category Delete')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories.index') }}">
                    <i class="material-icons-two-tone">category</i>
                    <span class="menu-title">Category</span>
                </a>
            </li>
        @endcan
        @can('Surat Masuk Index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inbox.index') }}">
                    <i class="material-icons-two-tone">inbox</i>
                    <span class="menu-title">Surat Masuk</span>
                </a>
            </li>
        @endcan
        @can('Surat Keluar Index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('outbox.index') }}">
                    <i class="material-icons-two-tone">outbox</i>
                    <span class="menu-title">Surat Keluar</span>
                </a>
            </li>
        @endcan
        @can('Unit Kerja Index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('unit-kerjas.index') }}">
                    <i class="material-icons-two-tone">assignment_ind</i>
                    <span class="menu-title">Unit Kerja</span>
                </a>
            </li>
        @endcan
        @can('Jabatan Index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('jabatans.index') }}">
                    <i class="material-icons-two-tone">verified_user</i>
                    <span class="menu-title">Jabatan</span>
                </a>
            </li>
        @endcan
        @can('Role Index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('roles.index') }}">
                    <i class="material-icons-two-tone">verified_user</i>
                    <span class="menu-title">Role</span>
                </a>
            </li>
        @endcan
        @can('Permission Index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('permissions.index') }}">
                    <i class="material-icons-two-tone">verified_user</i>
                    <span class="menu-title">Permission</span>
                </a>
            </li>
        @endcan
        @can('User Index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="material-icons-two-tone">people</i>
                    <span class="menu-title">Users</span>
                </a>
            </li>
        @endcan
    </ul>
</nav>
