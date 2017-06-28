<?php
$server_name = "kokuzei.ryomk.com"; //(strpos(dirname(__FILE__), "dev") !== false) ? "test.ryomk.com" : "www.ryomk.com";
$index = file_get_contents("http://". $server_name. "/Search/");
file_put_contents(str_replace("cron", "", dirname(__FILE__)). "/public_html/index.html", $index);
file_put_contents(str_replace("cron", "", dirname(__FILE__)). "/public_html/search/index.html", $index);
