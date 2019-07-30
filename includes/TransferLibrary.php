<?php

class TransferLibrary
{
	protected $paystack;
	
	public function __construct() {
        $this->paystack = new Paystack();
    }
		
	public function enable_otp(){
        
        $enable_otp = $this->paystack->EnableOTP();
        $enable_otp = json_decode($enable_otp, TRUE);
        if(isset($enable_otp)){
            $display_string = json_encode($enable_otp);        
        }else{
            $display_string = json_encode(null);
        }
        echo $display_string;

        exit();
        
    }
    
    public function chk_balance(){
        
        $balance = $this->paystack->CheckBalance();
        $balance = json_decode($balance, TRUE);
        if(isset($balance['data'])){
            $display_string = json_encode($balance['data']);
            
        }else{
            $display_string = json_encode(null);
        }
        echo $display_string;

        exit();
    }
    
    public function disable_otp(){
        
        $disable_otp = $this->paystack->DisableOTP();
        $disable_otp = json_decode($disable_otp, TRUE);
        if(isset($disable_otp)){
            $display_string = json_encode($disable_otp);
            
        }else{
            $display_string = json_encode(null);
        }
        echo $display_string;

        exit();
	}

    public function notify(){
        echo '<script type="text/javascript">                   
        $("#enable_otp_response").show();
        setTimeout(function(){ $("#enable_otp_response").hide(); }, 5000);
        </script>';        
    }

    public function Unbind($arr,$arrKeys){
        if(is_array($arrKeys) && is_array($arr)){
            foreach ($arrKeys as $key => $value) {
                unset($arr[$value]);
            }
            return $arr;
        }
        
    }

    public function BulkTransfer($body){
        $this->initializer("transfer/bulk","POST",$body);
        $response=null;
        $response = curl_exec($this->ch);
        
        return $response;
        
    }

    public function ListTransfers($perPage,$page){
        if(!(is_int($perPage) && is_int($page))){
            return "Invalid Parameters";
        }
        
        $params = array('perPage'=>$perPage,'page'=>$page);
        $parami = http_build_query($params);
        $this->initializer("transfer?".$parami,"GET");
        
        $response = null;
        $response = curl_exec($this->ch);        
                
        return $response;
        
    }
    public function FinalizeTransfer($body){
        
        $this->initializer("transfer/finalize_transfer","POST",$body);
        $response=null;
        $response = curl_exec($this->ch);
        
        return $response;        
    }
    public function ResendOTP($body){
        
        $this->initializer("transfer/resend_otp","POST",$body);
        $response=null;
        $response = curl_exec($this->ch);
        
        return $response;        
    }

    public function ListBanks($perPage,$page){
        if(!(is_int($perPage) && is_int($page))){
            return "Invalid Parameters";
        }
        
        $params = array('perPage'=>$perPage,'page'=>$page);
        $parami = http_build_query($params);
        $this->initializer("bank?".$parami,"GET");
        
        $response = null;
        $response = curl_exec($this->ch);        
                
        return $response;
        
    }

    public function CheckBalance(){        
        
        $this->initializer("balance","GET");
        
        $response = null;
        $response = curl_exec($this->ch);        
                
        return $response;
        
    }

    public function DisableOTP(){
        
        $this->initializer("transfer/disable_otp","POST");
        $response=null;
        $response = curl_exec($this->ch);
        
        return $response;
    }

    public function DisableOTPFinalize($body){
        
        $this->initializer("transfer/disable_otp_finalize","POST",$body);
        $response=null;
        $response = curl_exec($this->ch);
        
        return $response;        
    }
    
    public function EnableOTP(){        
        $this->initializer("transfer/enable_otp","POST");
        $response=null;
        $response = curl_exec($this->ch);
        
        return $response;
    }

    public function group_by($key, $data) {
        $result = array();
    
        foreach($data as $val) {    
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
    
        return $result;
    }
	
}


?>