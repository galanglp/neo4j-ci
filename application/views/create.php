<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Neo4j</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?=base_url('assets/bootstrap/css/bootstrap.min.css');?>">
        <!-- Font Awesome Icons -->
        <link href="<?=base_url('assets/plugins/fontawesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link rel="stylesheet" href="<?=base_url('assets/dist/css/AdminLTE.min.css');?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?=base_url('assets/dist/css/AdminLTE.min.css');?>">
        <!-- iCheck -->
        <link href="<?=base_url('assets/plugins/iCheck/square/blue.css');?>" rel="stylesheet" type="text/css" />

    </head>
    <body class="login-page" id="background">
        <div class="login-box bg-green logo">
            <div class="login-logo logo-gambar">
                <img src="<?=base_url('assets/image/logo.png');?>" height="40%" width="40%" alt="User Image">
            </div><!-- /.login-logo -->
            <div id="namaApp">
                <center><h1><b>NEO4J</b></h1></center>
            </div>
            <div class="login-box-body">
                <!-- <p class="login-box-msg"><?php //$this->judul->textlogin(); ?> </p> -->
                <form action="<?php echo $action; ?>" method="post">
                            <?php echo json_encode($error); ?>
                    <!-- <div class="form-group has-feedback">
                     <select class="form-control" name="role" required="required">
                        <option value="">-Pilih Level</option>
                        <option value="akademik">Akademik</option>
                        <option value="kesiswaan">Kesiswaan</option>
                        <option value="bk">Bimbingan Konseling</option>
                        <option value="guru">Guru</option>
                        <option value="keuangan">Keuangan</option>
                        <option value="sms">SMS Gateway</option> -->
<!--                         <option value="perpus">Perpustakaan</option>-->
                        <!-- <option value="perpus">Perpustakaan</option> -->
                     <!--  </select>
                    </div>
 -->
                    <div class="form-group has-feedback">
                        <input type="text" name="penulis" class="form-control" placeholder="PENULIS"/>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="movie" class="form-control" placeholder="MOVIE"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="tahun" class="form-control" placeholder="TAHUN"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <a href='http://localhost/sifokol/slims2' class="btn btn-flat btn-box btn-info btn-warning">
                                <b>Masuk ke Perpustakaan</b>
                            </a>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
                        </div><!-- /.col -->
                    </div>
                </form>
                <hr>
            <div class="login-box-footer">
            <center>
            <!-- <a href='<?php echo site_url('kesiswaan/Con_Dashboard_Siswa')?>' class="btn btn-flat btn-box btn-info">
                <h5><b>Masukkan Data Siswa Baru</b></h5>
            </a> -->
            </center>
            </div>
            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

         <!-- jQuery 2.1.4 -->
        <script src="<?=base_url('assets/plugins/jQuery/jQuery-2.1.4.min.js');?>"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?=base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>

        <!-- iCheck -->
        <script src="<?=base_url('assets/plugins/iCheck/icheck.min.js');?>"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
