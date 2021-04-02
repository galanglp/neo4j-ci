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
                            <form role="form" method="post" action="<?php echo base_url('conguru/save'); ?>" id="form-body">
                                <input type="hidden" value="" name="id-guru"/>
                                <input type="hidden" value="" name="method"/> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>NIP</label>
                                            <input id="nip" name="nip" class="form-control" />
                                        </div>
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
                                    </div>
                                    <div class="col-md-6">
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
                             Daftar Guru
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-list">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NIP</th>
                                            <th>NAMA LENGKAP</th>
                                            <th>JENIS KELAMIN</th>
                                            <th>TEMPAT LAHIR</th>
                                            <th>TANGGAL LAHIR</th>
                                            <th>ALAMAT</th>
                                            <th>KOTA</th>
                                            <th>TELEPON</th>
                                            <th>EMAIL</th>
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
                "url": "<?php echo site_url('conguru/ajax_list')?>",
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
    function add_person()
    {
      $('#form-body')[0].reset(); // reset form on modals
      $('#form-hiden').attr('style','display:block;'); // show bootstrap modal
      $('#form-judul').text('Tambah Guru'); // Set Title to Bootstrap modal title
      $('[name="method"]').val('save');
    }
    function batal(){
        $('#form-hiden').attr('style','display:none;');
    }
    function edit_guru(identifier){
        $('#form-body')[0].reset(); // reset form on modals
        $('#form-hiden').attr('style','display:block;'); // show bootstrap modal
        $('#form-judul').text('Edit Guru'); // Set Title to Bootstrap modal title

        $('[name="method"]').val('edit');
        $('[name="id-guru"]').val($(identifier).data('idguru'));
        $('[name="nip"]').val($(identifier).data('nip'));
        $('[name="nama"]').val($(identifier).data('nama'));
        $('[name="id-kelamin"]').val($(identifier).data('idkelamin'));
        $('[name="jenisKelamin"]').val($(identifier).data('kelamin'));
        $('[name="tempatLahir"]').val($(identifier).data('tempat'));
        $('[name="id-tanggalLahir"]').val($(identifier).data('idtanggallahir'));
        $('[name="tanggalLahir"]').val($(identifier).data('tanggal'));
        $('[name="id-alamat"]').val($(identifier).data('idalamat'));
        $('[name="alamat"]').val($(identifier).data('alamat'));
        $('[name="kota"]').val($(identifier).data('kota'));
        $('[name="telepon"]').val($(identifier).data('telepon'));
        $('[name="email"]').val($(identifier).data('email'));
    }
</script>


</body>
</html>
