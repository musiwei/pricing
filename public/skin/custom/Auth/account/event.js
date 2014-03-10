jQuery(document).ready(function() {
	
	$('#datatable').dataTable( {
//		"bProcessing": true,
//		"bServerSide": true,
//		"sAjaxSource": "/fetchevent",
	  "bSort": true,
	  "bPaginate": false,
	  "bLengthChange": false,
	  "bFilter": false,
	  "bInfo": false,
	  "bAutoWidth": false,
	  "aoColumnDefs": [{ 'bSortable': false, 'aTargets': [ -1 ] }],
	
	  "aaData": [
	 			/* Reduced data set */
	 			[ "<span class='label label-primary'>PHP</span>", "Internet Explorer 4.0", "Win 95+", 4, "X" ],
	 			[ "Trident", "Internet Explorer 5.0", "Win 95+", 5, "C" ],
	 			[ "Trident", "Internet Explorer 5.5", "Win 95+", 5.5, "A" ],
	 			[ "Trident", "Internet Explorer 6.0", "Win 98+", 6, "A" ],
	 			[ "Trident", "Internet Explorer 7.0", "Win XP SP2+", 7, "A" ],
	 			[ "Gecko", "Firefox 1.5", "Win 98+ / OSX.2+", 1.8, "A" ],
	 			[ "Gecko", "Firefox 2", "Win 98+ / OSX.2+", 1.8, "A" ],
	 			[ "Gecko", "Firefox 3", "Win 2k+ / OSX.3+", 1.9, "A" ],
	 			[ "Webkit", "Safari 1.2", "OSX.3", 125.5, "A" ],
	 			[ "Webkit", "Safari 1.3", "OSX.3", 312.8, "A" ],
	 			[ "Webkit", "Safari 2.0", "OSX.4+", 419.3, "A" ],
	 			[ "Webkit", "Safari 3.0", "OSX.4+", 522.1, "A" ]
	 		]
	});

});

