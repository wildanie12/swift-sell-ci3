<div class="main-panel">    
    <nav class="navbar navbar-default navbar-fixed">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?=$nav_brand?></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <?php 
                        foreach ($nav_links as $nav_link) {
                            $nav_obj = explode('|', $nav_link);

                            // Penentuan Status aktif
                            if ($nav_active == $nav_obj[0]) {
                                $active_state = 'active';
                            }
                            else {
                                $active_state = '';
                            }
                    ?>
                    <li class="<?=$active_state?>">
                        <a href="<?=base_url() . $nav_obj[1]?>">
                            <span class="<?=$nav_obj[2]?>"></span> 
                            <?=$nav_obj[0]?>
                        </a>
                    </li>
                    <?php 
                        } 
                    ?>

    				<li class="separator hidden-lg"></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user-circle"></i>
                            <?=$userdata->nama_lengkap?>
                        </a>
                        <div class="dropdown-area dropdown-menu">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="thumbnail">
                                        <img src="<?=site_url('assets/custom/images/user/'. $userdata->avatar)?>">
                                    </div>
                                </div>
                                <div class="col-md-7 text-center">
                                    <h4><?=$userdata->nama_lengkap?></h4>
                                    <div style="font-style: italic; margin-bottom: 4px" class="font-ubuntu"><?=ucfirst($userdata->level)?></div>
                                    <a href="<?=site_url('auth/logout')?>">Logout</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>