<?php

require_once('./src/Etxt.php');

$params = ['online' => '1'];

$etxt = new Etxt\Etxt('token_api', 'pass_api');
$result = $etxt->api('users.getList', $params);

print_r($result);