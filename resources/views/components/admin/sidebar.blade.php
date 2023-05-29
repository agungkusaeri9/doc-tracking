<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="btn btn-primary mx-3 mb-3" data-toggle="collapse" href="#letter" aria-expanded="false" aria-controls="letter">

                <span class="menu-title">Kirim Surat</span>
            </a>
            <div class="collapse" id="letter">
                <ul class="bg-white flex-column sub-menu unstyled-list" style="list-style: none">
                    <li class="nav-item"> <a class="nav-link my-0 py-1 text-dark" href="{{ route('letters.create') }}"> Umum </a>
                    </li>
                    <li class="nav-item"> <a class="nav-link my-1 py-0 text-dark" href="{{ route('documents.create') }}">
                            Khusus </a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Category</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('unit-kerjas.index') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Unit Kerja</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('jabatans.index') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Jabatan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Role</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Users</span>
            </a>
        </li>
    </ul>
</nav>
