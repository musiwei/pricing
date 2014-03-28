jQuery(document).ready(function() {
	
	var oTable = $("#datatable").dataTable( {
		
		"oTableTools": {
			"sSwfPath": "http://pricing/skin/default/theme_stardom/vendor/plugins/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
		},
		"oLanguage": {
			"oPaginate": {"sPrevious": "", "sNext": ""},
	         "sProcessing": "<div class='loading'></div>"
	       },
		"bProcessing": true, // display loading spinner
		"bServerSide": true, // swtich on ajax load
		"sAjaxSource": "/en/auth/account/fetchevent?format=json", // path to send request to
		"aaSorting": [[ 1, "desc" ]],// default sort by second column
		//"aoColumnDefs": [{ "bSortable": true, "aTargets": [ -1 ] }],
		"aoColumnDefs": [
		    {
		    	'aTargets': [ 'event' ],
		    	"mRender": function ( data, type, full ) {
		    		return '<span class="xedit editable editable-click" data-pk='+ full.DT_RowId + ' data-name="event">'+data+'</div>';}
		    },
		    {
		    	'aTargets': [ 'date' ],
		    	"mRender": function ( data, type, full ) {
		    		return '<span class="xedit editable editable-click" data-pk='+ full.DT_RowId + ' data-name="date">'+data+'</div>';}
		    }
		],	
		
		/* pagination setting 1: infinate scrolling */
		"bScrollInfinite": true,
        "bScrollCollapse": true,
        "sScrollY": "550px",
        "sDom": 'T<"panel-menu dt-panelmenu"lifr><"clearfix">tp',
        	
        /* pagination setting 2: pagination */
		//"iDisplayLength": 10, // default number of record each page
		//"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]], // number of record options
		//"sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip', // layout

		
		"fnDrawCallback": function( oSettings ) {
			// Init Xeditable Plugin
			$.fn.editable.defaults.mode = "inline";
			$(".xedit").editable({
				url: '/en/auth/account/ajaxupdate',
			});
		}
		
	});
	
////make printable string for console readout, recursively
	var make_printable_object = function(ar_use)
	{
////	        internal arguments
	var in_tab = arguments[1];
	var st_return = arguments[2];
////	        default vales when applicable
	if (!in_tab) in_tab = 0;
	if (!st_return) st_return = "";
////	        add depth
	var st_tab = "";
	for (var i=0; i < in_tab; i++) st_tab = st_tab+"-~-~-";

////	        traverse given depth and build string
	for (var key in ar_use)
	{
	    ////        gather return type
	    var st_returnType = typeof ar_use[key];
	    ////        get current depth display
	    var st_returnPrime = st_tab+ "["+key+"] ->"+ar_use[key]+"< is {"+st_returnType+"}";
	    ////        remove linefeeds to avoid printout confusion
	    st_returnPrime = st_returnPrime.replace(/(\r\n|\n|\r)/gm,"");
	    ////        add line feed
	    st_return = st_return+st_returnPrime+"\n";
	    ////         stop at a depth of 15
	    if (in_tab>15) return st_return;
	    ////        if current value is an object call this function
	    if ( (typeof ar_use[key] == "object") & (ar_use[key] != "null") & (ar_use[key] != null) ) st_return = make_printable_object(ar_use[key], in_tab+1, st_return);


	}

////	        return complete output
	return st_return;

	};
	
	// reset all filters button
	$("#resetAllFilters").click(function(){
		$("thead input").val("");
		$("#datatable_filter input").val("");
		oTable.fnFilter("");
		
		var oSettings = oTable.fnSettings();
		  for(iCol = 0; iCol < oSettings.aoPreSearchCols.length; iCol++) {
		    oSettings.aoPreSearchCols[ iCol ].sSearch = "";
		  }
		  oTable.fnDraw();
	});
	
	// pressing enter in filter does the same with press search button
	$("thead input").keypress(function(e){
		
	      if(e.keyCode==13)
	    	  $("thead button.btn-info").get($("thead input").index(this)).click();
	});
	
	$("thead button.btn-default").click( function () {
		
		iCol = $("thead button.btn-default").index(this);
		
		$("thead input").get($("thead button.btn-default").index(this)).value ="";
		
		var oSettings = oTable.fnSettings();
		  oSettings.aoPreSearchCols[ iCol ].sSearch = "";
		  oTable.fnDraw();
	} );
	
	/* Filter on the column (the index) of this element */
	$("thead button.btn-info").click( function () {
		
		oTable.fnFilter( $("thead input").get($("thead button.btn-info").index(this)).value, $("thead button.btn-info").index(this) );
	} );

	// Add Placeholder text to datatables filter bar
	  $(".dataTables_filter input").attr("placeholder", "Enter Filter Terms Here....");
	  
	  // Manually Init Chosen on Datatables Filters
	  $('select[name="datatable_length"]').chosen();	
	  
	//Init jquery Date Picker
	$(".datepicker").datepicker({ format: "yyyy-mm-dd" });


});

