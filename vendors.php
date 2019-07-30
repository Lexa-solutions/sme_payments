<?php
session_start();

require_once './config/config.php';

include_once './includes/paystack.php';

$paystack = new Paystack();
include_once './includes/transfer.php';



$title='Vendors';
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
                                    Vendors
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
                                                <h5 class="d-flex justify-content-start align-items-baseline flex-wrap">
                                                  <span></span> 
                                                  <!-- <a href="create-user.html" class="btn btn-primary">Create New Admin User</a>  -->
                                                  <a href="" class="btn btn-primary" data-toggle="modal" data-target="#create-vendor" class="btn btn-primary">+Add Vendor</a>                                                  
                                                </h5>    

                                                  <!-- Create Admin User-->
                                                    <div class="modal fade" id="create-vendor" role="dialog">
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
                                                    <a title="Edit" href=""  class="btn btn-info delete_btn" data-toggle="modal" data-target="#edit-<?php echo $result['id'] ?>" style="margin-right: 8px;"><span class="picons-thin-icon-thin-0001_compose_write_pencil_new"></span></a>
                                                    <a title="Delete Transfer" href=""  class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $result['id'] ?>" style="margin-right: 8px;"><span class="picons-thin-icon-thin-0060_error_warning_danger_stop_delete_exit"></span></a>
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
                                                    <div class="modal fade" id="edit-<?php echo $result['id'] ?>" role="dialog">
                                                        <div class="modal-dialog" role="document">
                                                        <form action="" method="POST" enctype="multipart/form-data">
                                                        <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span> </button>
                                                                    <h4 class="modal-title">Update Vendor</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="action"  value="update">
                                                                        <input type="hidden" name="recipient_code"  value="<?php echo $result['recipient_code'] ?>">
                                                                        <?php include './includes/vendor_form.php' ?>
                                                                       
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-default pull-left">Apply</button>
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

    <?php
    include_once 'includes/footer.php'
    ?>