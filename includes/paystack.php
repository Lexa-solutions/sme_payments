<?php

class Paystack
{
	protected $url;
    protected $headers;
    protected $ch;
    protected $error_message;
    protected $resp_data;
	
	// public function __construct($path, $method) {
    // }

    //Method to initialize curl and set necessary parameters
    private function initializer($path,$method,$data=null){
        $this->error_message = null;

        $this->url = "https://api.paystack.co/".$path;

        
        $this->headers = array(
            "GET /HTTP/1.1",
            "Authorization: Bearer sk_test_69077a85657fee71114db13e2a793998ab92f8d6",
            "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.1) Gecko/2008070208 Firefox/3.0.1",
            "Content-type: application/json",
            "Accept-Language: en-us,en;q=0.5",
            "Keep-Alive: 300",
            "Connection: keep-alive",
        );
               
        
        $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);   
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);     
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 60); 
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
       
        
        if($data != null){
            $data_string = json_encode($data);
            $_SESSION['data_string'] = $data_string;
            //curl_setopt($this->ch, CURLOPT_POST, true );
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data_string);
            
        }
       
        

    }

    private function returnResponse($resp){
        $json = null;

        

        if (!curl_errno($this->ch)) 
        {             
                $errno = curl_errno($this->ch);
                $this->error_message = curl_strerror($errno);
               
                curl_close($this->ch);                
        }
        else 
        {  
            // Show me the result
            $this->resp_data = $resp;
            
            curl_close($this->ch);    //END CURL SESSION///////////////////////////////
        }
    }
		
	public function CreateTransferRecipient($body){
        
        $this->initializer("transferrecipient","POST",$body);
        $response=null;
        $response = curl_exec($this->ch);

        
        return $response;
        
    }
    
    public function RetrieveTransferRecipient($perPage,$page){
        if(!(is_int($perPage) && is_int($page))){
            return "Invalid Parameters";
        }
        
        $params = array('perPage'=>$perPage,'page'=>$page);
        $parami = http_build_query($params);
        $this->initializer("transferrecipient?".$parami,"GET");
        
        $response = null;
        $response = curl_exec($this->ch);

        //$this->returnResponse($response);
        
                
        return $response;
        
        // if($this->error_message == null){
        //     $_SESSION['data_to'] = "Error " . $this->error_message;
        //     return $this->error_message;            
        // }            
        // else{
        //     $_SESSION['data_to'] = "Success " . $this->resp_data;
        //     return $this->resp_data;

        // }
	}
	
	public function UpdatetransferRecipient($recipient_code,$body){
        
        $this->initializer("transferrecipient/".$recipient_code,"PUT",$body);
        $response=null;
        $response = curl_exec($this->ch);

        
        return $response;
        
    }

    public function DeletetransferRecipient($recipient_code){

        $this->initializer("transferrecipient/".$recipient_code,"DELETE");
        $response=null;
        $response = curl_exec($this->ch);

        $_SESSION['response']=$response;
        return $response;
    }

    public function InitiateTransfer($body){

        $_SESSION['data2'] = $body;
        $this->initializer("transfer","POST",$body);
        $response=null;
        $response = curl_exec($this->ch);
        
        return $response;
        
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