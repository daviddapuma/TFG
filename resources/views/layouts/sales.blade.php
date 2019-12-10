<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
    <!-- bootstrap -->
    <link href="{{asset ('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- scripts -->


    <!-- Custom styles for this template -->
    <link href="{{asset ('css/dashboard.css') }}" rel="stylesheet">


</head>

<script type="text/javascript" src="https://www.google.com/jsapi"></script> 
<script>
   google.load("visualization", "1", {packages:["corechart"]});
   google.setOnLoadCallback(dibujarGrafico);
   function dibujarGrafico() {
     // Tabla de datos: valores y etiquetas de la gráfica
     var data = google.visualization.arrayToDataTable([
       ['Texto', 'Valor numérico'],
       ['Enero', {{$usuarios[0]}}],
       ['Febrero', {{$usuarios[1]}}],
       ['Marzo', {{$usuarios[2]}}],
       ['Abril', {{$usuarios[3]}}],
       ['Mayo', {{$usuarios[4]}}],
       ['Junio', {{$usuarios[5]}}],
       ['Julio', {{$usuarios[6]}}],
       ['Agosto', {{$usuarios[7]}}],
       ['Septiembre', {{$usuarios[8]}}],
       ['Octubre', {{$usuarios[9]}}],
       ['Noviembre', {{$usuarios[10]}}],
       ['Diciembre', {{$usuarios[11]}}]
    
     ]);
     var options = {
       title: 'Usuarios registrados por mes'
     }
     // Dibujar el gráfico
     new google.visualization.ColumnChart( 
     //ColumnChart sería el tipo de gráfico a dibujar
       document.getElementById('GraficoGoogleChart-ejemplo-1')
     ).draw(data, options);
   }
 </script> 

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', ' per Month'],
          ['Enero',     {{$meses[0]}}],
          ['Febrero',      {{$meses[1]}}],
          ['Marzo',  {{$meses[2]}}],
          ['Abril', {{$meses[3]}}],
          ['Mayo',    {{$meses[4]}}],
          ['Junio',    {{$meses[5]}}],
          ['Julio',    {{$meses[6]}}],
          ['Agosto',    {{$meses[7]}}],
          ['Septiembre',    {{$meses[8]}}],
          ['Octubre',    {{$meses[9]}}],
          ['Noviembre',    {{$meses[10]}}],
          ['Diciembre',    {{$meses[11]}}]
        ]);

        var options = {
          title: 'Pedidos realizados por mes',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/admin/products">Admin Panel</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                 <li><a href="{{route('allProducts')}}">Home</a></li>
                <li><a href="/admin/products">Dashboard</a></li>
                <li><a href="/home">Profile</a></li>
            </ul>

        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
               <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
                <li><a href="/admin/createProduct">Insert Product</a></li>
                <li><a href="{{route('showOrders')}}">Orders Panel</a></li>
                <li><a href="{{route('showSalesData')}}">Sales Data</a></li>
            </ul>
            <ul class="nav nav-sidebar">

            </ul>
            <ul class="nav nav-sidebar">

            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <h1 class="page-header">Dashboard</h1>


            @yield('body')

        </div>
    </div>
</div>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{asset ('js/bootstrap.js') }}" ></script>


</body>
</html>