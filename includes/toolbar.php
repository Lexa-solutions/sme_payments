
<!-- <h5 class="d-flex justify-content-start align-items-baseline flex-wrap"> -->
    <div class="btn-toolbar">
        <div class="btn-group mr-2">
            <a href="" class="btn btn-primary" data-toggle="modal" data-target="#create-user" class="btn btn-primary">+Add Vendor</a>
            <a href="transfer-history.php" class="btn btn-secondary" class="btn btn-primary">List Transfers</a>
            <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#bulk-transfer" >Bulk Transfer</button>
        </div>
        
        <div class="btn-group">
            <button class="btn btn-default" type="button" id="chk_balance">Check Balance</button>
            <button class="btn btn-danger" type="button" id="disable_otp">Disable OTP</button>
            <button class="btn btn-success" type="button" id="enable_otp" >Enable OTP</button>
        </div>
      
    </div>                                           
<!-- </h5>     -->

  <!-- Create Vendor-->
    <div class="modal fade" id="create-user" role="dialog">
        <div class="modal-dialog" role="document">
        <form action="" method="POST">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span> </button>
                <h4 class="modal-title">+Add Vendor</h4>
                </div>
                <div class="modal-body">
                    <?php include './includes/vendor_form.php' ?>                                                                   
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-lg btn-primary btn-raduis pl-4 pr-4 text-right">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        
        </div>
    </div>
    <!-- End Create Vendor  -->

<!-- Check Balance Modal-->
<div class="modal fade" id="chk-balance" role="dialog">
        <div class="modal-dialog" role="document">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span> </button>
                <h4 class="modal-title">Balance</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center text-secondary"> Available Balance </p>
                    <p class="text-center text-secondary" id="balance">  </p>                                                            
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        
        </div>
    </div>
       
<!-- Check Balance End -->


 <!-- Disable OTP -->
       <div class="modal fade" id="disable-otp" role="dialog">
             <div class="modal-dialog" role="document">
            
             <!-- Modal content-->
                 <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span> </button>
                        <h4 class="modal-title">Disable OTP</h4>
                     </div>
                     <div class="modal-body">

                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="alert alert-info alert-dismissible fade show" role="alert" id="disable_otp_response">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                </div>
                            </div>
                        </div>
                            <form method="POST" id="disable_otp_form">
                                <input type="hidden" name="action"  value="disable_otp_finalize">
                                <input name="otp" type="text" class="form-control"  placeholder="OTP" required/>                        
                            
                     </div>
                     <div class="modal-footer">
                        <button id="disable_otp_button" type="submit" class="btn btn-info" >Disable OTP</button>
                         </form>
                     </div>
                 </div>
            
             </div>
        </div>

  <!-- Disable OTP End -->

  <!-- Enable OTP -->
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="enable_otp_response" style="position:fixed;top:2em;right:2em;display:none">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p class="text-md"> </p>
            
        </div>
  <!-- Enable OTP End -->

  <!-- Bulk Transfer Start -->
  <div class="modal fade" id="bulk-transfer" role="dialog">
        <div class="modal-dialog" role="document">
        <form action="" method="POST" enctype="multipart/form-data">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span> </button>
                <h4 class="modal-title">Bulk Transfer</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action"  value="bulk_transfer">
                    <div class="form-group">
                           <label for="">Source <span class="text-danger ">* </span></label>                                                                                    
                           <select class="form-control" name="source">
                               <option value="balance" > Balance </option>
                           </select>
                    </div>
                    <div class="form-group">
                        <label for="">Currency <span class="text-danger ">* </span></label>
                        <select class="form-control" name="currency">
                            <option value="NGN"> Naira (NGN) </option>
                            <option value="USD"> Dollar (USD) </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="transfer_csv"> Upload CSV File <a href="bulk-transfer.csv"> See sample csv </a></label>
                        <input name="transfer_csv" class="form-control" type="file" accept=".csv"/>
                        <div class="invalid-feedback">Accepted format: csv. Max Size: 500kb</div>
                    </div>
                </div>                                                              
                
                <div class="modal-footer">
                    <button type="submit" id="bulk_transfer_button" class="btn btn-lg btn-primary btn-raduis pl-4 pr-4 text-right">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
        
        </div>
    </div>
  <!-- Bulk Transfer End -->



<script type="text/javascript"> 
        $('#chk_balance').click(function(){
            notify();
            var queryString = "?chk_balance="+ "ctrl_02930Z9II$0102!94@02";
            $.ajax({
                url: 'transfer-history.php' + queryString,
                type: 'GET',
                dataType: 'JSON',
                success: function(response){
                    // alert(responseText);
                    // alert(JSON.stringify(response));
                    if(response != null){
                        var balance = response[0].currency + " " + new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 }).format(response[0].balance/100) ;
                        // alert(response[0].balance); 
                        $('#balance').html(balance);
                        $('#chk-balance').modal('show');
                    }
                    
                },
                error: function(error){
                    alert(JSON.stringify(error));
                }
            });
            
        });

        $('#disable_otp').click(function(){
            var x = confirm("Are you sure you want to disable otp requirements for transfers");
            if(x){
                notify();
                var queryString = "?disable_otp="+ "ctrl_02930Z9II$0102!94@02";
                $.ajax({
                    url: 'transfer-history.php' + queryString,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response){                    
                        if(response != null){                        
                            $('#disable_otp_response').html(response.message);
                            if(response.message.includes("already disabled")){
                                $('#disable_otp_form input').hide();
                                $('#disable_otp_button').hide();
                            }
                            $('#disable-otp').modal('show');
                        }
                        
                    },
                    error: function(error){
                        alert(JSON.stringify(error));
                    }
                });
            }
        });

        $('#enable_otp').click(function(){
            var x = confirm("Are you sure you want to enable otp requirements for transfers");
            if(x){
                notify();
                var queryString = "?enable_otp="+ "ctrl_02930Z9II$0102!94@02";
                $.ajax({
                    url: 'transfer-history.php' + queryString,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response){                    
                        if(response != null){                 
                            notify(response.message);
                        }
                        
                    },
                    error: function(error){
                        //alert(JSON.stringify(error));
                    }
                });
            }
        });


        //Bulk Transfer CSV file Control
        $("input[name=transfer_csv]").change(function (){
            docControl();
        });

        //Prevent submission if invalid file is uploaded
        $("#bulk_transfer_button").click(function (){
            docControl();
            // event.preventdefault();
        });
        
</script>

<!-- <script type="text/javascript" src="js/custom.js"></script> -->