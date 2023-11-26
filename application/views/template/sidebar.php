
<div class="sidebar" data-color="<?=$app_theme?>" data-image="" style="background: url('<?=base_url()?>assets/light-bootstrap-dashboard/images/sidebar-6.png')">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="<?=base_url()?>" class="simple-text">
                <?=$sidebar_title?>
            </a>
        </div>

        <ul class="nav">
            <?php 
                foreach ($sidebar_links as $sidebar_link) {
                    $sidebar_obj = explode('|', $sidebar_link);

                    // Status Aktif
                    if ($sidebar_active == $sidebar_obj[0]) {
                        $active_state = 'active';
                    }
                    else {
                        $active_state = '';
                    }
            ?>
            <li class="<?=$active_state?>">
                <a href="<?=base_url(). $sidebar_obj[1]?>">
                    <i class="<?=$sidebar_obj[2]?>"></i>
                    <p><?=$sidebar_obj[0]?></p>
                </a>
            </li>
            <?php 
                }
            ?>
           
        </ul>
    </div>
</div>