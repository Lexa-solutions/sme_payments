<?php
session_start();
require_once './config/config.php';
require_once 'fusioncharts/fusioncharts.php';
include_once './includes/paystack.php';

$paystack = new Paystack();

//Get Paystack Balance
$balance = $paystack->CheckBalance();
$balance = json_decode($balance, TRUE);
$balance = $balance['data'][0];

//List Transfer Recipients
$recipients = $paystack->RetrieveTransferRecipient(5,1);
$recipients_arr = json_decode($recipients, TRUE);

//List Transfers
$transfers = $paystack->ListTransfers(10,1);
$transfers_arr = json_decode($transfers, TRUE);

$transfers_data = array();
$RecurringExpense = array();
$transactionStatus = array();
if(isset($transfers_arr['data'])){
    $transfers_data = $transfers_arr['data'];

    $mini_transfer = array();
    for($i = 0; $i < count($transfers_data); $i++) {
        array_push($mini_transfer, array(
            "reason" => $transfers_data[$i]['reason'], "status" => $transfers_data[$i]['status']
        ));
    }

    $recurringExpenseGroup = $paystack->group_by("reason", $mini_transfer);
    $transactionStatusGroup = $paystack->group_by("status", $mini_transfer);

    foreach($recurringExpenseGroup as $key=>$result){
        array_push($RecurringExpense, array(
            "reason" => $key, "no_" => count($result)
        ));
    }

    foreach($transactionStatusGroup as $key=>$result){
      array_push($transactionStatus, array(
          "status" => $key, "no_" => count($result)
      ));
    }
}


//Get DB instance. function is defined in config.php
$db = getDbInstance();

$title = 'Dashboard';

include_once 'includes/header.php';


    // Chart Configuration stored in Associative Array
    $arrChartConfig = array(
        "chart" => array(
            "caption" => "Recurring Expenses",
            "subCaption" => "",
            "xAxisName" => "Expense (Reason for Payment)",
            "yAxisName" => "No of Payments",
            "numberSuffix" => "",
            "theme" => "fusion"
        )
    ); 

  $arrLabelValueData = array();

  
  // Pushing labels and values
  for($i = 0; $i < count($RecurringExpense); $i++) {
      array_push($arrLabelValueData, array(
          "label" => $RecurringExpense[$i]['reason'], "value" => $RecurringExpense[$i]['no_']
      ));
  }

  $arrChartConfig["data"] = $arrLabelValueData;

   // JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
   $jsonEncodedData = json_encode($arrChartConfig);

   // chart object
   $Chart = new FusionCharts("column2d", "Job History" , "700", "400", "chart-container", "json", $jsonEncodedData);

   // Render the chart
   $Chart->render();

  //Histogram Chart End

  //Pie Chart Start
   // Chart Configuration stored in Associative Array
   $arrChartConfig2 = array(
    "chart" => array(
        "caption" => "Transfer History",
        "subCaption" => "Transfer Status",
        "showValues" => "1",
        "showPercentInTooltip" => "0",
        "numberPrefix" => "$",
        "enableMultiSlicing" => "1",
        "theme" => "fusion"
    )
);

$arrLabelValueData2 = array();

   for($i = 0; $i < count($transactionStatus); $i++) {
       array_push($arrLabelValueData2, array(
           "label" => $transactionStatus[$i]['status'], "value" => $transactionStatus[$i]['no_']
       ));
   }

      $arrChartConfig2["data"] = $arrLabelValueData2;

      // JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
      $jsonEncodedData2 = json_encode($arrChartConfig2);

      // chart object
      $Chart2 = new FusionCharts("pie3d", "Job Tracking" , "286", "286", "chart-container2", "json", $jsonEncodedData2);
   
      // Render the chart
      $Chart2->render();


?>


                <div class="content-panel-toggler">
                  <i class="os-icon os-icon-grid-squares-22"></i><span>Sidebar</span>
                </div>
                <div class="content-i">
                  <div class="content-box">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="element-wrapper">
                          <div class="element-content">
                            <div class="row">
                              <div class="col-sm-4 col-xxxl-4 resize color_1">
                                <a class="element-box el-tablo" href="#">
                                  <div class="label">
                                    Paystack Balance
                                  </div>
                                  <div class="value">
                                    <?php echo $balance['currency'] . ' ' . number_format($balance['balance']/100,2) ?>
                                  </div>
                                </a>
                              </div>
                              <div class="col-sm-4 col-xxxl-4 resize color_2">
                                <a class="element-box el-tablo" href="#">
                                  <div class="label">
                                    VENDORS
                                  </div>
                                  <div class="value">
                                  <?php echo count($recipients_arr) ?>
                                  </div>
                                </a>
                              </div>
                              <div class="col-sm-4 col-xxxl-4 resize color_3">
                                <a class="element-box el-tablo" href="#">
                                  <div class="label">
                                    Total Transfers
                                  </div>
                                  <div class="value">
                                  <?php echo count($transfers_data) ?>
                                  </div>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      
                      <div class="col-sm-8 col-xxxl-6">
                        <!--START - Questions per Product-->
                        <!-- <div class="element-wrapper"> -->
                          <!-- <div class="element-box">
                                <div class="el-chart-w">
                                    <canvas height="145" id="barChart1" width="300"></canvas>
                                </div>
                          </div> -->
                                <div id="chart-container">
                                    Chart will render here
                                </div>
                        <!-- </div> -->
                        <!--END - Questions per product                  -->
                      </div>
                      <div class="col-sm-4 d-xxxl-none">
                            <!--START - Top Selling Chart-->
                            <div class="element-wrapper">
                              <!-- <h6 class="element-header">
                                Top Selling Today
                              </h6> -->
                              <div class="element-box">

                              <div id="chart-container2">
                                   Pie Chart will render here
                              </div>
                                <!-- <div class="el-chart-w"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                  <canvas height="286" id="donutChart" width="286" class="chartjs-render-monitor" style="display: block; height: 143px; width: 143px;"></canvas>
                                  <div class="inside-donut-chart-label">
                                    <strong>142</strong><span>Total Orders</span>
                                  </div>
                                </div> -->
                                
                              </div>
                            </div>
                            <!--END - Top Selling Chart-->
                          </div>
                    </div>
                    <div class="row">
                      
                    </div>
                    <div class="row">
                      
                    </div><!--------------------
                    START - Color Scheme Toggler
                    -------------------->
                    
                    <!--------------------
                    END - Color Scheme Toggler
                    --------------------><!--------------------
                    START - Demo Customizer
                    -------------------->
                    
                    <!--------------------
                    END - Demo Customizer
                    --------------------><!--------------------
                    START - Chat Popup Box
                    -------------------->
                   
                    <!--------------------
                    END - Chat Popup Box
                    -------------------->
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

    <?php
    include_once 'includes/footer.php'
    ?>
   