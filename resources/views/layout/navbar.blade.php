{{-- <header>
    <div class="logo">
        <img src="{{ asset('Logo.png')}}" alt="Logo">
        <span>TEKNOLOGI INFORMASI</span>
    </div>
    <nav>
        <a href="/mahasiswas">Mahasiswa</a>
        <a href="/dosen">Dosen</a>
        <a href="/ruangan">Ruangan</a>
        <a href="/tugas_akhirs">Tugas Akhir</a>
        <a href="/jadwal">Jadwal Sidang</a>
        <a href="/penilaian">Penilaian Sidang</a>
        <a href="/dokumen">Dokumen Sidang</a>
        <a href="/notifikasi">Notifikasi Sidang</a>
    </nav>
    <div class="logout">
        <a href="/">Logout</a>
    </div>
</header>
 --}}
<!-- Page wrapper start -->
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-black sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <div class="logo">
            <img src="{{ asset('Logo.png') }}" alt="Logo">
            <span>
                "Schedulize"
            </span>
        </div>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="\dasboard">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <li class="nav-item active">



            @auth
                @if (Auth::user()->level == 'Admin')
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo"
                        aria-expanded="true" aria-controls="collapseTwo">
                        <i class="bi bi-people-fill"></i>
                        <span>User</span>
                    </a>
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">Kelola Data User</h6>
                        </div>
                    </div>
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item active" href="\mahasiswas">Data Mahasiswa</a>
                        </div>
                    </div>
                @endif
            @endauth
            @auth

                @if (Auth()->user()->level == 'Admin')
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="\dosen">Data Dosen</a>
                        </div>
                    </div>
                @endif
            @endauth
            @auth

                @if (Auth()->user()->level == 'Admin')
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item active" href="\users">Data User</a>
                        </div>
                    </div>
                @endif
            @endauth

        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="bi bi-activity"></i>
                <span>Aktivitas</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">

                    <h6 class="collapse-header">Kelola Aktivitas</h6>
                    @auth
                        @if (Auth::user()->level == 'Admin' ||
                                Auth::user()->level == 'kaprodi' ||
                                Auth::user()->level == 'mahasiswa' ||
                                Auth::user()->level == 'Tim_Penguji' ||
                                Auth::user()->level == 'dosen' ||
                                Auth::user()->level == 'pembimbing1')
                            <a class="collapse-item" href="\tugas_akhirs">Kelola Tugas Akhir</a>
                        @endif
                    @endauth
                    @auth
                        @if (Auth()->user()->level == 'Admin' || Auth::user()->level == 'kaprodi')
                            <a class="collapse-item" href="\ruangan">Kelola Ruangan</a>
                        @endif
                    @endauth
                    @auth
                        @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'kaprodi' || Auth::user()->level == 'dosen')
                            <a class="collapse-item" href="\sidang">Kelola Sidang</a>
                        @endif
                    @endauth
                    @auth
                        @if (Auth::user()->level == 'Admin' || Auth::user()->level == 'kaprodi')
                            <a class="collapse-item" href="\penilaian">Kelola Nilai</a>
                        @endif
                    @endauth
                    {{-- <a class="collapse-item" href="\proposals">Kelola Proposal</a>
                    {{-- <a class="collapse-item" href="\jadwal">Kelola Jadwal</a> --}}
                    {{-- <a class="collapse-item" href="\dokumen">Kelola Dokumen</a> --}}
                </div>
            </div>
        </li>


        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        @if (Auth::user()->level == 'Admin')
            <div class="sidebar-heading">
                Lainnya
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Export Import</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Export</h6>
                        <a class="collapse-item" href="exportUser">Export Users</a>
                        <a class="collapse-item" href="exportMahasiswa">Export Mahasiswa</a>
                        <a class="collapse-item" href="exportDosen">Export Dosen</a>
                        <a class="collapse-item" href="exportpenilaian">Export Penilaian</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Import:</h6>
                        <a class="collapse-item" href="importUser">Import User</a>
                        <a class="collapse-item" href="importMahasiswa">Import Mahasiswa</a>
                        <a class="collapse-item" href="importDosen">Import Dosen</a>
                        <h6 class="collapse-header">API:</h6>
                        <a class="collapse-item" href="apiMahasiswa">Api Mahasiswa</a>
                        <a class="collapse-item" href="apiDosen">Api Dosen</a>
                    </div>
                </div>
            </li>
        @endif
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column bg-white">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link " href="/notifikasi">
                            <i class="fas fa-bell fa-fw"></i>
                        </a>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                @auth
                                    {{ Auth::user()->name }}
                                    @if (Auth::user()->level)
                                        ({{ Auth::user()->level }})
                                    @endif
                                @endauth
                            </span>
                            <img class="img-profile rounded-circle" src="../../hh/img/undraw_profile.svg">
                        </a>

                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            @auth
                                <a class="dropdown-item" href="{{ route('users.show', ['user' => Auth::user()->id]) }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>

                                @if (Auth()->user()->level == 'Admin')
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Settings
                                    </a>

                                    <a class="dropdown-item" href="{{ route('activitylogs.index') }}">
                                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Activity Log
                                    </a>
                                @endif


                                <div class="dropdown-divider"></div>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            @else
                            @endauth
                        </div>
                    </li>

                </ul>

            </nav>
            {{-- <footer class="main-footer">
                <strong>Copyright &copy; 2024 <a>Sistem Informasi Penjadwalan Tugas Akhir</a>.</strong>
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 3.1.0
                </div>
            </footer>
 --}}
