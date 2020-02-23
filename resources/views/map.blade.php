@extends('layouts.app')
<head>

    <link rel="stylesheet" href="https://js.arcgis.com/3.31/esri/css/esri.css">
    <script src="https://js.arcgis.com/3.31/"></script>
    <script type = "text/javascript">
        require(["esri/map", "esri/SpatialReference", "esri/geometry/Point", "esri/graphic", "esri/symbols/SimpleMarkerSymbol", "esri/layers/GraphicsLayers"], function(Map) {
            var map = new Map("map", {
                center: [-118, 34.5],
                //zoom: 8,
                basemap: "topo"
            });


            var croakPoints = [];
            var croaksLayer = new GraphicsLayer();
            var csStr = "{{ $cs }}";
            csStr = csStr.replace(/&quot;/g, '"');
            var cs = JSON.parse(csStr);

            cs.forEach(function(c){
                var g = new Graphic(
                    new Point(c['x'], c['y'], new SpatialReference(4326)),
                    new SimpleMarkerSymbol()
                );
                croakPoints.push(g);
                croaksLayer.add(g);
            });
        });
    </script>
</head>
@section('content')
<div class="container">

    <div id = "map"></div>

</div>
@endsection