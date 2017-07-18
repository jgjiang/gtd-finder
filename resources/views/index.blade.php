<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GTD Finder</title>

        <!-- Bootstrap CSS, JS-->
        <link rel="stylesheet" href="{{asset('/bootstrap/css/bootstrap.min.css')}}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 120vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                /*justify-content: center;*/
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 65px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 20px;
            }
        </style>
        <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <!-- amMap stuff -->
        <script src="{{asset('/ammap/ammap.js')}}" type="text/javascript"></script>
        <script src="{{asset('ammap/maps/js/worldLow.js')}}" type="text/javascript"></script>
        <link rel="stylesheet" href={{asset('/ammap/ammap.css')}} type="text/css" media="all" />


    </head>
    <body>
        <div class="flex-center position-ref full-height" >

            <div class="content">
                <div class="title m-b-md">
                    GTD Finder
                </div>

                <form action="./search" method="POST" role="search" class="col-md-4 col-md-offset-4">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Search data">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>

                            <button type="button" id="viewmap" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="view gtd map" >
                                <span class="glyphicon glyphicon-globe"></span>
                            </button>

                        </span>

                    </div>

                    @if(isset($msg))
                        <p style="color: crimson">{{$msg}}</p>
                    @endif
                </form>

                <div class="alert alert-info col-md-4 col-md-offset-4" style="margin-top: 20px;" role="alert">
                    Use Patient ID to do the search, please! <br>
                    Contact E-mail: firjjg@gmail.com
                </div>


                @if(isset($results))
                <div class="col-md-8 col-md-offset-2" id="search_table">
                    <div class="panel panel-default">
                        <div class="panel-heading">Search Results</div>
                        <table class="table table-striped table-hover table-responsive">
                            <thead style="font-weight: bold;">
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td>Week</td>
                                <td>HCG Value</td>
                                <td>Created Date</td>

                            </tr>
                            </thead>

                            <tbody>
                                @foreach($results as $item)
                                    <tr>
                                        <td>{{$item->pid}}</td>
                                        <td>{{$item->surname.' '.$item->f_name}}</td>
                                        <td>{{$item->week_num}}</td>
                                        <td>{{$item->hcg_value}}</td>
                                        <td>{{date('Y-m-d',$item->created_at)}}</td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    <!-- paging  -->
                    <div>
                        <div class="pull-right">
                            {{$results->render()}}
                        </div>
                    </div>
                </div>
                @endif


                {{--put map here--}}
                <div class="col-md-8 col-md-offset-2">
                    <div id="mapdiv"></div>
                </div>

            </div>


        </div>

        <script>
            $(function () { $("[data-toggle ='tooltip']").tooltip(); });
        </script>

        <script>
            var url = './showMap';
            var areas = "{{$areas}}";
            var mydata = JSON.parse(areas.replace(/&quot;/g,'"'));

            $(document).ready(function () {
                $('#viewmap').click(function () {

                    $.ajax({
                        type: "GET",
                        url: url,
//                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: 'text',
                        success: function(data){

                            // dynamically change the css style to show the map
                            $("#mapdiv").css({"background-color":"#eee", "height":"400px"});

                            // hide the search table
                            $("#search_table").css({"display":"none"});

                            // show map
                            AmCharts.makeChart( "mapdiv", {
                                /**
                                 * this tells amCharts it's a map
                                 */
                                "type": "map",

                                /**
                                 * create data provider object
                                 * map property is usually the same as the name of the map file.
                                 * getAreasFromMap indicates that amMap should read all the areas available
                                 * in the map data and treat them as they are included in your data provider.
                                 * in case you don't set it to true, all the areas except listed in data
                                 * provider will be treated as unlisted.
                                 */
                                "dataProvider": {
                                    "map": "worldLow",
                                    "areas": mydata,


                                },

                                /**
                                 * create areas settings
                                 * autoZoom set to true means that the map will zoom-in when clicked on the area
                                 * selectedColor indicates color of the clicked area.
                                 */
                                "areasSettings": {
                                    "autoZoom": true,
                                    "selectedColor": "#CC0000"
                                },

                                /**
                                 * let's say we want a small map to be displayed, so let's create it
                                 */
                                "smallMap": {}
                            } );

                        },
                        error: function (data) {
                            alert('Error:'+ data);

                        }
                    });
                });
            });
            
            

           
        </script>

    </body>
    <footer>
        <div class="jumbotron" style="margin:0; "  >
            <div class="container">
                <span>  UCC@2017 Jingguo Jiang</span>
            </div>
        </div>
    </footer>
</html>
