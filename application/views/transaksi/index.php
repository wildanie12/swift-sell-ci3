<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-transaksi.jpg')?>') 0 -150px/100% no-repeat !important; -webkit-filter: brightness(80%) contrast(140%); filter: brightness(80%) contrast(140%);">
    <div class="container-fluid">
        <div class="header-body">
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 text-center">Data Center</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12" style="padding-bottom: 70px">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 class="text-center">Selamat datang di data center, anda berhak untuk mengakses data berikut:</h4>
                                </div>
                            </div>
                            <div class="row justify-content-around mt-3">
                                <?php 
                                $item_count = sizeof($ui_navbar_link);
                                $col_size = 12 / $item_count;
                                ?>
                                <?php 
                                foreach ($ui_navbar_link as $nav_link) {
                                    $nav = explode('|', $nav_link);
                                    ?>
                                    <a href="<?=site_url($nav[1])?>" class="col-sm-auto">

                                        <div class="col-sm">
                                            <h5 class="text-center" style="font-size: 48pt"><i style='width: 100px' class="<?=$nav[2]?>"></i></h5>
                                            <h4 class="text-center" style="margin: 0"><?=$nav[0]?></h4>
                                        </div>
                                    </a>
                                    <?php 
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->view('argon/js_script')?>
<script type="text/javascript">
</script>
<?php $this->view('argon/footer')?>
