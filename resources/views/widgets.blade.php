@extends('layouts.test')

@section('content')
    @if(count($errors)> 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(\Session::has('success'))
        <div class="alert alert-success">
            <p>{{\Session::get('success')}}</p>
        </div>
    @endif
    <div class="container">
    <link
            href="https://api.mapbox.com/mapbox-assembly/v0.23.2/assembly.min.css"
            rel="stylesheet"
    />
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js"></script>
    <link
            href="https://api.tiles.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.css"
            rel="stylesheet"
    />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.min.js"></script>
    <link
            rel="stylesheet"
            href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.css"
            type="text/css"
    />

    <style>
        body {
            margin: 0;
            padding: 0;
        }
        #geocoder-container > div {
            min-width: 50%;
            margin-left: 25%;
        }
        .string {
            color: #314ccd;
        }
        .number {
            color: #b43b71;
        }
        .boolean {
            color: #5a3fc0;
        }
        .null {
            color: #ba7334;
        }
        .key {
            color: #ba3b3f;
        }
    </style>


<div class="flex-parent viewport-full relative scroll-hidden">
    <div class="flex-child w-full w240-mm absolute static-mm left bottom">
        <div
                class="flex-parent flex-parent--column viewport-third h-full-mm hmax-full bg-white scroll-auto"
        >
            <div class="px12 py12 bg-white">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Idée de Sortie</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" action="{{route('addIdea')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"><div class="form-group">
                            <label for="exampleInputPassword1">Titre</label>
                            <input type="text" name="title" class="form-control" placeholder="Titre">
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="hidden" class="form-control" name="lat" placeholder="Latitude" id="lat" value="">
                                    <input type="hidden" class="form-control" name="address" id="address" value="">
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                            <label for="exampleInputFile">File Logo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file"  name="logo" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" name="lng" placeholder="Longitude" id="lng" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">File Ideas Logos</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file"  multiple name="logos[]" class="form-control">
                                </div>

                            </div>
                        </div>


                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Ajouter</button>

                            <button type="submit" class="btn btn-default float-right">Cancel</button>
                        </div>


                    </form>
                    <br><br>
                    <center>
                           <a href="{{route('getIdeasList')}}" class="btn btn-info">Liste</a>

                    </center>
                </div>
            </div>
        </div>

    </div>
    <div
            class="flex-child flex-child--grow bg-darken10 viewport-twothirds viewport-full-mm"
            id="map"
    ></div>
</div>

<script>
    mapboxgl.accessToken = 'pk.eyJ1Ijoib21hcmNob3VyaWIiLCJhIjoiY2trODVxcDQ3MGtjdjJwcGJuNjliYXdnaCJ9.fRI9tgHNCS6INnaeI56TRA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [-77.0091, 38.8899],
        zoom: 13

    });
    var geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
    });
    @foreach ($ideas as $idea)
    var marker = new mapboxgl.Marker()
        .setLngLat([{{$idea->latitude}},{{$idea->longitude}}])
        .addTo(map);
    @endforeach

    map.addControl(geocoder, 'top-left');

    map.on('load', function () {
        // Listen for the `geocoder.input` event that is triggered when a user
        // makes a selection
        geocoder.on('result', function (ev) {
            var styleSpec = ev.result;
            var styleSpecBox = document.getElementById('json-response');
            var styleSpecText = JSON.stringify(styleSpec, null, 2);
console.table(styleSpec);
            var lat=(ev.result.geometry.coordinates[0]);
            var lng=(ev.result.geometry.coordinates[1]);
            $("#lat").val(lat);
            $("#lng").val(lng);
            $("#address").val(styleSpec.place_name);

        });


    });
    function syntaxHighlight(json) {
        json = json
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
        return json.replace(
            /("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g,
            function (match) {
                var cls = 'number';
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'key';
                    } else {
                        cls = 'string';
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'boolean';
                } else if (/null/.test(match)) {
                    cls = 'null';
                }
                return '<span class="' + lat + '">' + lng + '</span>';
            }
        );
    }
</script>
        @endsection

