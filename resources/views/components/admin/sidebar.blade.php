<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="btn btn-primary mx-3 mb-3" data-toggle="collapse" href="#letter" aria-expanded="false"
                aria-controls="letter">

                <span class="menu-title">Kirim Surat</span>
            </a>
            <div class="collapse" id="letter">
                <ul class="bg-white flex-column sub-menu unstyled-list" style="list-style: none">
                    <li class="nav-item"> <a class="nav-link my-0 py-1 text-dark" href="{{ route('letters.create') }}">
                            Umum </a>
                    </li>
                    <li class="nav-item"> <a class="nav-link my-1 py-0 text-dark"
                            href="{{ route('documents.create') }}">
                            Khusus </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="material-icons-two-tone">dashboard</i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('notifications.index') }}">
                <i class="material-icons-two-tone">notifications</i>
                <span class="menu-title">Notifikasi</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}">
                <i class="material-icons-two-tone">category</i>
                <span class="menu-title">Category</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('inbox.index') }}">
                <i class="material-icons-two-tone">inbox</i>
                <span class="menu-title">Surat Masuk</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('outbox.index') }}">
                <i class="material-icons-two-tone">outbox</i>
                <span class="menu-title">Surat Keluar</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('unit-kerjas.index') }}">
                <i class="material-icons-two-tone">assignment_ind</i>
                <span class="menu-title">Unit Kerja</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('jabatans.index') }}">
                <i class="material-icons-two-tone">verified_user</i>
                <span class="menu-title">Jabatan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="material-icons-two-tone">verified_user</i>
                <span class="menu-title">Role</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="material-icons-two-tone">people</i>
                <span class="menu-title">Users</span>
            </a>
        </li>
    </ul>
</nav>
