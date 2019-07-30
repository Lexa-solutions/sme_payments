<!DOCTYPE html>
<html>
  <head>
    <title>
      
    <?php

     $comment_count = '';
     $comments = array();

     //Idle Time 
    function auto_logout($field)
    {
        $t = time();
        $t0 = $_SESSION[$field];
        $diff = $t - $t0;
        if ($diff > 1500 || !isset($t0))
        {          
            return true;
        }
        else
        {
            $_SESSION[$field] = time();
        }
    }

    if(auto_logout("admin_user_time"))
    {
        session_unset();
        session_destroy();
        header('location: index.php');  
        exit;
    }   
    
    //Idle Time End

    echo $title;

    ?>

    </title>
    
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="favicon.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    
    <link href="bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">  
    <link href="bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="css/main.css?version=4.4.0" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="icon_fonts_assets/picons-thin/style.css">

    <!-- Loader Start-->
    <link href="css/main2.css" rel="stylesheet">
    <!-- Loader End -->

    

    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    
    <!-- Custom Javascript for baker application -->
    <script type="text/javascript" src="js/custom.js"></script> 
    
   <!-- MDBootstrap Addons Start -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <!-- DataTables CSS -->
      <link href="css/addons/datatables.min.css" rel="stylesheet">

      <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
           
   <!-- MDBootstraps Addons End -->

   <!-- Fusion Charts Start -->
   <script type="text/javascript" src="fusioncharts/fusioncharts.js"></script>
   <script type="text/javascript" src="fusioncharts/fusioncharts.charts.js"></script>
   <script type="text/javascript" src="fusioncharts/fusioncharts.theme.fusion.js"></script>
   
<!-- Scroll bar begin -->
    <style>
      ::-webkit-scrollbar {
        margin-right: 5px;
        background-color: #bdd9d5;
        border-radius: 6px;
        width: 12px;
      }
      ::-webkit-scrollbar-track {
        box-shadow: 0 0 2px rgba(0,0,0,0.3);
      }
      ::-webkit-scrollbar-thumb {
        border: 1px #eee solid;
        border-radius: 12px;
        /* background: #c7573A; */
        /* background: rgb(235,3,42); */
        background: rgb(0,0,104);
        box-shadow: 0 0 8px rgba(0,0,0,0.3) inset;
        -webkit-transition: all .3s ease-out;
        transition: all .3s ease-out;
      }
      ::-webkit-scrollbar-thumb:window-inactive{
        background: #bbb;
      }
    </style>
   <!-- Scroll bar end -->

  </head>
  <body class="menu-position-side menu-side-left full-screen with-content-panel">

   <!-- Loader Start -->
   <div id="loader-wrapper">
			<div id="loader"></div>

			<div class="loader-section section-left"></div>
            <div class="loader-section section-right"></div>

	</div>
  <!-- Loader End -->

    <div class="all-wrapper with-side-panel solid-bg-all">
      <div aria-hidden="true">
        
      </div>
      <div class="search-with-suggestions-w">
        <div class="search-with-suggestions-modal">
          <div class="element-search">
            <input class="search-suggest-input" placeholder="Start typing to search..." type="text" />
              <div class="close-search-suggestions">
                <i class="os-icon os-icon-x"></i>
              </div>
            <!-- </input> -->
          </div>
          <div class="search-suggestions-group">
            <div class="ssg-header">
              
            </div>
            <div class="ssg-content">
              
            </div>
          </div>
          <div class="search-suggestions-group">
            <div class="ssg-header">
              
            </div>
            <div class="ssg-content">
             
            </div>
          </div>
          <div class="search-suggestions-group">
            <div class="ssg-header">
              
            </div>
            <div class="ssg-content">
             
            </div>
          </div>
        </div>
      </div>
      <div class="layout-w">
        <!--------------------
        START - Mobile Menu
        -------------------->
        <div class="menu-mobile menu-activated-on-click color-scheme-dark">
          <div class="mm-logo-buttons-w">
            <a class="mm-logo" href="dashboard.php"><img src="img/logo.png"><span>ICNL PORTAL</span></a>
            <div class="mm-buttons">
              <div class="content-panel-open">
                <div class="os-icon os-icon-grid-circles"></div>
              </div>
              <div class="mobile-menu-trigger">
                <div class="os-icon os-icon-hamburger-menu-1"></div>
              </div>
            </div>
          </div>
          <div class="menu-and-user">
            <div class="logged-user-w">
              <div class="avatar-w">
                <img alt="" src="<?php echo isset($_SESSION['admin_profile']['p_pics']) ? $_SESSION['admin_profile']['p_pics'] : 'img/no-pics.png';?>">
              </div>
              <div class="logged-user-info-w">
                <div class="logged-user-name">
                <?php echo $_SESSION['admin_profile']['fullname'];?>
                </div>
                <div class="logged-user-role">
                  Administrator
                </div>
              </div>
            </div>
            <!--------------------
            START - Mobile Menu List
            -------------------->
            <ul class="main-menu">
                <li <?php echo (CURRENT_PAGE =="customers.php" || CURRENT_PAGE=="dashboard.php") ? 'class="active"' : '' ; ?>>
                    <a href="dashboard.php">
                    <div class="icon-w">
                        <i class="picons-thin-icon-thin-0045_home_house"></i>
                    </div>
                    <span>Dashboard</span></a>
                </li>
                
                <li class="sub-header">
                    <span>Disbursement</span>
                    </li>
                    <li <?php echo (CURRENT_PAGE =="transfer-recipients.php" || CURRENT_PAGE=="kyc-approval.php") ? 'class="active"' : '' ; ?>>
                    <a href="transfer-recipients.php">
                        <div class="icon-w">
                            <i class="picons-thin-icon-thin-0491_box_shipping_modules"></i>
                        </div>
                        <span>Vendors</span></a>
                    </li>
                    <li <?php echo (CURRENT_PAGE =="initiate-transfer.php" || CURRENT_PAGE=="initiate-transfer") ? 'class="active"' : '' ; ?>>
                    <a href="initiate-transfer.php">
                        <div class="icon-w">
                            <i class="picons-thin-icon-thin-0073_documents_files_paper_text_archive_copy"></i>
                        </div>
                        <span>Initiate Transfer</span></a>
                    </li>
                    <li <?php echo (CURRENT_PAGE =="customers.php" || CURRENT_PAGE=="job-requests.php") ? 'class="active"' : '' ; ?>>
                    <a href="transfer-history.php">
                        <div class="icon-w">
                            <i class="picons-thin-icon-thin-0401_graph_growth_money_stock_inflation"></i>
                        </div>
                        <span>Transfer History</span></a>
                    </li>
                               
            </ul>
            <!--------------------
            END - Mobile Menu List
            -------------------->
            <!-- <div class="mobile-menu-magic">
              <h4>
                Light Admin
              </h4>
              <p>
                Clean Bootstrap 4 Template
              </p>
              <div class="btn-w">
                <a class="btn btn-white btn-rounded" href="https://themeforest.net/item/light-admin-clean-bootstrap-dashboard-html-template/19760124?ref=Osetin" target="_blank">Purchase Now</a>
              </div>
            </div> -->
          </div>
        </div>
        <!--------------------
        END - Mobile Menu
        --------------------><!--------------------
        START - Main Menu
        -------------------->
        <div class="menu-w color-scheme-light color-style-transparent menu-position-side menu-side-left menu-layout-compact sub-menu-style-over sub-menu-color-bright selected-menu-color-light menu-activated-on-hover menu-has-selected-link">
          <div class="logo-w">
            <a class="logo" href="dashboard.php">
              <div class="logo-element"></div>
              <div class="logo-label">
                    SWEET CAKES
              </div>
            </a>
          </div>
          <div class="logged-user-w avatar-inline">
            <div class="logged-user-i">
              <div class="avatar-w">
                <img alt="" src="<?php echo isset($_SESSION['admin_profile']['p_pics']) ? $_SESSION['admin_profile']['p_pics'] : 'img/no-pics.png'  ?>"> <!--src in use -->
              </div>
              <div class="logged-user-info-w">
                <div class="logged-user-name">
                  <?php echo $_SESSION['admin_profile']['fullname']; ?>
                </div>
                <div class="logged-user-role">
                Administrator
                </div>
              </div>
              <div class="logged-user-toggler-arrow">
                <div class="os-icon os-icon-chevron-down"></div>
              </div>
              <div class="logged-user-menu color-style-bright">
                <div class="logged-user-avatar-info">
                  <div class="avatar-w">
                    <img alt="" src="<?php echo isset($_SESSION['admin_profile']['p_pics']) ? $_SESSION['admin_profile']['p_pics'] : 'img/no-pics.png'  ?>">
                  </div>
                  <div class="logged-user-info-w">
                    <div class="logged-user-name">
                          <?php echo $_SESSION['admin_profile']['fullname'] ?>
                    </div>
                    <div class="logged-user-role">
                    Administrator
                    </div>
                  </div>
                </div>
                <div class="bg-icon">
                  <i class="os-icon os-icon-wallet-loaded"></i>
                </div>
                <ul>
                  <!-- <li>
                    <a href="apps_email.html"><i class="os-icon os-icon-mail-01"></i><span>Incoming Mail</span></a>
                  </li> -->
                  <li>
                    <a href="#"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a>
                  </li>
                  <!-- <li>
                    <a href="renew-registration.php"><i class="os-icon os-icon-coins-4"></i><span>Subscriptions</span></a>
                  </li> -->
                  <li>
                    <a href="#"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
                  </li>
                  <li>
                    <a href="actions/logout.php"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="menu-actions">
            <!--------------------
            START - Messages Link in secondary top menu
            -------------------->
            <div class="messages-notifications os-dropdown-trigger os-dropdown-position-right">
              <i class="os-icon os-icon-mail-14"></i>
              <div class="new-messages-count">
                <?php echo $comment_count; ?>
              </div>
              <div class="os-dropdown light message-list">
                <ul>
                <?php foreach ($comments as $key=>$comment) : ?>
                  <li>
                    <a href="view-casemanagement.php?comment=&id=<?php echo $comment['case_id'] ?>">
                      <div class="user-avatar-w">
                        <img alt="" src="<?php echo $comment['p_pics'] ?>">
                      </div>
                      <div class="message-content" title="<?php echo $comment['comment'] ?>" data-toggle="tooltip" data-placement="top">
                        <h6 class="message-from">
                          <?php echo $comment['cust_typeid'] == 1 ? $comment['f_name'].' '.$comment['l_name'] : $comment['company_name'] ?>
                        </h6>
                        <h6 class="message-title" >
                          <?php 
                          $ellipsis= strlen($comment['comment']) >= 50 ? '...' : '';
                          echo substr($comment['comment'],0,50) . $ellipsis;  
                          ?>
                        </h6>
                      </div>
                    </a>
                  </li>
                  <?php endforeach; ?>  
                </ul>
              </div>
            </div>
            <!--------------------
            END - Messages Link in secondary top menu
            --------------------><!--------------------
            START - Settings Link in secondary top menu
            -------------------->
            <div class="top-icon top-settings os-dropdown-trigger os-dropdown-position-right">
              <i class="os-icon os-icon-ui-46"></i>
              <div class="os-dropdown">
                <div class="icon-w">
                  <i class="os-icon os-icon-ui-46"></i>
                </div>
                <ul>
                  <li>
                    <a href="#"><i class="os-icon os-icon-ui-49"></i><span>Profile Settings</span></a>
                  </li>
                 
                </ul>
              </div>
            </div>
            <!--------------------
            END - Settings Link in secondary top menu
            --------------------><!--------------------
            START - Messages Link in secondary top menu
            -------------------->
            
            <!--------------------
            END - Messages Link in secondary top menu
            -------------------->
          </div>
          <h1 class="menu-page-header">
            Page Header
          </h1>
          <ul class="main-menu">
                <li <?php echo (CURRENT_PAGE =="customers.php" || CURRENT_PAGE=="dashboard.php") ? 'class="active"' : '' ; ?>>
                    <a href="dashboard.php">
                    <div class="icon-w">
                        <i class="picons-thin-icon-thin-0045_home_house"></i>
                    </div>
                    <span>Dashboard</span></a>
                </li>
               
                <li class="sub-header">
                    <span>Disbursement</span>
                    </li>
                    <li <?php echo (CURRENT_PAGE =="vendors.php" || CURRENT_PAGE=="vendors.php") ? 'class="active"' : '' ; ?>>
                    <a href="vendors.php">
                        <div class="icon-w">
                            <i class="picons-thin-icon-thin-0491_box_shipping_modules"></i>
                        </div>
                        <span>Vendors</span></a>
                    </li>
                    <li <?php echo (CURRENT_PAGE =="initiate-transfer.php" || CURRENT_PAGE=="initiate-transfer") ? 'class="active"' : '' ; ?>>
                    <a href="initiate-transfer.php">
                        <div class="icon-w">
                            <i class="picons-thin-icon-thin-0073_documents_files_paper_text_archive_copy"></i>
                        </div>
                        <span>Initiate Transfer</span></a>
                    </li>
                    <li <?php echo (CURRENT_PAGE =="customers.php" || CURRENT_PAGE=="job-requests.php") ? 'class="active"' : '' ; ?>>
                    <a href="transfer-history.php">
                        <div class="icon-w">
                            <i class="picons-thin-icon-thin-0401_graph_growth_money_stock_inflation"></i>
                        </div>
                        <span>Transfer History</span></a>
                    </li>
                               
            </ul>
        </div>
        <!--------------------
        END - Main Menu
        -------------------->
        <div class="content-w">
                <!--------------------
                START - Top Bar
                -------------------->
                <div class="top-bar color-scheme-transparent">
            
                        <div class="top-menu-start">
                            <img src="img/bakery.png" class="img-fluid" alt="" srcset="">
                        </div>
                        <!--------------------
                        START - Top Menu Controls
                        -------------------->
                        <div class="top-menu-controls">
                          
                          <!--------------------
                          START - Messages Link in secondary top menu
                          -------------------->
                          <div class="welcome-user-text">
                              <h3>Welcome <span><?php echo $_SESSION['admin_profile']['fullname'] ?></span></h3>
                          </div>
                          <div class="logged-user-w">
                            <div class="logged-user-i">
                                <div class="avatar-w">
                                <img alt="" src="<?php echo isset($_SESSION['admin_profile']['p_pics']) ? $_SESSION['admin_profile']['p_pics'] : 'img/no-pics.png'  ?>">
                                </div>
                                <div class="logged-user-menu color-style-bright">
                                <div class="logged-user-avatar-info">
                                    <div class="avatar-w">
                                    <img alt="" src="<?php echo isset($_SESSION['admin_profile']['p_pics']) ? $_SESSION['admin_profile']['p_pics'] : 'img/no-pics.png'  ?>">
                                    </div>
                                    <div class="logged-user-info-w">
                                    <div class="logged-user-name">
                                          <?php echo $_SESSION['admin_profile']['fullname'] ?>
                                    </div>
                                    <div class="logged-user-role">
                                          Administrator
                                    </div>
                                    </div>
                                </div>
                                <div class="bg-icon">
                                    <i class="os-icon os-icon-wallet-loaded"></i>
                                </div>
                                <ul>
                                  
                                    <li>
                                    <a href="#"><i class="os-icon os-icon-user-male-circle2"></i><span>Profile Details</span></a>
                                    </li>
                                   
                                    <li>
                                    <a href="#"><i class="os-icon os-icon-others-43"></i><span>Notifications</span></a>
                                    </li>
                                    <li>
                                    <a href="actions/logout.php"><i class="os-icon os-icon-signs-11"></i><span>Logout</span></a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                          </div>
                          <div class="messages-notifications os-dropdown-trigger os-dropdown-position-left">
                            <i class="fa fa-bell"></i>
                            <div class="new-messages-count">
                              <?php echo $comment_count; ?>
                            </div>
                            <div class="os-dropdown light message-list">
                              <ul>
                              <?php foreach ($comments as $key=>$comment) : ?>
                                <li>
                                  <a href="view-casemanagement.php?comment=&id=<?php echo $comment['case_id'] ?>">
                                    <div class="user-avatar-w">
                                      <img alt="" src="<?php echo $comment['p_pics'] ?>">
                                    </div>
                                    <div class="message-content" title="<?php echo $comment['comment'] ?>"  data-toggle="tooltip" data-placement="top">
                                      <h6 class="message-from">
                                      <?php echo $comment['cust_typeid'] == 1 ? $comment['f_name'].' '.$comment['l_name'] : $comment['company_name'] ?>
                                      </h6>
                                      <h6 class="message-title" >
                                        <?php 
                                        $ellipsis= strlen($comment['comment']) >= 50 ? '...' : '';
                                        echo substr($comment['comment'],0,50) . $ellipsis;  
                                        ?>
                                      </h6>
                                    </div>
                                  </a>
                                </li>
                                <?php endforeach; ?>  
                              </ul>
                            </div>
                          </div>
                          
                          <!--------------------
                          END - Messages Link in secondary top menu
                          --------------------><!--------------------
                          START - Settings Link in secondary top menu
                          -------------------->
                          <div class="top-icon top-settings os-dropdown-trigger os-dropdown-position-left">
                            <i class="os-icon os-icon-ui-46"></i>
                            <div class="os-dropdown">
                              <div class="icon-w">
                                <i class="os-icon os-icon-ui-46"></i>
                              </div>
                              <ul>
                                <li>
                                  <a href="#"><i class="os-icon os-icon-ui-49"></i><span>Profile Settings</span></a>
                                </li>
                              </ul>
                            </div>
                          </div>
                          
                          <!--------------------
                          END - Settings Link in secondary top menu
                          --------------------><!--------------------
                          START - User avatar and menu in secondary top menu
                          -------------------->
                          
                          <!--------------------
                          END - User avatar and menu in secondary top menu
                          -------------------->
                        </div>
                        <!--------------------
                        END - Top Menu Controls
                        -------------------->
                      </div>
                <!--------------------
                END - Top Bar
                --------------------><!--------------------
                START - Breadcrumbs
                -------------------->
              
                <!--------------------
                END - Breadcrumbs
                -------------------->
                <!-- </div>
      </div> -->

     
