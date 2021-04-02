        <div id="page-wrapper" >
            <div id="page-inner">
               <!-- /. ROW  -->
               <hr />
               <?php
                if ($error!=null) {
                    if ($error=="The file has been uploaded") {
                        echo '<div class="alert alert-success" id="alert">
                            <a href="#" class="alert-link">'.$error.'</a>.
                        </div>';
                    }else{
                        echo '<div class="alert alert-danger" id="alert">
                            <a href="#" class="alert-link">'.$error.'</a>.
                        </div>';
                    }
                }
               ?>
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            BPMN-Q for Searching
                        </div>
                        <div class="panel-body">
                            <form role="form" id="form" method="post" action="<?php echo base_url('main/cypher')?>" enctype="multipart/form-data">
                                    <div class="col-md-4">
                                        <div  class="form-group">
                                            <input id="fileVdx" name="fileVdx" type="file" />
                                            <label>.VDX</label>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="btnSave" onclick="search()" class="btn btn-primary">Search</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                        <!-- End Form Elements -->
                    </div>
                </div>
            </div>
            <div class="panel" align="right">
                <button class="fa fa-plus btn btn-success" onclick="add_person()"></button>
            </div>
               <div class="row" style="display: none;" id="form-hiden">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading" id="form-judul">
                            INPUT WORKFLOW
                        </div>
                        <div class="panel-body">
                            <form role="form" action="<?php echo base_url('main/save');?>" method="post" enctype="multipart/form-data" id="form-body">
                                <input type="hidden" value="" name="id"/>
                                <input type="hidden" value="" name="method"/> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nama Workflow</label>
                                            <input id="workflow" name="workflow" class="form-control" />
                                        </div>
                                        <div style="display: block;" class="form-group" id="fileflow">
                                            <input id="fileWorkflow" name="fileWorkflow" type="file" />
                                            <label>.XPDL</label>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" onclick="batal()" class="btn btn-default">Batal</button>
                                            <input type="submit" value="Simpan" name="simpan" class="btn btn-primary"/>
                                        </div>
                                    </div>
                            </form>
                        </div>
                        <!-- End Form Elements -->
                    </div>
                </div>
            </div>
            <!-- /. ROW  -->
            <!-- /. ROW  -->
            <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Daftar Workflow
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="table-list">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>JUDUL</th>
                                            <th>PENULIS</th>
                                            <th>TANGGAL DIBUAT</th>
                                            <th>TANGGAL MODIFIKASI</th>
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
            <!--  Modals-->
                        <div class="panel-body">
                            <div class="modal fade" id="view-bpmn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel"></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="bpmn" style="height:500px; background-color: #DAE4E4;>
                                                
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <!-- End Modals-->
        </div>
        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="<?php echo base_url('assets');?>/binary/assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="<?php echo base_url('assets');?>/binary/assets/js/bootstrap.min.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="<?php echo base_url('assets');?>/binary/assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="<?php echo base_url('assets');?>/binary/assets/js/custom.js"></script>
<script src="<?php echo base_url('assets');?>/binary/assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?php echo base_url('assets');?>/binary/assets/js/dataTables/dataTables.bootstrap.js"></script>
<!-- GOJS SCRIPTS -->
<script src="<?php echo base_url('assets');?>/gojs/go.js"></script>
<script type="text/javascript">
    var table;
    var GO = go.GraphObject.make;
    var diagram = GO(go.Diagram, "bpmn",
  {
    contentAlignment: go.Spot.Center,
  }
);;
    // The "simple" template just shows the key string and the color in the background.
    var simpletemplate =
    GO(go.Node, "Auto",
      GO(go.Panel, "Auto",
        GO(go.Shape, 
          new go.Binding("figure", "bentuk"),
          new go.Binding("fill", "color")),
        GO(go.TextBlock,
          new go.Binding("text", "nama"),
          new go.Binding("width", "width"),
          {overflow: go.TextBlock.OverflowClip /* the default value */,// No max lines
            margin: 2}
          )
        )
      );
    var linktemplate = 
    GO(go.Link,
      GO(go.Shape),  // the link shape
      GO(go.Shape,   // the arrowhead
        { toArrow: "Standard"}),
      GO(go.TextBlock, 
        new go.Binding("text", "relation"),
        { segmentOffset: new go.Point(0, -10) },
        ),
    );
    $(document).ready(function() {
        table = $('#table-list').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('main/ajax_list')?>",
                "type": "POST"
            },
            "columnDefs": [
            { 
                    "targets": [ -1,0 ], //last column
                    "orderable": false, //set not orderable
                },
                ],
            });
    });

$('#view-bpmn').on('shown.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var start = button.data('start')
    var end = button.data('end') 
    var judul = button.data('judul') 

    var modal = $(this)
    modal.find('#myModalLabel').text(judul)

    diagram.model.nodeDataArray = [];
    diagram.model.linkDataArray = [];

  diagram.layout = GO(go.LayeredDigraphLayout,
  {direction : 90}
    );
  $.ajax({
        url : "<?php echo site_url('conbpmn/get_bpmn')?>",
        type: "POST",
        data : "start="+start+"&end="+end,
        dataType: 'json',
        success: function(data)
        {
          for (var i = 0; i < data.activity.length; i++) {
            diagram.model.addNodeData(data.activity[i]);
          }
          for (var j = 0; j < data.transisi.length; j++) {
              diagram.model.addLinkData(data.transisi[j]);
          }

          console.log(diagram.model.nodeDataArray);
          console.log(diagram.model.linkDataArray);
          // Set title to Bootstrap modal title
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error get data from ajax');
          }
        });
  // initially use the detailed templates
  diagram.nodeTemplate = simpletemplate;
  diagram.linkTemplate = linktemplate;
});
</script>
<script type="text/javascript">
    function add_person()
    {
      $('#form-body')[0].reset(); // reset form on modals
      $('#form-hiden').attr('style','display:block;');
      $('#fileflow').attr('style','display:block;'); // show bootstrap modal
      $('#form-judul').text('Tambah Workflow'); // Set Title to Bootstrap modal title
      $('[name="method"]').val('save');
    }
    function batal(){
        $('#form-hiden').attr('style','display:none;');
    }
    function edit_workflow(identifier){
        $('#form-body')[0].reset(); // reset form on modals
        $('#form-hiden').attr('style','display:block;');
        $('#fileflow').attr('style','display:none;'); // show bootstrap modal
        $('#form-judul').text('Edit Workflow'); // Set Title to Bootstrap modal title

        $('[name="method"]').val('edit');
        $('[name="id"]').val($(identifier).data('id'));
        $('[name="workflow"]').val($(identifier).data('judul'));
    }

    function search()
    {
        var form = $('#form')[0];

        var data = new FormData(form);
        $.ajax({
            url : "<?php echo site_url('main/cypher')?>",
            enctype: 'multipart/form-data',
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            success: function(data)
            {
                $('#table-list').DataTable().destroy();
                $('#table-list').DataTable({
                "processing": true,
                 "serverSide": true,
                 "ajax": {
                  "url": "<?php echo site_url('main/ajax_list/')?>",
                  "type": "POST",
                  "data": {
                    "query": data.query
                },
                "columnDefs": [
            { 
                    "targets": [ -1,0 ], //last column
                    "orderable": false, //set not orderable
                },
                ],
            }
        });
            // table.ajax.url( "<?php echo site_url('main/ajax_list/')?>").load();
            alert(data.query);// Set title to Bootstrap modal title
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
        });
    }
</script>

</body>
</html>
