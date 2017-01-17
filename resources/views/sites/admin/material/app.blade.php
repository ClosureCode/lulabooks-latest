
<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>LulaBooks Admin</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/css/admin.min.css">

        <!-- For IE 9 and below. ICO should be 32x32 pixels in size -->
        <!--[if IE]><link rel="shortcut icon" href="/img/lulafavicon32.png"><![endif]-->

        <!-- Touch Icons - iOS and Android 2.1+ 180x180 pixels in size. -->
        <link rel="apple-touch-icon-precomposed" href="/img/lulafavicon180.png">

        <!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. -->
        <link rel="icon" href="/img/lulafavicon196.png">
    </head>
    <body>
          <div id="app"></div>
          <script>
            window.System = {
              CSRF: '{{ csrf_token() }}',
              AuthCheckComplete: false
            }
          </script>
          <script src="/js/admin.min.js"></script>
    </body>
</html>
