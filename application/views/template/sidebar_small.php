<?php 
    if (isset($sidebar_menu)) {

        $dashboard = '';
        $d_dash = '';
        $d_control = '';

        $data = "";
        
        $barang = "";
        $harga = "";
        $supplier = "";
        $kategori = ""; 
        $user = "";

        $transaksi = "";

        $jual = "";
        $beli = "";

        $laporan = "";

        $l_jual = "";
        $l_beli = "";
        $l_barang = "";
        $l_harga = "";
        $l_supplier = "";
        $l_user = "";

        $statistik = "";

        $s_jual = "";
        $s_beli = "";


        $pengaturan = "";
        $p_utama = "";
        switch ($sidebar_menu) {
            case 'dashboard':
                $dashboard = 'active';
                switch ($sidebar_submenu) {
                    case 'dashboard':
                        $d_dash = 'active';
                        break;
                    case 'control_panel':
                        $d_control = 'active';
                        break;
                }
                break;
            case 'data':
                $data = 'active';

                switch ($sidebar_submenu) {
                    case 'barang':
                        $barang = 'active';
                        break;
                    case 'harga':
                        $harga = 'active';
                        break;
                    case 'supplier':
                        $supplier = 'active';
                        break;
                    case 'kategori':
                        $kategori = 'active';
                        break;
                    case 'user':
                        $user = 'active';
                        break;
                }
                break;

            case 'transaksi':
                $transaksi = 'active';

                switch ($sidebar_submenu) {
                    case 'jual':
                        $jual = 'active';
                        break;

                    case 'beli':
                        $beli = 'active';
                        break;
                }
                break;

            case 'laporan':
                $laporan = 'active';
                switch ($sidebar_submenu) {
                    case 'jual':
                        $l_jual = 'active';
                        break;

                    case 'beli':
                        $l_beli = 'active';
                        break;

                    case 'barang':
                        $l_barang = 'active';
                        break;
                    case 'harga':
                        $l_harga = 'active';
                        break;
                    case 'supplier':
                        $l_supplier = 'active';
                        break;

                    case 'user':
                        $l_user = 'active';
                        break;
                }
                break;

            case 'statistik':
                $statistik = 'active';
                switch ($sidebar_submenu) {
                    case 'jual':
                        $s_jual = 'active';
                        break;

                    case 'beli':
                        $s_beli = 'active';
                        break;
                }
                break;

            case 'pengaturan':
                $pengaturan = 'active';
                switch ($sidebar_submenu) {
                    case 'utama':
                        $p_utama = 'active';
                        break;
                }
                break;
        }
    }

?>
<?php
    $nama_toko = $this->db->get_where('tb_config', array('nama' => 'nama_toko'))->row()->value_char;
    $alamat = $this->db->get_where('tb_config', array('nama' => 'alamat'))->row()->value_text;
    $logo = $this->db->get_where('tb_config', array('nama' => 'logo'))->row()->value_text;
?>

<div class="col-xs-1 sidebar hidden-print">
    <div class="sidebar-header" style="display: none">
        <div class="row" style="padding:10px">
            <img class="col-xs-5" src="<?=base_url()?>assets/wn-apotek/images/<?=$logo?>">
            <div class="col-xs-7 no-padding">
                <h4 style="margin-top: 25px"><?=$nama_toko?></h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <ul class="nav nav-pills nav-stacked" role="tab" id="headingOne">
                    <li class="parent-menu <?=$dashboard?>">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#dashboard">
                            <span class="glyphicon glyphicon-dashboard"></span> 
                            Dashboard
                        </a>
                    </li>
                </ul>
                <div id="dashboard" class="panel-collapse <?=($dashboard=='active')?'collapse in' : 'collapse'?>" role="tabpanel">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="<?=$d_dash?>"><a href="<?=base_url()?>dashboard"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
                        <li class="<?=$d_control?>"><a href="<?=base_url()?>dashboard/menu"><span class="glyphicon glyphicon-cog"></span> Control panel</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <ul class="nav nav-pills nav-stacked" role="tab" id="headingOne">
                    <li class="parent-menu <?=$data?>">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <span class="glyphicon glyphicon-file"></span> 
                            Data Master
                        </a>
                      </li>
                  </ul>
                  <div id="collapseOne" class="panel-collapse <?=($data=='active')?'collapse in' : 'collapse'?>" role="tabpanel" aria-labelledby="headingOne">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="<?=$barang?>"><a href="<?=base_url()?>data/barang"><span class="glyphicon glyphicon-th"></span> Barang</a></li>
                        <li class="<?=$harga?>"><a href="<?=base_url()?>data/harga"><span class="glyphicon glyphicon glyphicon-euro"></span> harga</a></li>
                        <li class="<?=$kategori?>"><a href="<?=base_url()?>data/kategori"><span class="glyphicon glyphicon-tag"></span> Kategori</a></li>
                        <li class="<?=$supplier?>"><a href="<?=base_url()?>data/supplier"><span class="glyphicon glyphicon-home"></span> Supplier</a></li>
                        <li class="<?=$user?>"><a href="<?=base_url()?>data/user"><span class="glyphicon glyphicon-user"></span> User</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <ul class="nav nav-pills nav-stacked">
                    <li class="parent-menu <?=$transaksi?>">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <span class="glyphicon glyphicon-refresh"> </span>
                            Transaksi
                        </a>
                    </li>
                </ul>
                <div id="collapseTwo" class="panel-collapse <?=($transaksi=='active')?'collapse in' : 'collapse'?>" role="tabpanel" aria-labelledby="headingTwo">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="<?=$beli?>"><a href="<?=site_url('transaksi/beli')?>"><span class="glyphicon glyphicon glyphicon-import"> </span>Beli</a></li>
                        <li class="<?=$jual?>"><a href="<?=site_url('transaksi/jual')?>"><span class="glyphicon glyphicon glyphicon glyphicon-shopping-cart"> </span>Jual</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel panel-default">
                <ul class="nav nav-pills nav-stacked">
                    <li class="parent-menu <?=$laporan?>" >
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#laporan" aria-expanded="false" aria-controls="collapseThree">
                            <span class="glyphicon glyphicon-list-alt"> </span>
                            Laporan
                        </a>
                    </li>
                </ul>
                <div id="laporan" class="panel-collapse <?=($laporan=='active')?'collapse in' : 'collapse'?>" role="tabpanel" aria-labelledby="headingThree">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="<?=$l_jual?>"><a href="<?=site_url('laporan/jual')?>"><span class="glyphicon glyphicon-export"> </span>Penjualan</a></li>
                        <li class="<?=$l_beli?>"><a href="<?=site_url('laporan/beli')?>"><span class="glyphicon glyphicon-import"> </span>Pembelian</a></li>
                        <li class="<?=$l_barang?>"><a href="<?=site_url('laporan/barang')?>"><span class="glyphicon glyphicon-th"> </span>Barang</a></li>
                        <li class="<?=$l_harga?>"><a href="<?=site_url('laporan/harga')?>"><span class="glyphicon glyphicon-scissors"> </span>harga</a></li>
                        <li class="<?=$l_supplier?>"><a href="<?=site_url('laporan/supplier')?>"><span class="glyphicon glyphicon-home"> </span>Supplier</a></li>
                        <li class="<?=$l_user?>"><a href="<?=site_url('laporan/user')?>"><span class="glyphicon glyphicon-user"> </span>User</a></li>
                    </ul>
                </div>
            </div>

            <div class="panel panel-default">
                <ul class="nav nav-pills nav-stacked">
                    <li class="parent-menu <?=$statistik?>" >
                        <a class="collapsed" role="button" data-toggle="collapse" href="#statistik" data-parent="#accordion">
                            <span class="glyphicon glyphicon-stats"> </span>
                            Statistik
                        </a>
                    </li>
                </ul>
                <div id="statistik" class="panel-collapse <?=($statistik=='active')?'collapse in' : 'collapse'?>" role="tabpanel">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="<?=$s_jual?>"><a href="<?=site_url('statistik/penjualan')?>"><span class="glyphicon glyphicon-export"> </span>Penjualan</a></li>
                        <li class="<?=$s_beli?>"><a href="<?=site_url('statistik/pembelian')?>"><span class="glyphicon glyphicon-import"> </span>Pembelian</a></li>
                    </ul>
                </div>
            </div>

            <div class="panel panel-default">
                <ul class="nav nav-pills nav-stacked">
                    <li class="parent-menu <?=$pengaturan?>" >
                        <a class="collapsed" role="button" data-toggle="collapse" href="#pengaturan" data-parent="#accordion">
                            <span class="glyphicon glyphicon-cog"> </span>
                            Pengaturan
                        </a>
                    </li>
                </ul>
                <div id="pengaturan" class="panel-collapse <?=($pengaturan=='active')?'collapse in' : 'collapse'?>" role="tabpanel">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="<?=$p_utama?>"><a href="<?=site_url('pengaturan')?>"><span class="glyphicon glyphicon-cog"> </span>Pengaturan Utama</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>