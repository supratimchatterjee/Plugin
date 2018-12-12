jQuery(document).ready(function($){
	$('#ch_Form').on('submit', function(e){
		e.preventDefault();
		$consignmentno = $('#consignmentno').val();
		jQuery('.chResult').hide();
		var sHtml = '';

		if(consignmentno){
			$.ajax({
	            type: "POST",
	            url: ajaxurl,
	            dataType: "json",
	            data: {
	                action: "chSearch",
	                sVal: $consignmentno
	            },
	            success: function(data) {
	            		var json = JSON.parse(data.all);

	            		//console.log(allStatus.join(','));
	                	console.log(data);
	                	console.log(json);
	                	
	                	
	                	var cnvertstatus = (data.lastStatus)?data.lastStatus:json.status;

	                	
	                		sHtml  =+ '<tr id="'+data.consignmentNo+'">'
									+ '<td>'+data.consignmentNo+'</td>'
									+ '<td>'+json.origin+'</td>'
									+ '<td>'+json.destination+'</td>'
									+ '<td>'+new Date(data.insert_date).toYMD()+ ' '+ currentTime( new Date(data.insert_date) )+'</td>'
									+ '<td>'+cnvertstatus+'</td>'
									+ '<td><div class="report"><a '
									+ 'data-consignmentno="'+json.consignmentNo+'"'
									+ 'data-shippername="'+json.shipperName+'"'
									+ 'data-shippertel="'+json.shipperTel+'"'
									+ 'data-shipperaddress="'+json.shipperAddress+'"'
									+ 'data-receivername="'+json.receiverName+'"'
									+ 'data-receivertel="'+json.receiverTel+'"'
									+ 'data-receiveraddress="'+json.receiverAddress+'"'
									+ 'data-typeofshipment="'+json.typeOfShipment+'"'
									+ 'data-weight="'+json.weight+'"'
									+ 'data-invoiceno="'+json.invoiceNo+'"'
									+ 'data-qnty="'+json.qnty+'"'
									+ 'data-totalfreight="'+json.totalFreight+'"'
									+ 'data-mode="'+json.mode+'"'
									+ 'data-depttime="'+json.deptTime+'"'
									+ 'data-origin="'+json.origin+'"'
									+ 'data-destination="'+json.destination+'"'
									+ 'data-pickupdate="'+new Date(data.insert_date).toYMD()+ ' '+ currentTime( new Date(data.insert_date) )+'"'
									+ 'data-status="'+cnvertstatus+'"'
									+ "data-allstatus='"+data.allstatus+"'" 
									+ "data-comments='"+json.comments+"'" 
									+ 'data-expecteddlydate="'+json.expectedDlyDate+'"'
									+ 'href="javascript:void(0)" class="viewReport visiable"><div alt="f504" class="dashicons dashicons-external"></div></a></div></td>'
									+ '</tr>';
	                	
	                	jQuery('.chResult .resultInner tbody').html(sHtml);
	                	jQuery('.chResult').slideDown();
	                	/*jQuery(thisF).closest('.booking_search').next('table').find('tbody').html(sHtml);
	                	jQuery(thisF).closest('.booking_search').next('table').find('tbody').slideDown();*/
	            }, 
	            error: function(errorThrown) {
      		console.log(errorThrown);
   			}
	        });
		}else{
			alert('no');
		}
	});




	$(document.body).on('click', 'a.viewReport.visiable', function(){
		/*
			* View Report Function
		*/
		$('.reportView').remove();
		var tr = $(this);
		var currentS = $(tr).data('allstatus');
		console.log(currentS);
		var cStatus = '';				
		for(var z=0; z < currentS.length; z++){
			var fdate = new Date(currentS[z].deliveryDate);
			var str = fdate.toYMD();
					cStatus +=	'<tr>'
							+	'<td>' + str + '</td>'
							+	'<td>'+currentS[z].deliveryTime+'</td>'
							+	'<td>'+currentS[z].newLocation+'</td>'
							+	'<td>'+currentS[z].newStatus+'</td>'
							+	'<td>'+currentS[z].comments+'</td>'
							+	'</tr>';
						}
		var newHtml = 		'<div class="reportView" style="display:none;"><div class="updateStatis pt50">'
						+ 	'<h3 class="mt30">Tracking Shipment</h3>'
						+	'<div class="topTable">'
						+	'<table align="center" cellpadding="2" cellspacing="2" bgcolor="#EEEEEE">'			
						+	'<tbody><tr>'
						+	'<td align="right" bgcolor="#FFFFFF" class="Partext1"><div align="center">'
						+	'<table width="80%" border="0" cellspacing="1" cellpadding="1">'
						+	'<tbody><tr>'
						+	'<td width="55%"><div align="left">Shipper Name : </div></td>'
						+	'<td width="45%"><div align="left">'+$(tr).data('shippername')+'</div></td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td><div align="left">Shipper Phone : </div></td>'
						+	'<td><div align="left">'+$(tr).data('shippertel')+'</div></td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td><div align="left">Shipper Address : </div></td><td>'+$(tr).data('shipperaddress')+'</div></td>'
						+	'</tr>'
						+	'</tbody></table>'
						+	'</div></td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1"><div align="center">'
						+	'<table width="80%" border="0" cellspacing="1" cellpadding="1">'
						+	'<tbody><tr>'
						+	'<td width="55%"><div align="left">Receiver Name : </div></td>'
						+	'<td width="45%"><div align="left">'+$(tr).data('receivername')+'</div></td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td><div align="left">Receiver Phone : </div></td>'
						+	'<td><div align="left">'+$(tr).data('receivertel')+'</div></td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td><div align="left">Receiver Address : </div></td>'
						+	'<td><div align="left">'+$(tr).data('receiveraddress')+'</div></td>'
						+	'</tr>'
						+	'</tbody></table>'
						+	'</div></td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td align="right" bgcolor="#FFFFFF" class="Partext1">&nbsp;</td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1">&nbsp;</td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td width="336" align="right" bgcolor="#FFFFFF" class="Partext1">Consignment No  : </td>'
						+	'<td width="394" bgcolor="#FFFFFF" class="Partext1">'+$(tr).data('consignmentno')+'</td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td align="right" bgcolor="#FFFFFF" class="Partext1">Ship Type  :</td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1">'+$(tr).data('typeofshipment')+'</td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td align="right" bgcolor="#FFFFFF" class="Partext1">Weight :</td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1">'+$(tr).data('weight')+' (kg)</td>'
						+	'</tr>'	
						+	'<tr>'
						+	'<td align="right" bgcolor="#F3F3F3" class="Partext1">Invoice no  :</td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1">'+$(tr).data('invoiceno')+'</td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td align="right" bgcolor="#F3F3F3" class="Partext1">Total freight : </td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1">'+$(tr).data('totalfreight')+'</td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td align="right" bgcolor="#F3F3F3" class="Partext1">Mode : </td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1">'+$(tr).data('mode')+'</td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td align="right" bgcolor="#FFFFFF" class="Partext1">Origin : </td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1">'+$(tr).data('origin')+'</td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td align="right" bgcolor="#FFFFFF" class="Partext1">Destination :</td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1">'+$(tr).data('destination')+'</td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td align="right" bgcolor="#FFFFFF" class="Partext1">Pickup Date/Time  :</td>'
						+	'<td bgcolor="#FFFFFF" class="">'+$(tr).data('pickupdate')+'</td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td align="right" bgcolor="#FFFFFF" class="Partext1">Status :</td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1">'+$(tr).data('status')+'</td>'
						+	'</tr>'
						+	'<tr>'
						+	'<td align="right" valign="top" bgcolor="#FFFFFF" class="Partext1">Comments :</td>'
						+	'<td bgcolor="#FFFFFF" class="Partext1">'+$(tr).data('comments')+'</td>'
						+	'</tr>'
						+	'</tbody></table>'
						+	'</div>'
						+	'<div class="newStatusUpdate pt50 pt20">'
						+	'<table class="table">'
						+	'<thead>'
						+	'<tr>'
						+	'<th>Date</th>'
						+	'<th>Time</th>'	
						+	'<th>Location</th>'
						+	'<th>Status</th>'
						+	'<th>Comments</th>'
						+	'</tr>'
						+	'</thead>'
						+	'<tbody> '+cStatus+'';
						+	'</tbody>'
						+	'</table>'
						+	'</div>'
						+	'</div></div>';
		$(newHtml).insertAfter('.resultInner');
		$('.reportView').toggle( "fold" );
		$(this).removeClass('visiable');
		$(this).addClass('hideDiv');
		$(this).html('<div alt="f530" class="dashicons dashicons-hidden"></div>');
	});//report view
	


	/*
	* Hide View Report 
	*/
	$(document.body).on('click', 'a.viewReport.hideDiv', function(){
		$('.reportView').slideUp('slow', function(){
			$('.reportView').remove();
		});
		$(this).removeClass('hideDiv');
		$(this).addClass('visiable');
		$(this).html('<div alt="f504" class="dashicons dashicons-external"></div>');

	});

}); // Document Ready Function End







// Date Function 
(function() {
    Date.prototype.toYMD = Date_toYMD;
    function Date_toYMD() {
        var year, month, day;
        year = String(this.getFullYear());
        month = String(this.getMonth() + 1);
        if (month.length == 1) {
            month = "0" + month;
        }
        day = String(this.getDate());
        if (day.length == 1) {
            day = "0" + day;
        }
        return day + "/" + month + "/" + year;
    }
})();

 //Current Time
 function currentTime(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}