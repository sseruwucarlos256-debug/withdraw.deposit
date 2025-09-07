<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'] ?? null;
    $amount = $_POST['amount'] ?? null;

    if ($phone && $amount > 0) {
        $db = new PDO("sqlite:db.sqlite");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $db->prepare("INSERT INTO transactions (transaction_id, status, amount, type) VALUES (?, ?, ?, ?)");
        $stmt->execute([uniqid("wd_"), "pending", $amount, "withdrawal"]);

        $username = "Watson"; 
        $apiKey   = "atsk_86e70bdabb56afa96f2f651d611fe84afd66100ec9214a4d3049345f9b138976f2ef5b83";
        $message  = "Hello! Your withdrawal request of UGX $amount has been received. We will process it shortly.";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.africastalking.com/version1/messaging");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "apikey: $apiKey",
            "Accept: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            "username" => $username,
            "to"       => $phone,
            "message"  => $message
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        file_put_contents("sms_log.txt", $response.PHP_EOL, FILE_APPEND);

        echo "Withdrawal request submitted successfully!";
    } else {
        echo "Invalid input.";
    }
}
