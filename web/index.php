<?php

require '../bootstrap.php';
require '../MicroBlogApplication.php';

$app = new MicroBlogApplication(true);
$app->run();
