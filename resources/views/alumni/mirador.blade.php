<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('collections/art/addons/mirador3/mirador.min.js') }}"></script>
    <title>Mirador 3 Viewer</title>
    <style>
        .mirador-window-maximize, .mirador-window-next, .mirador-window-previous, .mui-1pvxjyc {
            display: none !important;
        }
    </style>
</head>
<body>
    <div id="viewer"></div>
    <script type="text/javascript">
        var mirador = Mirador.viewer({
            "id": "viewer",
            "manifests": {
                "{{ $manifest }}": {
                    provider: "University of Edinburgh"
                }
            },
            "windows": [
                {
                    loadedManifest: "{{ $manifest }}",
                    thumbnailNavigationPosition: 'far-bottom',
                    allowClose: false,
                    allowFullscreen: false
                }
            ],
            "window": {
                allowWindowSideBar: false,
                sideBarPanel: '',
                sideBarOpen: true,
                allowFullscreen: false
            },
            "workspace": {
                type: 'not-mosaic-or-elastic'
            },
            "workspaceControlPanel": {
                enabled: false
            }
        });
    </script>
</body>
</html>
