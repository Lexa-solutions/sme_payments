<?php
session_start();

require_once './config/config.php';

include_once './includes/paystack.php';
include_once './includes/transfer.php';




$transfers = $paystack->ListTransfers(10,1);
$transfers_arr = json_decode($transfers, TRUE);


$transfers_data = array();

if(isset($transfers_arr['data']))
    $transfers_data = $transfers_arr['data'];

$_SESSION['transfers'] = $transfers_data;

$title='Transfer History';
include_once 'includes/header.php';

?>


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
                                    Transfer History
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
                                                        <th>Vendor</th>
                                                        <th>Account No</th>
                                                        <th>Amount</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($transfers_data as $key=>$result) : ?>
                                                <tr>                                                                                                
                                                    <td><?php echo $result["recipient"]["name"] ?></td>
                                                    <td><?php echo $result['recipient']["details"]["account_number"] ?></td>
                                                    <td><?php echo $result["currency"].number_format($result["amount"]/100,2) ?></td>
                                                    <td><?php echo ucfirst($result["status"]) ?></td>
                                                    <td>
                                                    <a title="Initiate Transfer"  href=""  class="btn btn-secondary delete_btn" data-toggle="modal" <?php echo $result['status'] == 'otp' ? 'data-target="#transfer-otp-'.$result['id'].'"' : 'data-target="#initiate-tranfer-'.$result['id'].'"' ?> ><span class="picons-thin-icon-thin-0402_stock_money_growth_inflation"></span></a>                                                    
                                                    </td>
                                                </tr>

                                                        <!-- Delete Confirmation Modal-->
                                                    <div class="modal fade" id="transfer-otp-<?php echo $result['id'] ?>" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                        <form action="" method="POST">
                                                        <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span> </button>
                                                                <h4 class="modal-title">OTP</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                            
                                                                    <p>To finalize transaction, please enter OTP then click Finalize. <br/> Didn't receive the OTP? Please use the Request OTP button</p>
                        
                                                                    <form method="POST">
                                                                        <input type="hidden" name="action"  value="otp">
                                                                        <input name="otp" type="text" class="form-control"  placeholder="OTP" />
                                                                        <input type="hidden" name="transfer_code" value="<?php echo $result['transfer_code'] ?>" />

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-info" >Finalize</button>
                                                                    </form>
                                                                    <form method="POST">
                                                                        <input type="hidden" name="action" value="resend_otp" />
                                                                        <input type="hidden" name="transfer_code" value="<?php echo $result['transfer_code'] ?>" />
                                                                        <input type="hidden" name="reason" value="transfer" />
                                                                        <button type="submit" class="btn btn-default">Request OTP</button>
                                                                    </form>
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
                                                                    <h4 class="modal-title">About your transfer</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p class="text-center text-primary"> <?php echo $result["currency"].' '.number_format($result["amount"]/100,2) . ' to ' . $result["recipient"]["name"] ?> </p>
                                                                        <p class="text-center text-dark"> <?php echo $result['recipient']["details"]["account_number"] . ' ' . $result['recipient']["details"]["bank_name"] ?> </p>
                                                                        <ul class="list-group mt-5 list-group-flush">
                                                                            <li class="list-group-item d-flex justify-content-between align-items-center">Status <span class=""><?php echo ucfirst($result['status']) ?></span></li>
                                                                            <li class="list-group-item d-flex justify-content-between align-items-center">Created <span class=""><?php  echo date("d-m-Y H:i:s", strtotime($result['createdAt'])) ?></span></li>
                                                                            <li class="list-group-item d-flex justify-content-between align-items-center">Transfer Code  <span class=""><?php echo $result['transfer_code'] ?></span></li>
                                                                            <li class="list-group-item d-flex justify-content-between align-items-center">Transfer Reference <span class=""><?php echo $result['reference'] ?></span></li>
                                                                            <li class="list-group-item d-flex justify-content-between align-items-center">Transferred From <span class=""><?php echo $result["currency"].' '. ucfirst($result['source']) ?></span></li>
                                                                            <li class="list-group-item"> <span class="text-secondary">Notes: </span> <span class=""><?php echo $result['reason'] ?></span></li>
                                                                            
                                                                        </ul>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <!-- <button type="submit" class="btn btn-default pull-left">Transfer</button> -->
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

    <!-- Modal Alert -->
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
                         
                        <p>To finalize transaction, please enter OTP then click Finalize. <br/> Didn't receive the OTP? Please use the Request OTP button</p>
                        
                        <form method="POST">
                            <input type="hidden" name="action"  value="otp">
                            <input id="otp" type="text" class="form-control"  placeholder="OTP" />
                            <input id="transfer_code" type="hidden" class="form-control" value="<?php echo $transfer_code ?>" />
                        
                        
                     </div>
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-info" >Finalize</button>
                         </form>
                         <form method="POST">
                            <input type="hidden" name="action" value="resend_otp" />
                            <input type="hidden" class="form-control" value="<?php echo $transfer_code ?>" />
                            <input type="hidden" name="reason" value="resend_otp" />
                            <button type="submit" class="btn btn-default">Request OTP</button>
                         </form>
                     </div>
                 </div>
            
             </div>
        </div>
        <!-- Modal Window End -->
  <!-- Modal Alert End -->

    

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



    <?php
    include_once 'includes/footer.php'
    ?>