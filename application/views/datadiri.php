<div class="panel panel-default">
  <div class="panel-heading">
    <strong>  Data Diri </strong>
  </div>
  <div class="panel-body">
    <div class="row">
        <br/>
        <div class="col-md-4">
          <div class="form-group">
            <label>Nama Lengkap :</label>
            <span><?=$dataDiri[0]['nama']?></span>
          </div>
          <div class="form-group">
            <label>Jenis Kelamin :</label>
            <span><?=$dataDiri[0]['kelamin']?></span>
          </div>
          <div class="form-group">
            <label>Tempat Lahir :</label>
            <span><?=$dataDiri[0]['tempatLahir']?></span>
          </div>
          <div class="form-group">
            <label>Tanggal Lahir :</label>
            <span><?=$dataDiri[0]['tanggalLahir']?></span>
          </div>
          <div class="form-group">
            <label>Agama :</label>
            <span><?=$dataDiri[0]['agama']?></span>
          </div>
          <div class="form-group">
            <label>Anak Ke :</label>
            <span><?=$dataDiri[0]['anakKe']?></span>
            <label>Dari :</label>
            <span><?=$dataDiri[0]['dari']?> Bersaudara</span>
          </div>
          <div class="form-group">
            <label>Status :</label>
            <?php
              switch ($dataDiri[0]['status']) {
                case 'Belum Lolos':
                  echo '<span class="label label-danger">'.$dataDiri[0]['status'].'</span>';
                  break;
                case 'Lolos':
                  echo '<span class="label label-success">Siswa</span>';
                  break;
                case 'Alumni':
                  echo '<span class="label label-info">'.$dataDiri[0]['status'].'</span>';
                  break;
                case 'Pendaftar':
                  echo '<span class="label label-warning">'.$dataDiri[0]['status'].'</span>';
                  break;
                
                default:
                  # code...
                  break;
              }
            ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Alamat :</label>
            <span><?=$dataDiri[0]['alamt']?></span>
          </div>
          <div class="form-group">
            <label>Kota :</label>
            <span><?=$dataDiri[0]['kota']?></span>
          </div>
          <div class="form-group">
            <label>Telepon :</label>
            <span><?=$dataDiri[0]['telepon']?></span>
          </div>
          <div class="form-group">
            <label>Email :</label>
            <span><?=$dataDiri[0]['email']?></span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Nama Ayah :</label>
            <span><?=$dataDiri[0]['ayah']?></span>
          </div>
          <div class="form-group">
            <label>Nama Ibu :</label>
            <span><?=$dataDiri[0]['ibu']?></span>
          </div>
          <div class="form-group">
            <label>Alamat Ortu :</label>
            <span><?=$dataDiri[0]['alamatOrtu']?></span>
          </div>
          <div class="form-group">
            <label>Telepon Ortu :</label>
            <span><?=$dataDiri[0]['teleponOrtu']?></span>
          </div>
          <div class="form-group">
            <label>Pekerjaan Ayah :</label>
            <span><?=$dataDiri[0]['profesiAyah']?></span>
          </div>
          <div class="form-group">
            <label>Pekerjaan Ibu :</label>
            <span><?=$dataDiri[0]['profesiIbu']?></span>
          </div>
        </div>
    </div>

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
