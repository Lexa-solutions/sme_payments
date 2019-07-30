<?php
// require_once 'TransferLibrary.php';
require_once './includes/TransferLibrary.php';

$transfer_lib = new TransferLibrary();
$paystack = new Paystack();

// Start Preload Necessary Data (Transfer Recipients and Banks)
$recipients = $paystack->RetrieveTransferRecipient(5,1);
$recipients_arr = json_decode($recipients, TRUE);

$banks_arr = json_decode($paystack->ListBanks(30,1),TRUE);

$banks_data = array();
if(isset($banks_arr['data'])){
    $banks_data = $banks_arr['data'];
}

$recipients_data = array();

if($recipients_arr['status']==1)
    $recipients_data = $recipients_arr['data'];

//End Preload Data

function notify(){
    echo '<script type="text/javascript">notify();</script>';        
}

//notify();

//Check Balance
if(isset($_GET['chk_balance']) && $_GET['chk_balance']='ctrl_02930Z9II$0102!94@02'){
    $transfer_lib->chk_balance();
}
//Check balance end


//Disable OTP
if(isset($_GET['disable_otp']) && $_GET['disable_otp']='ctrl_02930Z9II$0102!94@02'){
    $transfer_lib->disable_otp();
}
//Disable OTP End

//Enable OTP
if(isset($_GET['enable_otp']) && $_GET['enable_otp']='ctrl_02930Z9II$0102!94@02'){    
    $transfer_lib->enable_otp();
}
//Enable OTP End

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Notify user of ongoing background process
    $transfer_lib->notify();

    $data = filter_input_array(INPUT_POST);
    unset($data['users_DT_length']);

    if(isset($data['action'])){
        if(isset($data['recipient_code']))
            $recipient_code = trim($data['recipient_code']);

        //Update Transfer Recipient
        if($data['action']=='update'){ 
            unset($data['recipient_code']);
            unset($data['action']);
            unset($data['type']);unset($data['account_number']);unset($data['account_name']);unset($data['bank_code']);unset($data['currency']);unset($data['description']);

            $_SESSION['body'] = $data;
            $_SESSION['recipient_code'] = $recipient_code;
            $updated_recipient = json_decode($paystack->UpdateTransferRecipient($recipient_code,$data),TRUE);


            if(isset($updated_recipient)){
                $_SESSION['success'] = $updated_recipient['message']; 
                header('location: vendors.php');
                exit();
            }
            else{
                $_SESSION['success'] ="An error occured. Please try again"; 
                header('location: vendors.php');
                exit();
            }
        }
        //Delete Transfer Recipient
        else if($data['action'] == 'delete'){
            $delete_response = json_decode($paystack->DeletetransferRecipient($recipient_code),TRUE);

            if(isset($delete_response)){
                $_SESSION['success'] = $delete_response['message']; 
                header('location: vendors.php');
                exit();
            }
            else{
                $_SESSION['success'] ="An error occured. Please try again"; 
                header('location: vendors.php');
                exit();
            }
        }
        //Initiate Single Transfer
        else if($data['action'] == 'initiate-transfer'){
            unset($data['action']);
            $data['metadata'] = array('initiatedBy'=>$_SESSION['admin_profile']['fullname']);
            $data['amount']= $data['amount']*100;

            $_SESSION['data']=$data;
            $transfer_data = json_decode($paystack->InitiateTransfer($data),TRUE);

            $_SESSION['transfer_data'] = $transfer_data;

            if(isset($transfer_data)){
                if($transfer_data['status']){
                    if($transfer_data['data']['status'] == 'otp'){
                        header('location: initiate-transfer.php?transfer_code='.$transfer_data['data']['transfer_code']);
                        exit();
                    }
                    else if($transfer_data['data']['status'] == 'pending'){
                        $_SESSION['success'] = $transfer_data['message']; 
                        header('location: transfer-history.php');
                        exit();
                    }
                }
                else{
                    $_SESSION['success'] = $transfer_data['message']; 
                    header('location: initiate-transfer.php');
                    exit();
                }
               
            }
            else{
                $_SESSION['success'] ="An error occured. Please try again"; 
                //Redirect to the listing page,
                header('location: initiate-transfer.php');
                //Important! Don't execute the rest put the exit/die. 
                exit();
            }
        }
        else if($data['action'] == 'otp'){
            unset($data['action']);
            $finalize = json_decode($paystack->FinalizeTransfer($data),TRUE);

            $_SESSION['finalize'] = $finalize;
            
            $_SESSION['success'] = isset($finalize['message']) ? $finalize['message'] :  "Transaction successful";             
            header('location: transfer-history.php');
            
            exit();
        }
        else if($data['action'] == 'resend_otp'){
            unset($data['action']);

            //$_SESSION['data'] = $data;
            $resend_otp = json_decode($paystack->ResendOTP($data),TRUE);

            $_SESSION['resend_otp'] = $resend_otp;
            if($resend_otp['status']){
                $_SESSION['success'] = $resend_otp['message'];
                header('location: initiate-transfer.php?transfer_code='.$data['transfer_code']);
                exit();
            }
            else{
                $_SESSION['success'] = $resend_otp['message']; 
                header('location: initiate-transfer.php?transfer_code='.$data['transfer_code']);
                exit();
            }
            
        }
        else if($data['action'] == 'disable_otp_finalize'){
            
            unset($data['action']);

            //$_SESSION['data'] = $data;
            $disable_otp_finalize = json_decode($paystack->DisableOTPFinalize($data),TRUE);

            $_SESSION['resend_otp'] = $disable_otp_finalize;
            if($disable_otp_finalize['status']){
                $_SESSION['success'] = $disable_otp_finalize['message'];
                header('location: initiate-transfer.php');
                exit();
            }
            else{
                $_SESSION['success'] = $disable_otp_finalize['message']; 
                header('location: initiate-transfer.php');
                exit();
            }
            
        }

        else if($data['action'] == 'bulk_transfer'){
            
            unset($data['action']);
             
            if(isset($_FILES["transfer_csv"])){              
                $doc = $_FILES["transfer_csv"];            
                $file_tmp = $doc['tmp_name'];                  
                
                $transfers = [];

                // Open the file for reading
                if (($h = fopen("{$file_tmp}", "r")) !== FALSE) 
                {
                    // Each line in the file is converted into an individual array that we call $data
                    // The items of the array are comma separated
                    fgetcsv($h); //skip header line
                    while (($line = fgetcsv($h, 1000, ",")) !== FALSE) 
                    {
                        // Each individual array is being pushed into the nested array
                        if((isset($line[0]) && is_numeric($line[0])) && (isset($line[1]) && is_string($line[1]))){
                            $r = trim($line[1]);
                            $amt = $line[0] * 100;
                            $line_arr = array('amount'=> $amt, 'recipient'=>$r);
                            $transfers[] = $line_arr;
                        }
                        
                    }
                    fclose($h);
                    if(count($transfers) < 1){
                        $_SESSION['success'] = "Uploaded file is empty"; 
                        header('location: initiate-transfer.php');
                        exit();
                    }
                                       
                }
                unset($data['transfer_csv']);
                $data['transfers'] = $transfers;
                
                $bulk_transfer = json_decode($paystack->BulkTransfer($data),TRUE);
                $_SESSION['bulk_transer_response'] = $bulk_transfer;
                if($bulk_transfer['status']){
                    $_SESSION['success'] = $bulk_transfer['message'];
                    header('location: transfer-history.php');
                    exit();
                }
                else{
                    $_SESSION['success'] = $bulk_transfer['message']; 
                    header('location: initiate-transfer.php');
                    exit();
                }

            }
            
        }
    }
    else{
        //Create Transfer Recipient (Vendor)
        $data['metadata'] = array('createdBy'=>$_SESSION['admin_profile']['fullname']);

        $paystack = new Paystack();
        
        $resp = $paystack->CreateTransferRecipient($data);

        $_SESSION['data_to'] = $resp;
        $resp_data = json_decode($resp, TRUE);

        if(isset($resp_data)){
            $_SESSION['success'] = $resp_data['message']; 
            //Redirect to the listing page,
            header('location: vendors.php');
            //Important! Don't execute the rest put the exit/die. 
            exit();
        }
        else{
            $_SESSION['success'] ="An error occured. Please try again"; 
            //Redirect to the listing page,
            header('location: vendors.php');
            //Important! Don't execute the rest put the exit/die. 
            exit();
        }
    }   
    

}
?>