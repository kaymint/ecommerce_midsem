<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/27/16
 * Time: 2:40 PM
 */

session_start();
require_once '../model/orders.php';

if(isset($_REQUEST['cmd'])){
    $cmd = intval($_REQUEST['cmd']);

    switch($cmd){

        case 1:
            //Add
            pay();
            break;
        case 2:
            //cofirmation email
            orderConfirmation();
            break;

    }
}

function pay(){
    if(isset($_POST['pay']) && isset($_POST['rid'])){
        $pay = $_POST['pay'];
        $card = $_POST['card'];
        $rid = $_POST['rid'];

        $orders = new orders();
        $res = $orders->updateReceipt($rid, $pay, $card);
        if($res != false){
            header("Location: ../customer_view/admin_page/sales.php");
        }else{
            header("Location: ../customer_view/admin_page/order_details.php?rid={$rid}");
        }
    }
}

function orderConfirmation(){
    if(isset($_SESSION['rec_email'])){

        $com_name = $_SESSION['com_name'];
        $email = $_SESSION['rec_email'];
        $name = $_SESSION['rec_firstname']." ".$_SESSION['rec_lastname'];
        $address = $_SESSION['rec_address1'];
        $details = $_SESSION['cart_details'];
        $recipt_id = $_SESSION['receipt_id'];
        $overall = $_SESSION['overallTotal'];

        $logo = '../customer_view/logo.png';

        $message = "<img src='../customer_view/images/logo.png'>";
        $message.= "<h3 style='font-style: italic'>Billed to:</h3>";
        $message.= "<h4>{$name} of {$com_name}</h4>";
        $message .= "<h5>Shipping Address: {$address}</h5>";
        $message .= "<br><br>";


        $message .= "<table><tr><th>Item</th><th>Cost</th><th>Qty</th><th>Sub Total</th></tr>";
        foreach($details as $row){
            $message .= "<tr><td>{$row['brand_name']} {$row['name']} {$row['furniture_type']}</td>";
            $message .= "<td>{$row['cost']}</td>";
            $message .= "<td>{$row['count']}</td>";
            $message .= "<td>{$row['itemTotal']}</td></tr>";
        }
        $message .= "</table>";

        $message .= "<br><br>";
        $message .= "<h3>Total: {$overall}</h3>";

        sendMail($email, $message, $name, 'Exclusive Furniture Order Confirmation');

    }
}

function sendMail($cust_mail, $message, $cust_name, $subject){

        date_default_timezone_set('Etc/UTC');
        require 'phpmailer/PHPMailerAutoload.php';

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.office365.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'kenneth.mensah@ashesi.edu.gh';
        $mail->Password = 'kaymint145';
        $mail->setFrom('kenneth.mensah@ashesi.edu.gh', 'Exclusive Furniture');
        $mail->addAddress($cust_mail, $cust_name);
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        $mail->AltBody = 'Payment Confirmation';
        if($mail->send()){
            header("Location: ../customer_view/receipt_info.php");
        }else{
            header("Location: ../customer_view/products.php");
        }
}
