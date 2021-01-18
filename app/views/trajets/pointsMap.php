<!DOCTYPE html>
<html lang="en">
<head>
    <title>OpenStreetMap Nominatim: Search</title>
    <meta content="IE=edge" http-equiv="x-ua-compatible" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <base href="https://nominatim.openstreetmap.org/" />
    <link href="nominatim.xml" rel="search" title="Nominatim Search" type="application/opensearchdescription+xml" />
    <link href="css/leaflet.css" rel="stylesheet" />
    <link href="css/Control.Minimap.min.css" rel="stylesheet" />
    <link href="css/bootstrap-theme.min.css" rel="stylesheet" />
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/common.css" rel="stylesheet" type="text/css" />
    <link href="css/search.css" rel="stylesheet" type="text/css" />
</head>

<body id="search-page">

<header class="container-fluid">

</header>

<div class="modal fade" id="report-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Report a problem</h4>
            </div>
            <div class="modal-body">
                <p>
                    Before reporting problems please read the <a target="_blank" href="https://nominatim.org/release-docs/develop/api/Overview">user documentation</a>.

                <h4>Finding the expected result</h4>

                First of all, please make sure that the result that you expect is
                available in the OpenStreetMap data.

                To find the OpenStreetMap data, do the following:

                <ul>
                    <li>Go to <a href="https://openstreetmap.org">https://openstreetmap.org</a>.</li>
                    <li>Go to the area of the map where you expect the result
                        and zoom in until you see the object you are looking for.</li>
                    <li>Click on the question mark on the right side of the map,
                        then with the question cursor on the map where your object is located.</li>
                    <li>Find the object of interest in the list that appears on the left side.</li>
                    <li>Click on the object and note down the URL that the browser shows.</li>
                </ul>

                If you cannot find the data you are looking for, there is a good chance
                that it has not been entered yet. You should <a href="https://www.openstreetmap.org/fixthemap">report or fix the problem in OpenStreetMap</a> directly.

                <h4>Reporting bad searches</h4>

                Problems may be reported at the <a target="_blank" href="https://github.com/openstreetmap/nominatim/issues">issue tracker on github</a>. Please read through
                the open tickets first and check if your problem has not already been
                reported.

                When reporting a problem, include the following:

                <ul>
                    <li>A full description of the problem, including the exact term you
                        were searching for.</li>
                    <li>The result you get.</li>
                    <li>The OpenStreetMap object you expect to find (see above).</li>
                </ul>

                For general questions about installing and searching in Nominatim, please
                use <a href="https://help.openstreetmap.org/tags/nominatim/">Help OpenStreetMap</a>.

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<form class="form-inline" role="search" accept-charset="UTF-8" action="https://nominatim.openstreetmap.org/search.php">
    <div class="form-group">
        <input id="q" name="q" type="text" class="form-control input-sm" placeholder="Search" value="" >
    </div>
    <div class="form-group search-button-group">
        <button type="submit" class="btn btn-primary btn-sm">Search</button>
        <input type="hidden" value="1" name="polygon_geojson" />
        <input type="hidden" name="viewbox" value="" />
        <div class="checkbox-inline">
            <input type="checkbox" id="use_viewbox" >
            <label for="use_viewbox">apply viewbox</label>
        </div>
    </div>

</form>


<div id="content">


    <div id="map-wrapper">
        <div id="map-position">
            <div id="map-position-inner"></div>
            <div id="map-position-close"><a href="#">hide</a></div>
        </div>
        <div id="map"></div>
    </div>

</div> <!-- /content -->







<script type="text/javascript">

    var nominatim_map_init = {
        "zoom": 2,
        "lat": 20,
        "lon": 0,
        "tile_url": "https:\/\/{s}.tile.openstreetmap.org\/{z}\/{x}\/{y}.png",
        "tile_attribution": ""
    };
    var nominatim_results = [];
</script>
<!--<footer>
    <p class="disclaimer">
        By NUMHERIT
    </p>
    <p class="copyright">
        &copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors<br>
        Please note the <a href="https://operations.osmfoundation.org/policies/nominatim/">usage policy</a> for this service.
    </p>
</footer>-->

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/leaflet.min.js"></script>
<script src="js/Control.Minimap.min.js"></script>
<script src="js/url-search-params.js"></script>
<script src="js/nominatim-ui.js"></script>

</body>
</html>
