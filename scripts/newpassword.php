<?php

# Simple script to get hash of a password
# Usage : php scripts/newpassword.php <secretpassword>

include("config.inc.php");

$password = $argv[1];
$md5password = md5($salt.$password);

echo "Password : $password / Salt : $salt / Hashed password : $md5password\n";
