<!DOCTYPE html>
<html>
<head>
	<script src="<?='assets/bpmn-js/dist/bpmn-modeler.development.js';?>"></script>
	<script src="<?='assets/bpmn-js/dist/bpmn-navigated-viewer.development.js';?>"></script>
	<script src="<?='assets/bpmn-js/dist/bpmn-viewer.development.js';?>"></script>
	<link rel="stylesheet" href="<?='/neo4j-ci/assets/bpmn-js/dist/assets/diagram-js.css';?>" />
  	<link rel="stylesheet" href="<?='/neo4j-ci/assets/bpmn-js/dist/assets/bpmn-font/css/bpmn.css';?>"/>
</head>
<body>
	<div id="canvas">
		
	</div>

<form action="<?php echo base_url('upload/ambil'); ?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
upload Vdx
<form action="<?php echo base_url('upload/ambilVdx'); ?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
<form action="<?php echo base_url('upload/ambilVdx'); ?>" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>
<!-- <script>
  // the diagram you are going to display
  var bpmnXML;

  // BpmnJS is the BPMN viewer instance
  var viewer = new BpmnJS({ container: '#canvas' });

  // import a BPMN 2.0 diagram
  viewer.importXML(bpmnXML, function(err) {
    if (err) {
      // import failed :-(
    } else {
      // we did well!

      var canvas = viewer.get('canvas');
      canvas.zoom('fit-viewport');
    }
  });

  import Modeler from 'bpmn-js/lib/Modeler';

// create a modeler
var modeler = new Modeler({ container: '#canvas' });

// import diagram
modeler.importXML(bpmnXML, function(err) {
  // ...
});
</script> -->

</body>
</html>