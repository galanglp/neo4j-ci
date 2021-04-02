        <div id="page-wrapper" >
            <div id="page-inner">
             <!-- /. ROW  -->
             <hr />
             <div class="panel" align="right">
                 <button class="fa fa-plus btn btn-success" onclick="add_person()"></button>
             </div>
             <div class="row" style="display: none;" id="form-hiden">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading" id="form-judul">
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" action="<?php echo base_url('consiswa/save'); ?>" id="form-body">
                                <input type="hidden" value="" name="id-siswa"/>
                                <input type="hidden" value="" name="method"/> 
                                <div class="row">
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
                                              <input type="hidden" value="" name="id-user"/>
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
                                        <div class="form-group">
                                            <label>Status</label>
                                            <input type="hidden" value="" name="id-status"/>
                                            <select class="form-control" name="status" id="status">
                                                <option value="Lolos" >Lolos</option>
                                                <option value="Belum Lolos" >Belum Lolos</option>
                                                <option value="Alumni" >Alumni</option>
                                            </select>
                                        </div>
                                        <div class="form-group" align="right">
                                            <button type="button" onclick="batal()" class="btn btn-default">Batal</button>
                                            <button type="submit" value="Simpan" name="simpan" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- End Form Elements -->
                    </div>
                </div>
            </div>
            <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Daftar Siswa
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-list">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NAMA LENGKAP</th>
                                            <th>JENIS KELAMIN</th>
                                            <th>TEMPAT LAHIR</th>
                                            <th>TANGGAL LAHIR</th>
                                            <th>AGAMA</th>
                                            <th>SAUDARA</th>
                                            <th>ALAMAT</th>
                                            <th>KOTA</th>
                                            <th>TELEPON</th>
                                            <th>EMAIL</th>
                                            <th>NAMA AYAH</th>
                                            <th>NAMA IBU</th>
                                            <th>ALAMAT ORTU</th>
                                            <th>TELEPON ORTU</th>
                                            <th>PEKERJAAN AYAH</th>
                                            <th>PEKERJAAN IBU</th>
                                            <th>STATUS</th>
                                            <th>SETTING</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- <?php foreach ($data as $key => $value) { ?>
                                            <tr>
                                                <td><?php echo $value[0]?></td>
                                                <td><?php echo $value[1]?></td>
                                                <td><?php echo $value[2]?></td>
                                                <td><?php echo $value[3]?></td>
                                                <td><?php echo $value[4]?></td>
                                                <td><?php echo $value[5]?></td>
                                                <td><?php echo $value[6]?></td>
                                                <td><?php echo $value[7]?></td>
                                                <td><?php echo $value[8]?></td>
                                                <td><?php echo $value[9]?></td>
                                                <td><?php echo $value[10]?></td>
                                                <td><?php echo $value[11]?></td>
                                                <td><?php echo $value[12]?></td>
                                                <td><?php echo $value[13]?></td>
                                                <td><?php echo $value[14]?></td>
                                                <td><?php echo $value[15]?></td>
                                                <td><?php echo $value[16]?></td>
                                                <td><?php echo $value[17]?></td>
                                            </tr>
                                        <?php } ?> -->
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
            <!--End Advanced Tables -->
            <!-- /. ROW  -->
            <!-- /. ROW  -->

        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="<?php echo base_url('assets');?>/binary/assets/js/jquery-1.10.2.js"></script>
<script src="<?php echo base_url('assets');?>/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="<?php echo base_url('assets');?>/binary/assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="<?php echo base_url('assets');?>/binary/assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="<?php echo base_url('assets');?>/binary/assets/js/custom.js"></script>
<script src="<?php echo base_url('assets');?>/binary/assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url('assets');?>/binary/assets/js/dataTables/dataTables.bootstrap.js"></script>
<script type="text/javascript">
    $(function(){
        $('#tanggalLahir').datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            changeYear: true,
            changeMonth: true,
            yearRange: "-100:+0",
        });
    });

    var table;
    $(document).ready(function() {
        table = $('#table-list').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('consiswa/ajax_list')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
            },
            ],

        });
    });
</script>
<script type="text/javascript">
    // var table;
    // $(document).ready(function() {
    //     $('#table-list').DataTable({
    //         "columnDefs": [
    //             { 
    //                 "targets": [ -1,0 ], //last column
    //                 "orderable": false, //set not orderable
    //             },
    //             ],
    //         });
    // });
</script>
<script type="text/javascript">
    function add_person()
    {
      $('#form-body')[0].reset(); // reset form on modals
      $('#form-hiden').attr('style','display:block;'); // show bootstrap modal
      $('#form-judul').text('Tambah Siswa'); // Set Title to Bootstrap modal title
      $('[name="method"]').val('save');
    }
    function batal(){
        $('#form-hiden').attr('style','display:none;');
    }
    function edit_siswa(identifier){
        $('#form-body')[0].reset(); // reset form on modals
        $('#form-hiden').attr('style','display:block;'); // show bootstrap modal
        $('#form-judul').text('Edit Siswa'); // Set Title to Bootstrap modal title

        $('[name="method"]').val('edit');
        $('[name="id-siswa"]').val($(identifier).data('idsiswa'));
        $('[name="nama"]').val($(identifier).data('nama'));
        $('[name="id-kelamin"]').val($(identifier).data('idkelamin'));
        $('[name="jenisKelamin"]').val($(identifier).data('kelamin'));
        $('[name="id-tanggalLahir"]').val($(identifier).data('idtanggallahir'));
        $('[name="tempatLahir"]').val($(identifier).data('tempat'));
        $('[name="tanggalLahir"]').val($(identifier).data('tanggal'));
        $('[name="id-agama"]').val($(identifier).data('idagama'));
        $('[name="agama"]').val($(identifier).data('agama'));
        $('[name="anakKe"]').val($(identifier).data('anakke'));
        $('[name="dari"]').val($(identifier).data('dari'));
        $('[name="id-alamat"]').val($(identifier).data('idalamat'));
        $('[name="alamat"]').val($(identifier).data('alamat'));
        $('[name="kota"]').val($(identifier).data('kota'));
        $('[name="telepon"]').val($(identifier).data('telepon'));
        $('[name="email"]').val($(identifier).data('email'));
        $('[name="id-ayah"]').val($(identifier).data('idayah'));
        $('[name="ayah"]').val($(identifier).data('ayah'));
        $('[name="id-ibu"]').val($(identifier).data('idibu'));
        $('[name="ibu"]').val($(identifier).data('ibu'));
        $('[name="alamatOrtu"]').val($(identifier).data('alamatortu'));
        $('[name="teleponOrtu"]').val($(identifier).data('teleponortu'));
        $('[name="id-profesiAyah"]').val($(identifier).data('idprofesiayah'));
        $('[name="pekerjaanAyah"]').val($(identifier).data('pekerjaanayah'));
        $('[name="id-profesiIbu"]').val($(identifier).data('idprofesiibu'));
        $('[name="pekerjaanIbu"]').val($(identifier).data('pekerjaanibu'));
        $('[name="id-status"]').val($(identifier).data('idstatus'));
        $('[name="status"]').val($(identifier).data('status'));
        $('[name="id-user"]').val($(identifier).data('iduser'));
        $('[name="user"]').val($(identifier).data('user'));
        $('[name="password"]').val($(identifier).data('password'));
    }

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
</script>


</body>
</html>
