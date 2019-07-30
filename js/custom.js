function docControl(){
    var fileName = $("input[name=transfer_csv]")[0].files[0].name;
    var fileSize = $("input[name=transfer_csv]")[0].files[0].size;
    var ext = fileName.substring(fileName.lastIndexOf('.') + 1);            
    
    if(fileSize > 512000 || ext !== "csv"){
        $("input[name=transfer_csv]").addClass("is-invalid");
        event.preventDefault();
    }
    else{
        $("input[name=transfer-csv]").removeClass("is-invalid");
    }
}


//Helper method to notify user of background process
function notify(msg="Request in progress"){
    // $('#enable_otp_response p').html("Request in progress");   
    $("#enable_otp_response p").html(msg);                            
    $("#enable_otp_response").show();
    setTimeout(function(){ $("#enable_otp_response").hide(); }, 5000);
}

