<?php $this->view('argon/header')?>
<?php $this->view('argon/navigation')?>
<div class="header bg-gradient-danger pb-8 pt-5 pt-md-8" style="background: url('<?=site_url('assets/custom/images/header-data.jpg')?>') 0 -150px/100% no-repeat !important; -webkit-filter: brightness(111%) contrast(80%); filter: brightness(111%) contrast(80%);">
   <div class="container-fluid">
      <div class="header-body">
      </div>
   </div>
</div>
<div class="container-fluid mt--7">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <div class="col-sm-12" style="padding-bottom: 70px">
                     <div class="row mb-5">
                        <div class="col-sm-12">
                           <h3 class="text-center">Selamat datang di data center, anda berhak untuk mengakses data berikut:</h3>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col">
                           <?php 
                              $item_count = sizeof($ui_navbar_link);
                              $col_size = 12 / $item_count;
                           ?>
                           <div class="row">
                              <?php 
                                 foreach ($ui_navbar_link as $nav_link) {
                                    $nav = explode('|', $nav_link);
                              ?>
                              <a href="<?=site_url($nav[1])?>" class="col">
                                 <div class="col-12">
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
   </div>
</div>

<?php $this->view('argon/js_script')?>
<script type="text/javascript">
</script>
<?php $this->view('argon/footer')?>
