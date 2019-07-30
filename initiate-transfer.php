<?php
session_start();

require_once './config/config.php';

include_once './includes/paystack.php';



if(isset($_GET['transfer_code'])){
    $transfer_code = $_GET['transfer_code'];
}

include_once './includes/transfer.php';

$title='Transfer';
include_once 'includes/header.php';

?>

<!-- Finalize Transaction Modal Start -->
       <!-- Modal Window Begin -->
       <div class="modal fade" id="otp" role="dialog">
             <div class="modal-dialog" role="document">
            
             <!-- Modal content-->
                 <div class="modal-content">
                     <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span> </button>
                     <h4 class="modal-title">OTP</h4>
                     </div>
                     <div class="modal-body">

                     <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <?php
                                            if(isset($_SESSION['success']) && isset($_GET['transfer_code'])){ // header('Location:../profile.php'); ?>
                                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <?php echo $_SESSION['success']; unset($_SESSION['success']);?>
                                            </div>
                                            
                                            <?php } ?>
                        </div>
                     </div>
                         
                        <p>To finalize transaction, please enter OTP then click Finalize. <br/> Didn't receive the OTP? Please use the Request OTP button</p>
                        
                        <form method="POST">
                            <input type="hidden" name="action"  value="otp">
                            <input name="otp" type="text" class="form-control"  placeholder="OTP" required/>
                            <input type="hidden" name="transfer_code" value="<?php echo $transfer_code ?>" />
                        
                        
                     </div>
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-info" >Finalize</button>
                         </form>
                         <form method="POST">
                            <input type="hidden" name="action" value="resend_otp" />
                            <input type="hidden" name="transfer_code" value="<?php echo $transfer_code ?>" />
                            <input type="hidden" name="reason" value="transfer" />
                            <button type="submit" class="btn btn-default">Request OTP</button>
                         </form>
                     </div>
                 </div>
            
             </div>
        </div>
        <!-- Modal Window End -->
  <!-- Finalize Transaction Modal End -->

<div class="content-panel-toggler">
            <i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span>
          </div>
          <div class="content-i">
            <div class="content-box">
                <br><br>
                <div class="element-wrapper kyc-wrapper">
                    <div class="element-box">
                        <form action="" method="POST">
                            <div class="form-div">
                                <div class="form-header">
                                    Initiate Transfer
                                </div>
                                <div class="form-body">
                                    <br>
                                    <div class="row">
                                        <div class="col-md-10 offset-md-1">
                                            <?php
                                                            if(isset($_SESSION['success'])){ // header('Location:../profile.php'); ?>
                                                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                                <?php echo $_SESSION['success']; unset($_SESSION['success']);?>
                                                            </div>
                                                            
                                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                    
                                        <div class="col-md-10 offset-md-1">
                                                <!-- Tool Bar Start -->
                                            <?php include './includes/toolbar.php' ?>      
                                        <!-- Tool Bar End -->


                                            <table id="users_DT" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Account No</th>
                                                        <th>Bank</th>
                                                        <th>Created By</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($recipients_data as $key=>$result) : ?>
                                                <tr>                                                                                                
                                                    <td><?php echo $result["name"] ?></td>
                                                    <td><?php echo $result["details"]["account_number"] ?></td>
                                                    <td><?php echo $result["details"]["bank_name"] ?></td>
                                                    <td><?php echo $result["metadata"]["createdBy"] ?></td>
                                                    <td>
                                                    <a title="Initiate Transfer"  href=""  class="btn btn-secondary delete_btn" data-toggle="modal" data-target="#initiate-tranfer-<?php echo $result['id'] ?>"><span class="picons-thin-icon-thin-0402_stock_money_growth_inflation"></span></a>                                                    
                                                    </td>
                                                </tr>

                                                        <!-- Delete Confirmation Modal-->
                                                    <div class="modal fade" id="confirm-delete-<?php echo $result['id'] ?>" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                        <form action="" method="POST">
                                                        <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span> </button>
                                                                <h4 class="modal-title">Confirm</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                            
                                                                    <input type="hidden" name="recipient_code" id = "recipient_code" value="<?php echo $result['recipient_code'] ?>">
                                                                    <input type="hidden" name="action"  value="delete">
                                                                        
                                                                    <p>Are you sure you want to delete <?php echo $result['name']; ?>?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-default pull-left">Yes</button>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        
                                                        </div>
                                                    </div>
                                                        <!-- Edit Confirmation Modal-->
                                                    <div class="modal fade" id="initiate-tranfer-<?php echo $result['id'] ?>" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                        <form action="" method="POST" enctype="multipart/form-data">
                                                        <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span> </button>
                                                                    <h4 class="modal-title">Initiate Transfer</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="text-center text-secondary"> Initiate Transfer to <?php echo $result['name'] ?> </p>
                                                                        <div class="form-group">
                                                                            <label for="">Source <span class="text-danger ">* </span></label>                                                                                    
                                                                            <select class="form-control" name="source">
                                                                                <option value="balance" > Balance </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">Amount <span class="text-danger ">* </span></label>
                                                                            <input class="form-control" placeholder="Amount" type="number" name="amount" step="0.1" required>                                                                            
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">Currency <span class="text-danger ">* </span></label>
                                                                            <select class="form-control" name="currency">
                                                                                <option value="NGN"> Naira (NGN) </option>
                                                                                <option value="USD"> Dollar (USD) </option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">Reason <span class="text-danger "> </span></label>
                                                                            <input class="form-control" placeholder="Reason" type="text" name="reason">                                                                            
                                                                        </div>                                                                   
                                                                        <input type="hidden" name="action"  value="initiate-transfer">
                                                                        <!-- <input type="hidden" name="recipient_code"  value="<?php echo $result['recipient_code'] ?>"> -->
                                                                        <input type="hidden" name="recipient_code"  value="<?php echo $result['recipient_code'] ?>">
                                                                       
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-default pull-left">Transfer</button>
                                                                        <button type="button" class="btn btn-info" data-dismiss="modal">Back</button>
                                                                    </div>
                                                            </div>
                                                        </form>
                                                        
                                                        </div>
                                                    </div>
                                            <?php endforeach; ?>
                                                </tbody>
                                                
                                            </table>

                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--------------------
            START - Sidebar
            -------------------->
            <!--------------------
            END - Sidebar
            -------------------->
          </div>
        </div>
      </div>
      <div class="display-type"></div>
    </div>
    

    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>  
    <!-- MDBootstrap Datatables  -->
    <script type="text/javascript" src="js/addons/datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
        $('#users_DT').DataTable();
        $('.dataTables_length').addClass('bs-select');
        });
    </script>

<script type="text/javascript"> 
        var urlParams = new URLSearchParams(window.location.search);
        
        if(urlParams.has('transfer_code')){
            $('#otp').modal('show');
        }
        else{
            $('#otp').modal('hide');  
        }
        
</script>

    <?php
    include_once 'includes/footer.php'
    ?>