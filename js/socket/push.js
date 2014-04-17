window.onload = function() {
 
     window.socket = io.connect('http://10.10.90.78:3700');
    var sendButton = document.getElementById("view-bid-button");
    socket.on('message', function (data) {
        if(data.message) {
        	 jQuery("#price").html(data.price);
        	 jQuery("#price").addClass('highlight').delay(500).queue(
					  function(next){
						  jQuery("#price").removeClass('highlight');
						  next();
					}
			   );
        	 jQuery(".biddername").html(data.bidder);
        	 jQuery(".biddername").addClass('highlight').delay(500).queue(
					  function(next){
						  jQuery(".biddername").removeClass('highlight');
						  next();
					}
			   );
      		  jQuery("#bidder-table tr:last").remove();
       		  jQuery("#bidder-table tbody tr:first").before(data.bidderTable);
        } else {
            console.log("There is a problem:", data);
        }
    });
 
}