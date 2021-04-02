        <div id="page-wrapper" >
            <div id="page-inner">
                <div id="bpmn" style="width:1280px; height:720px; background-color: #DAE4E4;">
                    
                </div>
            </div>
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
<!-- CUSTOM SCRIPTS -->
<script src="<?php echo base_url('assets');?>/gojs/go.js"></script>
<script type="text/javascript">
    var GO = go.GraphObject.make;
    var diagram = new go.Diagram("bpmn");
    // The "simple" template just shows the key string and the color in the background.
  var simpletemplate =
    GO(go.Node, 
      GO(go.Panel, "Auto",
        GO(go.Shape, 
          new go.Binding("figure", "bentuk"),
          new go.Binding("fill", "color")),
        GO(go.TextBlock,
          new go.Binding("text", "key"))
      )
    );

  diagram.layout = GO(go.LayeredDigraphLayout,
  {direction : 90}
    );
  $.ajax({
        url : "<?php echo site_url('conbpmn/get_bpmn')?>",
        type: "POST",
        data : "start=d819339a-782d-45a6-aa3d-19897a7031c1&end=efde7ca9-3cf0-49e8-adab-d52484f559cb",
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
  diagram.linkTemplate =
    GO(go.Link,
      GO(go.Shape),  // the link shape
      GO(go.Shape,   // the arrowhead
        { toArrow: "Standard", fill: null }),
      GO(go.TextBlock, 
        new go.Binding("text", "relation"),
        { segmentOffset: new go.Point(0, -10) },
        ),
    );
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
        $('[name="id"]').val($(identifier).data('id'));
        $('[name="nip"]').val($(identifier).data('nip'));
        $('[name="nama"]').val($(identifier).data('nama'));
        $('[name="jenisKelamin"]').val($(identifier).data('kelamin'));
        $('[name="tempatLahir"]').val($(identifier).data('tempat'));
        $('[name="tanggalLahir"]').val($(identifier).data('tanggal'));
        $('[name="alamat"]').val($(identifier).data('alamat'));
        $('[name="kota"]').val($(identifier).data('kota'));
        $('[name="telepon"]').val($(identifier).data('telepon'));
        $('[name="email"]').val($(identifier).data('email'));
    }
</script>


</body>
</html>
