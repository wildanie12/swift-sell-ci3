<?php $this->view('template/header') ?>
    <div class="container">
        <div class="card card-container" style="margin-bottom: 10px !important; padding-bottom: 0 !important">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3 class="font-ubuntu text-center">Sign In</h3>
                    <p class="category italic">Silakan Sign in untuk mengakses sistem.</p>
                    <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
                    <!-- <h3 class="text-center font-ubuntu">LOGIN</h3> -->
                    <form class="form-signin" action="" id="login-form" method="post">
                        <span id="reauth-email" class="reauth-email"></span>
                        <input name="username" type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
                        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
                        <div id="error-display" class="text-danger text-center" style="display: none">
                            <strong>Error : </strong>
                            <span id="error-text"></span>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    
                                </div>
                            </div>
                        </div>
                    </form><!-- /form -->
                    <p class="form-text text-muted text-center" style="font-style: italic; font-size: 10pt"><i>Wildani Software &copy; 2017</i></p>
                </div>
            </div>
        </div><!-- /card-container -->
        <div class="card card-container" style="margin-top: 10px !important; padding: 10px !important">
            <div class="row">
                <div class="col-12 text-center">
                    <h4 style="margin-top:10px"><strong>User Demo</strong></h4>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Username</strong></td>
                            <td>:</td>
                            <td>admin</td>
                        </tr>
                        <tr>
                            <td><strong>Password</strong></td>
                            <td>:</td>
                            <td>admin</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /container --> 
<?php $this->view('template/js_script') ?>
<script type="text/javascript">
    var baseUrl = "<?=base_url()?>";
    $("#login-form").submit(function(e) {
        e.preventDefault();
        var params = {
            username: $("input[name='username']").val(),
            password: $("input[name='password']").val()
        }
        $.ajax({
            url: baseUrl + 'auth/do_login',
            type: 'POST',
            dataType: 'json',
            data: params,
        })
        .done(function(data) {
            console.log(data);
            errorDisplay = $("#error-display");
            errorText = $("#error-text");

            errorDisplay.hide();
            if (data.status == 'ERR_NOT_FOUND') {
                errorDisplay.show();
                errorText.html('Username tidak dapat ditemukan');
            }
            else if (data.status == 'ERR_PASS_INVALID') {
                errorDisplay.show();
                errorText.html('Password anda salah, silahkan hubungi administrator.');
            }
            else if (data.status == 'ERR_USER_BLOCKED') {
                errorDisplay.show();
                errorText.html('Pengguna diblokir, silahkan hubungi administrator.');
            }
            else if (data.status == 'OK') {
                Cookies.set('logged_username', data.username, {expires: 7});
                Cookies.set('logged_ciphertext', data.password, {expires: 7});
                Cookies.set('logged_user_level', data.level, {expires: 7});
                window.location = data.redirect_url;
            }
            console.log('Never');
        })
        
    })
</script>
<?php $this->view('template/footer') ?>