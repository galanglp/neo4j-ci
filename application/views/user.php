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
                            <form role="form" method="post" action="<?php echo base_url('conuser/save'); ?>" id="form-body">
                                <input type="hidden" value="" name="id"/>
                                <input type="hidden" value="" name="method"/> 
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>User</label>
                                            <input id="user" name="user" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="form-group input-group">
                                            <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password" />
                                            <span class="btn input-group-addon" title="tampilkan" id="span-password" onclick="tampilkan()"><i id="i-password" class="fa fa-eye-slash"  ></i></span>
                                          </div>
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
                             Daftar User
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-list">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>USER</th>
                                            <th>ROLE</th>
                                            <th>SETTING</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
    var table;
    $(document).ready(function() {
        table = $('#table-list').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('conuser/ajax_list')?>",
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
      $('#form-judul').text('Tambah User'); // Set Title to Bootstrap modal title
      $('[name="method"]').val('save');
    }
    function batal(){
        $('#form-hiden').attr('style','display:none;');
    }
    function edit_user(identifier){
        $('#form-body')[0].reset(); // reset form on modals
        $('#form-hiden').attr('style','display:block;'); // show bootstrap modal
        $('#form-judul').text('Edit User'); // Set Title to Bootstrap modal title

        $('[name="method"]').val('edit');
        $('[name="id"]').val($(identifier).data('id'));
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
