<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirador 3 Viewer — St Cecilia's Hall</title>
    <script src="{{ asset('collections/stcecilia/addons/mirador3/mirador.min.js') }}"></script>
    <style>
        body { margin: 0; }
        #viewer { width: 100vw; height: 100vh; }
        .mirador-window-maximize, .mirador-window-next, .mirador-window-previous, .mui-1pvxjyc {
            display: none !important;
        }
    </style>
</head>
<body>
    <div id="viewer"></div>

    @if(!empty($manifest))
    <script type="text/javascript">
        var mirador = Mirador.viewer({
            id: "viewer",
            manifests: {
                "{{ $manifest }}": { provider: "University of Edinburgh" }
            },
            windows: [{
                loadedManifest: "{{ $manifest }}",
                thumbnailNavigationPosition: 'far-bottom',
                allowClose: false,
                allowFullscreen: false
            }],
            window: {
                allowWindowSideBar: false,
                sideBarPanel: '',
                sideBarOpen: true,
                allowFullscreen: false
            },
            workspace: { type: 'not-mosaic-or-elastic' },
            workspaceControlPanel: { enabled: false }
        });
    </script>
    @endif
</body>
</html>
