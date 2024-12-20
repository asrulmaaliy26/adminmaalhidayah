<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>

                <a class="nav-link {{ Request::segment(2)=='panel' ? 'active' : ''}}" href="{{route('admin.dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                @role('Admin')
                <!----- Users ------->
                <div class="sb-sidenav-menu-heading">User Managment</div>

                <a class="nav-link {{ Request::segment(2)=='users' ? 'active' : ''}}" href="{{route('admin.users.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Users
                </a>
                @endrole

                <div class="sb-sidenav-menu-heading">Content Managment</div>
                
                <!----- Articles ------->
                <a class="nav-link {{ Request::segment(2)=='articles' ? 'in' : 'collapsed'}}" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                    Articles
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ Request::segment(2)=='articles' ? 'show' : ''}}" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @haspermission('get-all-articles')
                        <a class="nav-link {{ Request::segment(2)=='articles' && !Request::segment(3) ? 'active' : ''}}" href="{{route('admin.articles.index')}}">All Articles</a>
                        @endhaspermission
                        <a class="nav-link {{ Request::segment(2)=='articles' && Request::segment(3) == 'myArticles' ? 'active' : ''}}" href="{{route('admin.articles.myArticles')}}">My Articles</a>
                        <a class="nav-link {{ Request::segment(2)=='articles' && Request::segment(3)=='create' ? 'active' : ''}}" href="{{route('admin.articles.create')}}">Create Article</a>
                    </nav>
                </div>
                
                <!----- contacts ------->
                @role('Admin|Editor')
                <a class="nav-link {{ Request::segment(2)=='contacts' ? 'active' : ''}}" href="{{route('admin.contact.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Contact
                </a>
                @endrole
                
                <!----- Categories ------->
                @role('Admin|Editor')
                <a class="nav-link {{ Request::segment(2)=='categories' ? 'active' : ''}}" href="{{route('admin.category.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Categories
                </a>
                @endrole
                <!----- Jenises ------->
                @role('Admin|Editor')
                <a class="nav-link {{ Request::segment(2)=='jenises' ? 'active' : ''}}" href="{{route('admin.jenis.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Jenis
                </a>
                @endrole
                <!----- pendidikans ------->
                @role('Admin|Editor')
                <a class="nav-link {{ Request::segment(2)=='pendidikans' ? 'active' : ''}}" href="{{route('admin.pendidikan.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Pendidikan
                </a>
                @endrole
                <!----- tingkats ------->
                @role('Admin|Editor')
                <a class="nav-link {{ Request::segment(2)=='tingkats' ? 'active' : ''}}" href="{{route('admin.tingkat.index')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                    Tingkat
                </a>
                @endrole
                <!----- Pages ------->
                @role('Admin|Editor')
                <a class="nav-link {{ Request::segment(2)=='pages' ? 'in' : 'collapsed'}}" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-file-lines"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse {{ Request::segment(2)=='pages' ? 'show' : ''}}" id="collapsePages" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ Request::segment(2)=='pages' && !Request::segment(3) ? 'active' : ''}}" href="{{route('admin.pages.index')}}">All Pages</a>
                        <a class="nav-link {{ Request::segment(2)=='pages' && Request::segment(3)=='create' ? 'active' : ''}}" href="{{route('admin.pages.create')}}">Create Page</a>
                    </nav>
                </div>
                @endrole

                <!----- SETTINGS ------->
                @role('Admin')
                <div class="sb-sidenav-menu-heading">Settings</div>

                <a class="nav-link {{ Request::segment(2)=='config' ? 'active' : ''}}" href="{{route('admin.config.index')}}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                    Site configs
                </a>
                @endrole
                {{-- Theme examples --}}
                    {{-- <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                        Pages
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                Authentication
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="login.html">Login</a>
                                    <a class="nav-link" href="register.html">Register</a>
                                    <a class="nav-link" href="password.html">Forgot Password</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                Error
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="401.html">401 Page</a>
                                    <a class="nav-link" href="404.html">404 Page</a>
                                    <a class="nav-link" href="500.html">500 Page</a>
                                </nav>
                            </div>
                        </nav>
                    </div>
                    <div class="sb-sidenav-menu-heading">Addons</div>
                    <a class="nav-link" href="charts.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Charts
                    </a>
                    <a class="nav-link" href="tables.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Tables
                    </a> --}}
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            @foreach (Auth::user()->roles->pluck('name') as $role )
                <span class=""><strong>{{ $role }},</strong></span>
            @endforeach
        </div>
    </nav>
</div>