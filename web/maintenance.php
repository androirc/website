<?php

header('HTTP/1.0 503 Service Unavailable');

?>
<!DOCTYPE html>
<html xml:lang="en" lang="en">
    <head>
        <title>Maintenance - AndroIRC (Android IRC Client)</title>
        <meta name="language" content="en" />
        <meta name="robots" content="noindex,nofollow" />

        <style type="text/css">
            #content {
                margin-top: 70px;
                text-align: center;
                font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            }
        </style>
    <body>
        <section id="content">
            <img src="/images/maintenance.png" />
            <h1>AndroIRC - Maintenance</h1>
            <p>The site is down for maintenance. Please try again later. Thank you for your understanding.</p>
        </content>
    </body>
</html>
<?php
// Don't load Symfony2
exit();