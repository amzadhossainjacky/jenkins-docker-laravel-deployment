<!--start nav -->
<div class="primary-menu">
    <nav class="navbar navbar-expand-lg align-items-center">
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header border-bottom">
                <div class="d-flex align-items-center">
                    <div class="">
                        <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                    </div>
                    <div class="">
                        <h4 class="logo-text">Rocker</h4>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav align-items-center flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route(\Request::segment(1) . '.dashboard') }}">
                            <div class="menu-title d-flex align-items-end"><i class='{{ _icons('home') }}'></i>Dashboard
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                            data-bs-toggle="dropdown" style="vertical-align: middle">
                            <div class="menu-title d-flex align-items-end"><i class='{{ _icons('edit') }}'></i>Kmt
                            </div>
                            <div class="ms-auto dropy-icon"><i class='{{ _icons('arrow_caret_down') }}'></i></div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ route(\Request::segment(1) . '.learning.materials') }}">
                                    <i class='{{ _icons('arrow_right_1') }}'></i>Learning Materails</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route(\Request::segment(1) . '.tutorials') }}">
                                    <i class='{{ _icons('arrow_right_1') }}'></i>Tutorials</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route(\Request::segment(1) . '.exam.question.sets') }}"> <i class='{{ _icons('arrow_right_1') }}'></i>Exam Question Sets</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route(\Request::segment(1) . '.exams') }}"> <i class='{{ _icons('arrow_right_1') }}'></i>Exams</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route(\Request::segment(1) . '.exam.questions') }}"> <i class='{{ _icons('arrow_right_1') }}'></i>Exams Questions</a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                            data-bs-toggle="dropdown" style="vertical-align: middle">
                            <div class="menu-title d-flex align-items-end"><i
                                    class='{{ _icons('settings_gear') }}'></i>Setting</div>
                            <div class="ms-auto dropy-icon"><i class='{{ _icons('arrow_caret_down') }}'></i></div>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route(\Request::segment(1) . '.roles') }}"><i
                                        class='{{ _icons('arrow_right_1') }}'></i>Roles</a></li>
                            @can('user-list')
                                <li> <a class="dropdown-item" href="{{ route(\Request::segment(1) . '.users') }}"><i
                                            class='{{ _icons('arrow_right_1') }}'></i>Users</a></li>
                            @endcan
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<!--end nav -->
