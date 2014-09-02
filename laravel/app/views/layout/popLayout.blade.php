<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="PWeb Project">
        <meta name="author" content="Frogidel">

        <link rel="icon" href="favicon.ico">

    <!-- Le styles -->
    {{ HTML::style('css/bootstrap-3.1.1/dist/css/bootstrap.css'); }}
    {{ HTML::style('css/bootstrap-3.1.1/dist/css/bootstrap-theme.css'); }}
    {{ HTML::style('css/bootstrap-3.1.1/dist/css/bootstrap.min.css'); }}
    {{ HTML::style('js/Pagination/simplePagination.css'); }}
    {{ HTML::style('css/MyCss.css'); }}
    {{ HTML::style('css/jquery-ui.css'); }}

    

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="http://getbootstrap.com/2.3.2/assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://getbootstrap.com/2.3.2/assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="http://getbootstrap.com/2.3.2/assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="http://getbootstrap.com/2.3.2/assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="http://getbootstrap.com/2.3.2/assets/ico/favicon.png">
  </head>

  <!-- fix navbar padding -->
  <style type="text/css">
  body {
    padding-top: 50px;
     }
  </style>
  <body>
    


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

     {{ HTML::style('css/MyCss.css'); }}
    {{ HTML::style('css/jquery-ui.css'); }}
    {{ HTML::script('css/bootstrap-3.1.1/dist/js/bootstrap.js'); }}
    {{ HTML::script('css/bootstrap-3.1.1/dist/js/bootstrap.min.js'); }}
    {{ HTML::script('js/jquery-1.11.1.js'); }}
    {{ HTML::script('js/jquery-1.11.1.min.js'); }}
    {{ HTML::script('js/jquery-2.1.1.js'); }}
    {{ HTML::script('js/jquery-2.1.1.min.js'); }}
    {{ HTML::script('js/jquery-migrate-1.2.1.js'); }}
    {{ HTML::script('js/jquery-migrate-1.2.1.min.js'); }}
    
    {{ HTML::script('css/bootstrap-3.1.1/dist/js/bootstrap.js'); }}
    {{ HTML::script('css/bootstrap-3.1.1/dist/js/bootstrap.min.js'); }}

    {{ HTML::script('js/jquery-ui.js'); }}
    {{ HTML::script('js/jquery-2.1.0.min.js'); }}
    {{ HTML::script('js/jquery-1.11.0.min.js'); }}

    {{ HTML::script('js/jquery.min.js'); }}
    {{ HTML::script('js/bootstrap.min.js'); }}
   
    {{ HTML::script('js/MyJs.js'); }}

    {{ HTML::script('js/stupidtable.js'); }}
     <script>
        $(function(){
            $("table").stupidtable();
        });
    </script>
    
    @unless(Auth::check())
         
    @else
        <div class="container">
            @yield('body_pop')
        </div>
    @endunless

   
    
    @include('components.footer') 



</body></html>