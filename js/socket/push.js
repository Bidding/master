window.onload = function() {
 
     window.socket = io.connect('http://www.auctionsvip.com:3700');
    var sendButton = document.getElementById("view-bid-button");
    socket.on('message', function (data) {
        if(data.message) {
        	jQuery("#price-box-" + data.PI).html(data.price);
    		jQuery("#price-box-" + data.PI).addClass('highlight').delay(500).queue(
    		  function(next){
    			jQuery("#price-box-" + data.PI).removeClass('highlight');
    			next();
    			}
    		 );
    		
    		jQuery(".biddername" + data.PI).html(data.bidder);
   		  	jQuery(".biddername" + data.PI).addClass('highlight').delay(500).queue(
   		  		function(next){
   					jQuery(".biddername" + data.PI).removeClass('highlight');
   					next();
   				}
   		  	);
   		     if(jQuery("#bidder-table-" + data.PI + " tr").length >= 10){
      		  jQuery("#bidder-table-" + data.PI + " tr:last").remove();
       		  jQuery("#bidder-table-" + data.PI + " tbody tr:first").before(data.bidderTable);
            }
            else{
            jQuery("#bidder-table-" + data.PI + " tbody tr:first").before(data.bidderTable);
            }
        } else {
            console.log("There is a problem:", data);
        }
    });
 
}
