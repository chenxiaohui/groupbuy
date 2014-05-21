<?php
if(!extension_loaded('openssl'))
{
	echo '请安装并加载openssl扩展!';
	exit;
}

function kimssl_pkey_get_public ($modulus, $exponent)
{
	$modulus = base64_decode($modulus);
	$exponent = base64_decode($exponent);
	$exponentEncoding = makeAsnSegment(0x02, $exponent); 
	$modulusEncoding = makeAsnSegment(0x02, $modulus); 
	$sequenceEncoding = makeAsnSegment(0x30, $modulusEncoding . $exponentEncoding);
	$bitstringEncoding = makeAsnSegment(0x03, $sequenceEncoding);
	$rsaAlgorithmIdentifier = pack("H*", "300D06092A864886F70D0101010500"); 
	$publicKeyInfo = makeAsnSegment (0x30, $rsaAlgorithmIdentifier . $bitstringEncoding);
	$publicKeyInfoBase64 = base64_encode($publicKeyInfo); 
	$encoding1 = "-----BEGIN PUBLIC KEY-----\n";
	$offset = 0;
	while ($segment=substr($publicKeyInfoBase64, $offset, 64)){
	$encoding1 = $encoding1.$segment."\n";
	$offset += 64;
	}
	$encoding1 = $encoding1."-----END PUBLIC KEY-----\n";
	$publicKey = openssl_pkey_get_public ($encoding1);
	return ($publicKey);
}

function makeAsnSegment($type, $string)
{
	switch ($type)
	{
		case 0x02:
			if (ord($string) > 0x7f)
			$string = chr(0).$string;
			break;
		case 0x03:
			$string = chr(0).$string;
			break;
	}

	$length = strlen($string);

	if ($length < 128)
	{
		$output = sprintf("%c%c%s", $type, $length, $string);
	}
	else if ($length < 0x0100)
	{
		$output = sprintf("%c%c%c%s", $type, 0x81, $length, $string);
	}
	else if ($length < 0x010000)
	{
		$output = sprintf("%c%c%c%c%s", $type, 0x82, $length/0x0100, $length%0x0100, $string);
	}
	else 
	{
		$output = NULL;
	}

	return($output);
}
?>