<?php
$db = new PDO("sqlite:db.sqlite");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

$transactionId = $data['order_tracking_id'] ?? null;
$status = $data['status'] ?? null;
$amount = $data['amount'] ?? null;

if ($transactionId && $status) {
    $stmt = $db->prepare("INSERT INTO transactions (transaction_id, status, amount, type) VALUES (?, ?, ?, ?)");
    $stmt->execute([$transactionId, $status, $amount, "deposit"]);

    $username = "Watson"; 
    $apiKey   = "atsk_86e70bdabb56afa96f2f651d611fe84afd66100ec9214a4d3049345f9b138976f2ef5b83"; 
    $to       = "+2567XXXXXXXX"; 
    $message  = "Hello! Your deposit of UGX $amount was received. Status: $status (Ref: $transactionId).";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.africastalking.com/version1/messaging");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $apiKey",
        "Accept: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "username" => $username,
        "to"       => $to,
        "message"  => $message
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    file_put_contents("sms_log.txt", $response.PHP_EOL, FILE_APPEND);
    http_response_code(200);
    echo "OK";
} else {
    http_response_code(400);
    echo "Invalid Data";
}
