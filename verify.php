<?php
$access_token = 'aPRL1nzy4bv5J+iuL4vXXwnH352+hRAf/uXBHSrbrvsYklUaPpk1tIiqylteTDqKIfQOtEF9fCT7e0fUEv+8tnrM73mzSoG45ScIfNpRASEn2c0YeMGz4SeqYOECkxBkxKmbQiwsoXLJqYeekPvTowdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;