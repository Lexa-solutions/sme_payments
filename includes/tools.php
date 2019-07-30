<?php 
include('./phpmailer/PHPMailerAutoload.php');

/**
 * 
 */
class Tools {	
	
	function __construct(){
		$link = mysql_connect("localhost", "root", "OTTQ1qMtf") or die(mysql_error());
		$this->link = mysql_select_db("icnl_css", $link) or die(mysql_error());
	}
	
	public function sendConfirmEmail($email){
        try{
            $code = $this->generateCode($email);
            $fromemail = "icnlnoreply@gmail.com";
            $frompassword = "OTTQ1qMtf";
            $to = $email;
            $subject = "ICNL CUSTOMER PORTAL PASSWORD RESET";
            
            $link = $this->url(). "/icnl_css/"."reset.php?email=".$email."&code=".$code;
            
            $message = "
            <h2>Password Reset</h2>
            <p>Reset your password by clicking the link below.</p>
            <p style='font-size:20px;color:green'><a href='$link'>Reset Password</a></p>
            
            <small>If you didn't make this request, kindly ignore.</small>
            
            <hr />
            <p>".$this->url(). "/icnl_css"."</p>
            ";
            
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: <no-reply@icnl.com>' . "\r\n";
            
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            // $mail->Port = 587;
            // $mail->SMTPSecure = 'tls';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAuth = true;
            $mail->Username = $fromemail;
            $mail->Password = $frompassword;
            $mail->FromName = 'ICNL NO-REPLY';
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->msgHTML($message);
            //echo $message;
            if($mail->send()){
                return $code;
            }
        
        }
        catch(Exception $e) {
            return 'Message: ' .$e->getMessage();  
        }
		
    }
    
    public function sendMail($subject, $msg, $to, $isHTML = true){
        try{
            $fromemail = "icnlnoreply@gmail.com";
            $frompassword = "OTTQ1qMtf";                       
                                             
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: <no-reply@icnl.com>' . "\r\n";
            
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            // $mail->Port = 587;
            // $mail->SMTPSecure = 'tls';
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->SMTPAuth = true;
            $mail->Username = $fromemail;
            $mail->Password = $frompassword;
            $mail->FromName = 'ICNL NO-REPLY';
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->msgHTML($msg);
            //echo $message;
            if($mail->send()){
                return $code;
            }
        
        }
        catch(Exception $e) {
            return 'Message: ' .$e->getMessage();  
        }
            //else{
            //	return false;
            //}
    }
    
	
	public function saveUserToDB($email, $ucn, $firstname, $lastname, $agency, $agency_no, $telephoneNo, $code){
		echo "$email, $ucn, $firstname, $lastname, $code<br />";
		$_firstname = DBConnection::normalizeString($firstname);
		$_lastname = DBConnection::normalizeString($lastname);
		$_ucn = DBConnection::normalizeString($ucn);
		$_username = DBConnection::normalizeString($email);
		$_password = DBConnection::normalizeString($password);
		$_agency = DBConnection::normalizeString($agency);
		$_agency_no = DBConnection::normalizeString($agency_no);
		$_code = DBConnection::normalizeString($code);
		$_telephoneNo = DBConnection::normalizeString($telephoneNo);
		//echo "$_email, $_ucn, $_firstname, $_lastname, $_code";
		
		$link = mysql_connect("localhost", "root", "") or die(mysql_error());
		mysql_select_db("sifaxdb", $link) or die(mysql_error());
				
		$sql = "SELECT * FROM users WHERE `ucn`='$_ucn' AND `username`='$_username'";
		$result = $result = mysql_query($sql) or die(mysql_error());
                
                //echo mysql_num_rows($result);
                //die();
		
		if(mysql_num_rows($result) > 0){
			$sql = "UPDATE users SET `confirmcode`='$code' WHERE `ucn`='$_ucn' AND `username`='$_username'";
			$result = mysql_query($sql) or die(mysql_error());
					
			return $result;
		}else{
			$sql = "INSERT INTO users(`ucn`, `username`, `firstname`, `lastname`, `confirmcode`, `phonenumber`, `Agency`, `Agency_No` ) VALUES ('$_ucn', '$_username', '$_firstname','$_lastname', '$_code', '$_telephoneNo', '$_agency', '$_agency_no')";
			$result = mysql_query($sql) or die(mysql_error());
					
			//print_r($result);
			if(mysql_affected_rows($result) > 0){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public function checkConfirmCode($ucn, $code){			
		if($code == ""){
			return false;
		}else{			
			$sql = "SELECT * FROM users WHERE `ucn`='$ucn' AND `confirmcode`='$code'";
			$result = mysql_query($sql) or die(mysql_error());
			
			if(mysql_num_rows($result) > 0){
				return true;
			}else{
				return false;
			}	
		}
	}
	
	public function updatePassword($username, $password){						
		$sql = "UPDATE users SET `password`=MD5('$password'), `confirmcode`='' WHERE `username`='$username'";
		$result = mysql_query($sql) or die(mysql_error());
		
		return $result;		
	}
	
	public function updateInvoiceToPaid($invoice_no, $reqRef, $transaction_no){						
		$sql = "UPDATE invoices SET `status`='PAID', `RequestReference` = '$reqRef', `transaction_no` = '$transaction_no'  WHERE `invoice_no`='$invoice_no'";
		$result = mysql_query($sql) or die(mysql_error());
		
		return $result;		
	}
	
	public function insertChargesToDB($invoice_no, $description, $rating_days, $quantity, $unit_price, $amount, $bill_of_lading, $voyageno){
		$sql = "INSERT INTO charges 
		(`invoice_no`, `description`, `rating_days`, `quantity`, `unit_price`, `amount`, `bill_of_lading_no`, `voyage_no`) VALUES
		('$invoice_no', '$description', '$rating_days', '$quantity', '$unit_price', '$amount', '$bill_of_lading', '$voyageno')
		";	
		
		$result = mysql_query($sql) or die(mysql_error());
		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	public function saveChargesToDB($invoice_no, $description, $rating_days, $quantity, $unit_price, $amount, $amountVat){
		$sql = "INSERT INTO charges 
		(`invoice_no`, `description`, `rating_days`, `quantity`, `unit_price`, `amount`, `Amount_including_vat`) VALUES
		('$invoice_no', '$description', '$rating_days', '$quantity', '$unit_price', '$amount','$amountVat')
		";	
		
		$result = mysql_query($sql) or die(mysql_error());
		if($result){
			return true;
		}else{
			return false;
		}
	}

      	public function insertPaymentToDB($trans_ref, $description, $type, $amount, $product_ref){
		$sql = "INSERT INTO payments
		(`trans_ref`, `description`, `type`, `amount`, `product_ref`) VALUES
		('$trans_ref', '$description', '$type','$amount', '$product_ref')
		";	
		
		$result = mysql_query($sql) or die(mysql_error());
		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	public function saveInvoiceToDB($invoice_no, $transaction_no, $bill_of_lading, $consignee_name, $posted_date, $agency_name, $vessel_name, $vessel_code, $voyage_no,
									$item_type, $no_of_container, $total_before_vat, $total_discount, $total_vat, $total_payable, $amount_in_words, $ucn){
		$sql = "INSERT INTO invoices		
		(`invoice_no`, `transaction_no`, `bill_of_lading_no`, `consignee_name`, `posted_date`, `agency_name`, `vessel_name`, `vessel_code`, `voyage_no`,
		`item_type`, `no_of_container`, `total_before_vat`, `total_discount`, `total_vat`, `total_payable`, `amount_in_words`, `ucn` ) 
		VALUES 
		('".$invoice_no."', '".$transaction_no."', '".$bill_of_lading."', '".$consignee_name."', '".$posted_date."', '".$agency_name."', '".$vessel_name."', '".$vessel_code."', '".$voyage_no."',
		'".$item_type."', '".$no_of_container."', '".$total_before_vat."', '".$total_discount."', '".$total_vat."', '".$total_payable."', '".$amount_in_words."', '".$ucn."' ) ";
		
		$result = mysql_query($sql) or die(mysql_error());
		
		// foreach ($charges as $charge) {
		// 	$this->insertChargesToDB($p['invoice_no'], $charge['description'], $charge['rating_days'], $charge['quantity'], $charge['unit_price'], $charge['amount'], $charge['bill_of_lading'], $charge['voyageno']);
		// }
		
		if($result){
			return true;
		}else{
			return false;
		}
	}
	
	public function saveBookingToDB($booking_no, $ucn, $bill_of_lading, $exam_type, $no_of_container, 
	   $agency_name, $date, $consignee_name, $vessel_code, $vessel_name){
		$sql = "INSERT INTO bookings		
		(`booking_number`, `bill_of_lading_no`, `ucn`, `examination_type`, `agency_name`, `booking_date`, `no_of_container`,
		`consignee_name`,`vessel_code`,`vessel_name`) 
		VALUES 
		('".$booking_no."', '".$bill_of_lading."', '".$ucn."', '".$exam_type."', '".$agency_name."', '".$date."',
		'".$no_of_container."','".$consignee_name."','".$vessel_code."','".$vessel_name."') ";
		
		$result = mysql_query($sql) or die(mysql_error());
		
		// foreach ($charges as $charge) {
		// 	$this->insertChargesToDB($p['invoice_no'], $charge['description'], $charge['rating_days'], $charge['quantity'], $charge['unit_price'], $charge['amount'], $charge['bill_of_lading'], $charge['voyageno']);
		// }
		
		if($result){
			return true;
		}else{
			return false;
		}
	}
	public function generateCode($token) {
		return md5(time().$token);
    }	
    
    public function url(){
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
 
        $url = $protocol . $_SERVER['HTTP_HOST'];// . $_SERVER['REQUEST_URI'];
        return $url; // Outputs: Full URL
    }

    
      
	
}
?>