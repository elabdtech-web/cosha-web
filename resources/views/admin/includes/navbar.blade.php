{{-- Navbar --}}
<header class="header toggle bg-dark" id="header">
    <div class="header_toggle" id="sidebarToggle">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </div>
    <div class="header_img d-flex align-items-center gap-3">
        {{-- Notifcation Dropdown --}}
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="fa fa-bell fa-2x text-white" aria-hidden="true"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </div>

        {{-- Dropdown --}}
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="https://mdbootstrap.com/img/new/avatars/2.jpg" class="rounded-circle" height="50"
                    alt="Black and White Portrait of a Man" loading="lazy" />
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="#">Chat</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Logout</a></li>
            </ul>
        </div>
    </div>
</header>
