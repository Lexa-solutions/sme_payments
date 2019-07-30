<div class="form-group">
     <label for="">Vendor Name <span class="text-danger ">* </span></label>                                                                                    
         <input class="form-control" placeholder="Name" type="text" name="name" required value="<?php if(isset($result)) echo $result["name"] ?>">                                                                                    
 </div>

 <div class="form-group">
     <label for="">Email <span class="text-danger ">* </span> </label>                                                                                
         <input class="form-control" placeholder="Email" type="text" name="email" required value="<?php if(isset($result)) echo $result['email'] ?>">
 </div>

 <div class="form-group">
     <label for="">Bank Account No. <span class="text-danger ">* </span></label>
     <input class="form-control" placeholder="Account Number" type="text" name="account_number" size="10" required <?php if(isset($result)) echo 'disabled'; ?> 
        value="<?php if(isset($result)) echo $result['details']['account_number'] ?>">
     <div class="invalid-feedback">Account Number is not invalid.</div>
     
 </div>
 <!-- <div class="form-group">
     <label for="">Bank Account Name </label>
     <input class="form-control" placeholder="Account Name" type="text" name="account_name" size="100" value="<?php if(isset($result)) echo $result['details']['account_name'] ?>">                                                                                    
 </div> -->
 <div class="form-group">
     <label for="">Bank <span class="text-danger ">* </span></label>                                                                                
     <select class="form-control" name="bank_code" <?php if(isset($result)) echo 'disabled'; ?>>
         <!-- <option value="044" <?php if(isset($result)) echo $result['details']['bank_code']=="044" ? "Selected" : "" ?>> Access Bank </option> -->
         <?php
            foreach ($banks_data as $opt) {
                if (isset($result) && $opt['code'] == $result['details']['bank_code']) {
                    $sel = "selected";
                } else {
                    $sel = "";
                }
                echo '<option value="'.$opt['code'].'"' . $sel . '>' . $opt['name'] . '</option>';
            }
         ?>
     </select>
 </div>
                                                                          
 <div class="form-group">
     <label for="">Base Currency <span class="text-danger ">* </span></label>
     <select class="form-control" name="currency" <?php if(isset($result)) echo 'disabled'; ?>>
         <option value="NGN" <?php if(isset($result)) echo $result['currency']=="NGN" ? "Selected" : "" ?> > Naira (NGN) </option>
         <option value="USD" <?php if(isset($result)) echo $result['details']=="USD" ? "Selected" : "" ?> > Dollar (USD) </option>
     </select>
 </div>

 <div class="form-group">
     <label for="">Other Details</label>
     <input class="form-control" placeholder="Other Details" type="text" name="description" <?php if(isset($result)) echo 'disabled'; ?> 
        value="<?php if(isset($result)) echo $result["description"] ?>">
 </div>

<?php if(isset($result)) { ?>
    <div class="form-group">
     <label for="">Recipient Code</label>
     <input class="form-control" disabled type="text" value="<?php echo $result["recipient_code"] ?>">
    </div>
<?php } ?>

 <input class="form-control" value="nuban" type="hidden" name="type">

 
 <script>
    //Validate Account No.
    $("input[name=account_number]").change(function (){
            var accNo = $("input[name=account_number]").val();
            
            if(accNo.length < 10 || accNo.length > 10){
                $("input[name=account_number]").addClass("is-invalid");
            }
            else{
                $("input[name=account_number]").removeClass("is-invalid");
            }
        });
 </script>