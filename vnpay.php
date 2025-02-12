<?php
// session_start();
// error_reporting(0);
// include('includes/config.php');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$vnp_TxnRef = rand(1, 10000);
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://messishop.com/vnpay_return.php";
$vnp_TmnCode = "5F7IJK9X";
$vnp_HashSecret = "OIYH6YW9Y0FO2J7P8SSACX3ZH3EE49D1";
$vnp_OrderInfo = "Thanh toán đơn hàng";
$vnp_OrderType = "billpayment";
$vnp_Amount = $_POST['money'] * 100;
$vnp_Locale = "vn";
$vnp_BankCode = "";
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
$inputData = array(
	"vnp_Version" => "2.1.0",
	"vnp_TmnCode" => $vnp_TmnCode,
	"vnp_Amount" => $vnp_Amount,
	"vnp_Command" => "pay",
	"vnp_CreateDate" => date('YmdHis'),
	"vnp_CurrCode" => "VND",
	"vnp_IpAddr" => $vnp_IpAddr,
	"vnp_Locale" => $vnp_Locale,
	"vnp_OrderInfo" => $vnp_OrderInfo,
	"vnp_OrderType" => $vnp_OrderType,
	"vnp_ReturnUrl" => $vnp_Returnurl,
	"vnp_TxnRef" => $vnp_TxnRef,

);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
	$inputData['vnp_BankCode'] = $vnp_BankCode;
}

ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
	if ($i == 1) {
		$hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
	} else {
		$hashdata .= urlencode($key) . "=" . urlencode($value);
		$i = 1;
	}
	$query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
	$vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
	$vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}

header('Location: ' . $vnp_Url);
if (isset($_POST['redirect'])) {
	header('Location: ' . $vnp_Url);
	exit();
} else {
	echo json_encode(array('code' => '00', 'message' => 'success', 'data' => $vnp_Url));
}
?>