
<html>
<head>
    <title>Beervana Tracker 2013</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="assets/css/style.css" rel="stylesheet" media="screen">

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="assets/img/apple-icon-57x57-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/img/apple-icon-72x72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/img/apple-icon-114x114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/img/apple-icon-144x144-precomposed.png" />
    <link rel="apple-touch-startup-image" href="assets/img/startup.png">
</head>
<body>

    <div id="wrap">
        <div id="header">
            <div class="container">
                <h1 class="site-title">Beervana 2013</h1>
            </div>
        </div>
        <?php
            if($_GET['error'] == 'User Exists') {
                echo '<div class="container alert alert-danger">';
                echo "Sorry, that username has already been taken. Please try another.";
                echo '</div>';
            }
            if($_GET['error'] == 'Required Fields') {
                echo '<div class="container alert alert-danger">';
                echo "All fields are required. Please fill them in and try again.";
                echo '</div>';
            }
        ?>
        <div class="container">
            <form class="form-signin" action="beers/index.php" method="GET">
                <h2 class="form-signin-heading">Please Sign Up / In</h2>
                <input type="text" class="form-control" placeholder="Username" autofocus="true" name="username"/>
                <input type="password" class="form-control" placeholder="Password" name="password"/>
                <input type="email" class="form-control" placeholder="Email" name="email"/>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign Up / In</button>
            </form>
        </div>
    </div>

    <div id="footer">
        <div class="container">
            <p class="text-muted credit">
                Site brewed up by <a href="http://twitter.com/fernholz" target="_blank">Derek Fernholz</a>.
            </p>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
<!--    <script src="../assets/js/bootstrap.min.js"></script>-->
</body>
</html>