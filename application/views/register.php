<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BPMN-Q With Neo4j</title>
  <!-- BOOTSTRAP STYLES-->
  <link href="<?php echo base_url('assets');?>/binary/assets/css/bootstrap.css" rel="stylesheet" />
  <!-- FONTAWESOME STYLES-->
  <link href="<?php echo base_url('assets');?>/binary/assets/css/font-awesome.css" rel="stylesheet" />
  <!-- CUSTOM STYLES-->
  <link href="<?php echo base_url('assets');?>/binary/assets/css/custom.css" rel="stylesheet" />
  <!-- GOOGLE FONTS-->
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
    <div class="container">
        <div class="row text-center  ">
            <div class="col-md-12">
                <br /><br />
                <h2> Pendaftaran Siswa Baru </h2>
               
                <h5>( Pendaftaran Siswa Baru )</h5>
                 <br />
            </div>
        </div>

         <div class="row">
               
                <!-- <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1"> -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                        <strong>  Pendaftaran Siswa Baru </strong>
                            </div>
                            <?php if ($message == "gagal") {
                                echo '<div class="alert alert-danger" id="alert" align="center">Register '.$message.'</div>';
                              }?>
                            <div class="panel-body">
                                <form role="form" method="post" action="<?php echo base_url($action); ?>">
                                    <br/>
                                        <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <input id="nama" name="nama" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Jenis Kelamin</label>
                                            <input type="hidden" value="" name="id-kelamin"/>
                                            <select class="form-control" name="jenisKelamin" id="jenisKelamin">
                                                <option value="Laki-Laki" >Laki-Laki</option>
                                                <option value="Perempuan" >Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Tempat Lahir</label>
                                                    <input id="tempatLahir" name="tempatLahir" class="form-control" />
                                                </div>
                                                <div class="col-md-8">
                                                    <label>Tanggal Lahir</label>
                                                    <input type="hidden" value="" name="id-tanggalLahir"/>
                                                    <input type="text" name="tanggalLahir" id="tanggalLahir" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Agama</label>
                                            <input type="hidden" value="" name="id-agama"/>
                                            <input id="agama" name="agama" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Anak Ke</label>
                                                    <input id="anakKe" name="anakKe" class="form-control" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Dari</label>
                                                    <input id="dari" name="dari" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                          <label>Username</label>
                                          <div class="form-group input-group">
                                              <span class="input-group-addon"><i class="fa fa-user"  ></i></span>
                                              <input type="text" class="form-control" placeholder="Username" name="user" />
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label>Password</label>
                                          <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password" />
                                            <span class="btn input-group-addon" title="tampilkan" id="span-password" onclick="tampilkan()"><i id="i-password" class="fa fa-eye-slash"  ></i></span>
                                          </div>
                                        </div>
                                        <input class="btn btn-success" type="submit" value="Daftar" />
                                        <hr />
                                        Sudah mendaftar ?  <a href="<?php echo base_url('Login');?>" >Login here</a>
                                      </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input id="alamat" name="alamat" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Kota</label>
                                            <input type="hidden" value="" name="id-alamat"/>
                                            <input id="kota" name="kota" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Telepon</label>
                                            <input id="telepon" name="telepon" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input id="email" name="email" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nama Ayah</label>
                                            <input type="hidden" value="" name="id-ayah"/>
                                            <input id="ayah" name="ayah" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Ibu</label>
                                            <input type="hidden" value="" name="id-ibu"/>
                                            <input id="ibu" name="ibu" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat Ortu</label>
                                            <input id="alamatOrtu" name="alamatOrtu" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Telepon Ortu</label>
                                            <input id="teleponOrtu" name="teleponOrtu" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Pekerjaan Ayah</label>
                                            <input type="hidden" value="" name="id-profesiAyah"/>
                                            <input id="pekerjaanAyah" name="pekerjaanAyah" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Pekerjaan Ibu</label>
                                            <input type="hidden" value="" name="id-profesiIbu"/>
                                            <input id="pekerjaanIbu" name="pekerjaanIbu" class="form-control" />
                                        </div>
                                    </div>
                                    </form>
                            </div>
                           
                        </div>
                    <!-- </div> -->
                
                
        </div>
    </div>


     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
  <!-- JQUERY SCRIPTS -->
  <script src="<?php echo base_url('assets');?>/binary/assets/js/jquery-1.10.2.js"></script>
  <!-- BOOTSTRAP SCRIPTS -->
  <script src="<?php echo base_url('assets');?>/binary/assets/js/bootstrap.min.js"></script>
  <!-- METISMENU SCRIPTS -->
  <script src="<?php echo base_url('assets');?>/binary/assets/js/jquery.metisMenu.js"></script>
  <!-- CUSTOM SCRIPTS -->
  <script src="<?php echo base_url('assets');?>/binary/assets/js/custom.js"></script>
  <script type="text/javascript">
      function tampilkan() {
        if ($("#password").prop("type")=="password") {
            $("#password").prop("type","text");
            $("#span-password").prop("title","sembunyikan");
            $("#i-password").prop("class","fa fa-eye");
        }else{
            $("#password").prop("type","password");
            $("#span-password").prop("title","tampilkan");
            $("#i-password").prop("class","fa fa-eye-slash");
        }
      }

      window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
      });
    }, 5000);
  </script>
   
</body>
</html>
