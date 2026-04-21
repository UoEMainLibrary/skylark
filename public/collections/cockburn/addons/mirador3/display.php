<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="mirador.min.js"></script>
  <title>Mirador 3 Viewer</title>
</head>
<body>
  <?php
  $input = $_GET['manifest'] ?? '';
  $clean = strip_tags($input);
  $clean = trim($clean);
  $safe_output = htmlspecialchars($clean, ENT_QUOTES, 'UTF-8');
  if (!filter_var($clean, FILTER_VALIDATE_URL)) {
    $safe_output = '';
  }
  ?>

<div id="viewer"/>

<script type="text/javascript">
var mirador = Mirador.viewer({
  "id": "viewer",
  "manifests": {
    "<?php echo $safe_output; ?>": {
      "provider": "University of Edinburgh"
    }
  },
  "windows": [
    {
      "loadedManifest": "<?php echo $safe_output; ?>",
      "canvasIndex": 2,
      "thumbnailNavigationPosition": 'far-bottom'
    }
  ]
});
</script>
</body>
</html>
