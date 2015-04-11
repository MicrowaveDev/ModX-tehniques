<?php
$result = preg_replace('#^https?://#', '', $input);
$result = rtrim($result, "/");
return $result;
