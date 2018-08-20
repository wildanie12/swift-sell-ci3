
        </div>
    </div>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="<?=site_url('assets/argon/vendor/jquery/dist/jquery.min.js')?>"></script>
    <script src="<?=site_url('assets/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')?>"></script>
    <!-- Optional JS -->
    <script src="<?=site_url('assets/argon/vendor/chart.js/dist/Chart.min.js')?>"></script>
    <script src="<?=site_url('assets/argon/vendor/chart.js/dist/Chart.extension.js')?>"></script>
    <script src="<?=site_url('assets/custom/js/default.js')?>"></script>

    <!-- Dynamic CSS Source -->
    <?php 
        if (isset($ui_js)) {
            if (is_array($ui_js)) {
                foreach ($ui_js as $js) {
                    echo "<script src='" .site_url('assets/' .$js). "'></script>";
                }
            }
            else {
                echo "<script src='" .site_url('assets/' .$js). "'></script>";
            }
        }
    ?>
    <!-- Argon JS -->
    <script src="<?=site_url('assets/argon/js/argon.js?v=1.0.0')?>"></script>
    <!-- Argon JS -->
