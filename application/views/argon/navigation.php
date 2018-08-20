<button class="d-none d-md-block btn btn-white btn-outline-white rounded-circle btn-sm btn-icon-only btn-sidebar-show d-print-none">
    <i class="fas fa-arrow-right"></i>
</button>
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white d-print-none" id="sidenav-main" style="z-index: 999">
    <div class="container-fluid">

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="d-flex row justify-content-between align-items-center flex-nowrap">
            <!-- Brand -->
            <a class="navbar-brand p-0 w-75 text-left" href="#" style="white-space: normal;">
                <h4 class="m-0 pl-2"><?=strtoupper($ui_sidebar_title)?></h4>
            </a>
            <button class="d-none d-md-block btn btn-link btn-outline-primary rounded-circle btn-sm btn-icon-only btn-sidebar-hide">
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="<?=site_url($user_active['userdata']->avatar)?>">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Selamat Datang!</h6>
                    </div>
                    <a href="<?=site_url('auth/logout')?>" class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="#">
                            <img src="<?=site_url('assets/argon/img/brand/blue.png')?>">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Navigation -->
            <ul class="navbar-nav">
                <?php 
                    if (isset($ui_sidebar_nav)) {
                        if (is_array($ui_sidebar_nav)) {
                            foreach ($ui_sidebar_nav as $nav) {
                                $nav_array = explode('|', $nav);
                                $nav_title = $nav_array[0];
                                $nav_class = $nav_array[1];
                                $nav_url = $nav_array[2];
                ?>

                <li class="nav-item <?=((isset($nav_array[3])) ? 'active' : '')?>">
                    <a class="nav-link <?=((isset($nav_array[3])) ? 'bg-gradient-primary text-white' : '')?>" href="<?=$nav_url?>">
                        <i class="<?=$nav_class?> <?=((isset($nav_array[3])) ? 'text-white' : '')?>"></i> <?=$nav_title?>
                    </a>
                </li>
                <?php
                            }
                        }
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Main content -->
<div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark d-print-none" id="navbar-main" style="background: linear-gradient(-90deg, #0c0525 0%, transparent 109%);">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="#"><?=(isset($ui_navbar_title))?$ui_navbar_title:'Judul belum di isi'?></a>
            <!-- User -->
            <ul class="navbar-nav align-items-center d-none d-md-flex">
                <?php 
                    if (isset($ui_navbar_link)) {
                        if (is_array($ui_navbar_link)) {
                            foreach ($ui_navbar_link as $nav) {
                                $nav_array = explode('|', $nav);
                                $nav_title = $nav_array[0];
                                $nav_class = $nav_array[2];
                                $nav_url = site_url($nav_array[1]);
                ?>
                <li class="nav-item <?=((isset($nav_array[3])) ? $nav_array[3] : '')?>">
                    <a href="<?=$nav_url?>" class="nav-link text-sm">
                        <i class="<?=$nav_class?> mr-1"></i>
                        <?=$nav_title?>
                    </a>
                </li>
                <?php 
                            }
                        }
                    }
                ?>
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="<?=site_url($user_active['userdata']->avatar)?>">
                            </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold"><?=$user_active['userdata']->nama_lengkap?></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Masuk sebagai <?=$user_active['level']?></h6>
                        </div>
                        <div class="dropdown-divider"></div>
                        <?php 
                            $data_level = explode('|', $user_active['userdata']->level);
                            foreach ($data_level as $level) :
                                if ($user_active['level'] == $level) {
                                    $status = 'active';
                                }
                                else {
                                    $status = '';
                                }
                        ?>
                        <a href="<?=site_url('auth/redirect/' . $level)?>" class="dropdown-item <?=$status?>">
                            <span><?=ucfirst($level)?></span>
                        </a>
                        <?php 
                            endforeach;
                        ?>
                        <div class="dropdown-divider"></div>
                        <a href="<?=site_url('auth/logout')?>" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>