var $_path=$("#path").val();
var $_plan=$("#plan");
var $_modalplan=$(".modal-plan");
var $_params={"rectangle":{"width":8,"height":8},"square":{"width":4,"height":8},"bigsquare":{"width":10,"height":20},"biground":{"width":10,"height":20},"roundsquare":{"width":4,"height":8}};
var $_optionlate="late,noshow";//"late,noshow"||"noshow"
/////////////////LATE,NOSHOW////////////////////
///////////////var $_timeretard=1200;///////////
//////////////var $_noshow=2700;////////////////
/////////////////LATE,NOSHOW////////////////////
/////////////////NOSHOW/////////////////////////
var $_timeretard=1199;//1200
var $_noshow=1200;//2500
/////////////////NOSHOW/////////////////////////
jQuery(document).ready(function($){
	showPreloader();
	//////////////////////////
	//Stylise numeric input //
	//////////////////////////
	numerictextInit();
	$("input.number").appear();
	$(document.body).on("appear","input.number",function(e,$affected){
		if(!$(this).hasClass("k-input")){
			$(this).kendoNumericTextBox({
				format: "# pax"
			});
		}
	});
	//////////////////////
	//Stylise dropdowns //
	//////////////////////
	$("select.selectkendo").kendoDropDownList();
	$("select.selectkendo").appear();
	$(document.body).on("appear","select.selectkendo",function(e,$affected){
		$(this).kendoDropDownList();
	});
	/*$("select#book_hour").kendoDropDownList({
	 change: selectPassageFloor,
	 close : selectPassageFloor
	 });
	 $("select#book_hour").appear();
	 $(document.body).on("appear","select#passage-hour",function(e,$affected){
	 $(this).kendoDropDownList({
	 change: selectPassageFloor,
	 close : selectPassageFloor
	 });
	 });*/

	selectstateInit();
	$("select.selectstate").appear();
	$(document.body).on("appear click mouseenter","select.selectstate",function(e,$affected){
		$(this).kendoDropDownList({
			change: selectState
		});
	});
	////////////////////////
	//Stylise datepickers //
	////////////////////////
	$("input.kendodatepicker").each(function(){
		if($(this).val()==""){
			var attr = $(this).attr('data-value');
			if (typeof attr !== typeof undefined && attr !== false) {
				var dateselect=new Date(attr);
			}else{
				var dateselect=new Date();
			}
			$(this).kendoDatePicker({
				format: "dd-MM-yyyy",
				value: dateselect
			});
		}else{
			$(this).kendoDatePicker({
				format: "dd-MM-yyyy"
			});
		}
	});
	$("input.kendodatepicker").appear();
	$(document.body).on("appear","input.kendodatepicker",function(e,$affected){
		if($(this).val()==""){
			var attr = $(this).attr('data-value');
			if (typeof attr !== typeof undefined && attr !== false) {
				var dateselect=new Date(attr);
			}else{
				var dateselect=new Date();
			}
			$(this).kendoDatePicker({
				format: "dd-MM-yyyy",
				value: dateselect
			});
		}else{
			$(this).kendoDatePicker({
				format: "dd-MM-yyyy"
			});
		}
	});
	$("input#book_date").kendoDatePicker({
		format: "dd-MM-yyyy",
		change: selectPassageHour,
		close : selectPassageHour
	});
	$("input#book_date").appear();
	$(document.body).on("appear","input#book_date",function(e,$affected){
		$(this).kendoDatePicker({
			format: "dd-MM-yyyy",
			change: selectPassageHour,
			close : selectPassageHour
		});
	});
	////////////////////////
	//Stylise timepickers //
	////////////////////////
	$("input.kendotimepicker").kendoTimePicker();
	$("input.kendotimepicker").appear();
	$(document.body).on("appear","input.kendotimepicker",function(e,$affected){
		$(this).kendoTimePicker();
	});
	//////////////////////
	///Events Selectize //
	//////////////////////
	$("select#passage-pax").on("change blur",function(){
		selectPassageFloor();
	});
	$("select#passage-floor").on("change blur",function(){
		$("#select-passage-modal-plan").trigger('click');
	});
	//////////////////////////
	//Stylise radio buttons //
	//////////////////////////
	$(document).delegate('.button-radio','click',function(e) {
		e.preventDefault();
		var $this = $(this),
			$parent = $this.parents(".button-radio-container"),
			$hiddenval = $parent.find(".button-radio-hidden")
		this_val = $this.attr('data-val');

		$parent.children('.button-radio').removeClass('active');
		$this.addClass('active');
		$hiddenval.val(this_val);
	});
	////////////////////////////////////
	///Autocomplete Contact Last name //
	////////////////////////////////////
	$(".customer_lastname").kendoAutoComplete({
		minLength: 2,
		serverFiltering: true,
		dataTextField: "ContactLastName",
		template:
		'<div class="k-list-wrapper autocomplete_customer" data-id="#: data.CustomerID #" data-sexe="#: data.ContactSexe #" data-email="#: data.ContactEmail #" data-lastname="#: data.ContactLastName #" data-firstname="#: data.ContactFirstName #" data-mobilenumber="#: data.ContactTel #" data-indicatifmobilenumber="#: data.ContactIndicatifTel #" data-langue="#: data.ContactLangue #" data-datebirthday="#: data.ContactDateBirthday #" data-vip="#: data.ContactVip #">'+
		'<span class="k-state-default k-list-wrapper-content">' +
		'<p>#: data.ContactLastName # #: data.ContactFirstName #</p>' +
		'<span class="uk-text-muted uk-text-small">#: data.CompanyName #</span>' +
		'</span>' +
		'</div>',
		dataSource: {
			transport: {
				read: {
					dataType: "json",
					url: Routing.generate("customer_json")
				}
			}
		},
		height: 204
	}).data("kendoAutoComplete");
	/////////////////////////////////////
	///Autocomplete Contact First name //
	/////////////////////////////////////
	$(".customer_firstname").kendoAutoComplete({
		minLength: 2,
		serverFiltering: true,
		dataTextField: "ContactFirstName",
		template:
		'<div class="k-list-wrapper autocomplete_customer" data-id="#: data.CustomerID #" data-sexe="#: data.ContactSexe #" data-email="#: data.ContactEmail #" data-lastname="#: data.ContactLastName #" data-firstname="#: data.ContactFirstName #" data-mobilenumber="#: data.ContactTel #" data-indicatifmobilenumber="#: data.ContactIndicatifTel #" data-langue="#: data.ContactLangue #" data-datebirthday="#: data.ContactDateBirthday #" data-vip="#: data.ContactVip #">'+
		'<span class="k-state-default k-list-wrapper-content">' +
		'<p>#: data.ContactLastName # #: data.ContactFirstName #</p>' +
		'<span class="uk-text-muted uk-text-small">#: data.CompanyName #</span>' +
		'</span>' +
		'</div>',
		dataSource: {
			transport: {
				read: {
					dataType: "json",
					url: Routing.generate("customer_json")
				}
			}
		},
		height: 204
	}).data("kendoAutoComplete");
	////////////////////////////////
	///Autocomplete Contact Email //
	////////////////////////////////
	$(".customer_email").kendoAutoComplete({
		minLength: 2,
		serverFiltering: true,
		dataTextField: "ContactEmail",
		template:
		'<div class="k-list-wrapper autocomplete_customer" data-id="#: data.CustomerID #" data-sexe="#: data.ContactSexe #" data-email="#: data.ContactEmail #" data-lastname="#: data.ContactLastName #" data-firstname="#: data.ContactFirstName #" data-mobilenumber="#: data.ContactTel #" data-indicatifmobilenumber="#: data.ContactIndicatifTel #" data-langue="#: data.ContactLangue #" data-datebirthday="#: data.ContactDateBirthday #" data-vip="#: data.ContactVip #">'+
		'<span class="k-state-default k-list-wrapper-content">' +
		'<p>#: data.ContactLastName # #: data.ContactFirstName #</p>' +
		'<span class="uk-text-muted uk-text-small">#: data.CompanyName #</span>' +
		'</span>' +
		'</div>',
		dataSource: {
			transport: {
				read: {
					dataType: "json",
					url: Routing.generate("customer_json")
				}
			}
		},
		height: 204
	}).data("kendoAutoComplete");
	////////////////////////////////////////
	///Autocomplete Contact Mobile number //
	////////////////////////////////////////
	$(".customer_mobilenumber").kendoAutoComplete({
		minLength: 2,
		serverFiltering: true,
		dataTextField: "ContactTel",
		template:
		'<div class="k-list-wrapper autocomplete_customer" data-id="#: data.CustomerID #" data-sexe="#: data.ContactSexe #" data-email="#: data.ContactEmail #" data-lastname="#: data.ContactLastName #" data-firstname="#: data.ContactFirstName #" data-mobilenumber="#: data.ContactTel #" data-indicatifmobilenumber="#: data.ContactIndicatifTel #" data-langue="#: data.ContactLangue #" data-datebirthday="#: data.ContactDateBirthday #" data-vip="#: data.ContactVip #">'+
		'<span class="k-state-default k-list-wrapper-content">' +
		'<p>#: data.ContactLastName # #: data.ContactFirstName #</p>' +
		'<span class="uk-text-muted uk-text-small">#: data.CompanyName #</span>' +
		'</span>' +
		'</div>',
		dataSource: {
			transport: {
				read: {
					dataType: "json",
					url: Routing.generate("customer_json")
				}
			}
		},
		height: 204
	}).data("kendoAutoComplete");
	///////////////////
	//// Datatable ////
	///////////////////
	var $dt_individual_search = $('#dt_individual_search');
	if($dt_individual_search.length) {

		// Setup - add a text input to each footer cell
		$dt_individual_search.find('thead th').each( function() {
			var title = $dt_individual_search.find('thead th').eq( $(this).index() ).text();
			var index = $dt_individual_search.find('thead th').eq( $(this).index() ).attr("data-index");
			$(this).html('<input type="text" class="md-input ym-searchable" data-searchable="'+index+'" placeholder="' + title + '" />');
		} );

		// reinitialize md inputs
		altair_md.inputs();

		// DataTable
		var individual_search_table = $dt_individual_search.DataTable({
			//"lengthMenu": [[50, -1], [50, "All"]],
			"iDisplayLength": -1
		});

		// Apply the search
		individual_search_table.columns().every(function() {
			var that = this;
			$('input', this.header()).on('keyup change focus', function() {
				var valeur="";
				if(this.value!="") valeur='\#.*'+this.value+'.*\#';
				that
					.search( valeur, true )
					.draw();

			} );
			$('input', this.header()).on('click',function(e){
				e.preventDefault();
				return false;
			});
		});

	}
	//////////
	///Plan //
	//////////
	//Draggable Tables
	///dragTables();
	//Edition Mode
	$(document).delegate("#mode-edit","change",function(){
		$this=$(this);
		if($this.prop("checked")){
			$_plan.addClass('mode-edit');
			dragTables($_plan);
			resizePlan($_plan);
		}else{
			$_plan.removeClass('mode-edit');
			destroyDragTables();
			resizePlan($_plan);
			dragBookTabl();
		}

	});
	//Show Modal Add Table
	$(document).delegate("#btn-add-table","click",function(e){
		e.preventDefault();
		showAddTable();
		return false;
	});
	//Show Modal Add GroupTable
	$(document).delegate("#btn-add-groupetable","click",function(e){
		e.preventDefault();
		showAddGroupTable();
		return false;
	});
	//Add reservation
	$(document).delegate('.add-resa', 'click', function(event) {
		$("#customer_id").val("");
		emptyModalInputs();
		if($("#customer_none").prop("checked")==true){
			$("#customer_none").click();
		}
		setTimeout(function(){
			$("#customer_none").prop("checked",false);
		}, 100);
		$("#customer_none").prop("checked",false);
		$("#customer_lastname").attr("data-parsley-trigger","blur change").attr("required");
		$("#form-customer")[0].reset();
		$("#form-book")[0].reset();
		$("#form-book #book_date").kendoDatePicker({format: "dd-MM-yyyy",value:new Date()});
		$("#modal_overflow").removeClass("passage");
		$("#book_typebook").val("resa");
		$("#modal_overflow .input-selected-tables").val($(this).parents(".table").find(".title").text());
		UIkit.modal("#modal_overflow").show();
	});
	//Add passage
	$(document).delegate('.add-passage', 'click', function(event) {
		$("#customer_id").val("");
		emptyModalInputs();
		if($("#customer_none").prop("checked")==false){
			$("#customer_none").click();
		}
		setTimeout(function(){
			$("#customer_none").prop("checked",true);
		}, 100);
		$("#customer_lastname").removeAttr("data-parsley-trigger").removeAttr("required");
		$("#form-customer")[0].reset();
		$("#form-book")[0].reset();
		$("#form-book #book_date").kendoDatePicker({format: "dd-MM-yyyy",value:new Date()});
		$("#modal_overflow").addClass("passage");
		$("#book_typebook").val("passage");
		$("#modal_overflow .input-selected-tables").val($(this).parents(".table").find(".title").text());
		UIkit.modal("#modal_overflow").show();
	});
	//Edit reservation
	/*$(document).delegate(".table.with-status",'dblclick',function(){
		if($(this).find(".edit-resa").length>0){
			$(this).find(".edit-resa").trigger('click');
		}
	});*/
	var touchtime = 0;
	$(document).delegate(".table.with-status","click",function(){
		if(touchtime == 0) {
	        //set first click
	        touchtime = new Date().getTime();
	    } else {
	        //compare first click to this click and see if they occurred within double click threshold
	        if(((new Date().getTime())-touchtime) < 800) {
	            //double click occurred
	            if($(this).find(".edit-resa").length>0){
					$(this).find(".edit-resa").trigger('click');
				}
	            touchtime = 0;
	        } else {
	            //not a double click so set as a new first click
	            touchtime = new Date().getTime();
	        }
	    }
	});
	/*$('.table.with-status').on('click', function() {
	    if(touchtime == 0) {
	        //set first click
	        touchtime = new Date().getTime();
	    } else {
	        //compare first click to this click and see if they occurred within double click threshold
	        if(((new Date().getTime())-touchtime) < 800) {
	            //double click occurred
	            if($(this).find(".edit-resa").length>0){
					$(this).find(".edit-resa").trigger('click');
				}
	            touchtime = 0;
	        } else {
	            //not a double click so set as a new first click
	            touchtime = new Date().getTime();
	        }
	    } 
	});*/
	$(document).delegate('.edit-resa', 'click', function(event) {
		var bookid=$(this).attr("data-id");
		$("#modal_overflow").removeClass("passage");
		$("#book_typebook").val("resa");
		$("#modal_overflow .input-selected-tables").val($(this).parents(".table").find(".title").text());
		getBookCustomer(bookid);
		return false;
	});
	//Add Tables
	$(document).delegate("#addtable","click",function(e){
		e.preventDefault();
		showPreloader();
		$editmode=$("#mode-edit");
		var template=addTable();
		$_plan.append(template);
		if($editmode.prop("checked"))
			dragTables($_plan);
		else
			$editmode.trigger('click');
		hidePreloader();
		return false;
	});
	//Add Group Tables
	$(document).delegate("#addgrouptable","click",function(e){
		e.preventDefault();
		showPreloader();
		$editmode=$("#mode-edit");
		var template=addGroupTable();
		$_plan.append(template);
		if($editmode.prop("checked"))
			dragTables($_plan);
		else
			$editmode.trigger('click');
		hidePreloader();
		return false;
	});
	//Concatenate Table
	$(document).delegate('.concatenate-table','click',function(e){
		e.preventDefault();
		showPreloader();
		var id=$(this).parents(".table").attr("data-id");
		var name=$(this).parents(".table").find(".title").text();
		showAddGroupTable();
		$("#selected-group-ids").val(id);
		$("#selected-group-tabls").val(name);
		hidePreloader();
		return false;
	});
	//Update Table
	$(document).delegate('#update-table', 'click', function(e) {
		e.preventDefault();
		showPreloader();
		$editmode=$("#mode-edit");
		var id=$(this).parents("#add-update-table").find("#table-id").val();
		updateTable(id);
		hidePreloader();
		return false;
	});
	//Delete Table
	$(document).delegate('.delete-table', 'click', function(e) {
		e.preventDefault();
		showPreloader();
		var id=$(this).parents(".table").attr("data-id");
		if($(this).parents(".table").hasClass('group-table'))
			deleteGroupTable(id);
		else
			deleteTable(id);
		hidePreloader();
		return false;
	});
	//Delete Table
	$(document).delegate('.separate-groupe', 'click', function(e) {
		e.preventDefault();
		showPreloader();
		var id=$(this).parents(".table.group-table").attr("data-id");
		deleteGroupTable(id);
		hidePreloader();
		return false;
	});
	//Rotate Table
	$(document).delegate("#mode-rotate","change",function(){
		$this=$(this);
		if($this.prop("checked")){
			$_plan.addClass('mode-edit');
			rotateTables();
			resizePlan($_plan);
		}else{
			$_plan.removeClass('mode-edit');
			destroyRotateTables();
			resizePlan($_plan);
		}

	});
	//Show Modal Plan
	$(document).delegate('.select-modal-plan[data-id]', 'click', function(e) {
		var id=$(this).attr("data-id");
		//var val=$(".selected-tables-id[data-id='"+id+"']").val();
		e.preventDefault();
		showPlanTables(id);
		resizePlan($_modalplan);
		var floorselected=$("#book_floor").val();
		var date="";
		if($("#date-books").length>0){
			var date=$("#date-books").val();
		}else if($("#book_date").length>0){
			var date=$("#book_date").val();
		}
		getStatePlan(date);
		setTimeout(function(){
			$(".trigfloortab[data-floor='"+floorselected+"']").trigger('click');
		},1000);
		resizePlan($_modalplan);
		return false;
	});
	//Select Tables from Plan
	$(document).delegate('#select-tables','click',function(e){
		e.preventDefault();
		var id=$(this).attr("data-id");
		get_selected_tables(id);
		UIkit.modal('#modal-plan-container').hide();
		return false;
	});
	//Show Modal Update Table
	$(document).delegate(".update-table","click",function(e){
		e.preventDefault();
		var $table=$(this).parents(".table");
		if($table.hasClass("group-table"))
			showUpdateGroupTable($table);
		else
			showUpdateTable($table);
		return false;
	});
	//Event Click toggle sidebar
	$(document).delegate("#sidebar_main_toggle","click",function(){
		if($("#book-sidebar").length==1){
			if($("body").hasClass('sidebar_main_active')){
				$("#book-sidebar").fadeOut();
				$("#book-content").removeClass("uk-width-medium-10-10 uk-width-medium-8-10").addClass("uk-width-medium-10-10");
			}else{
				$("#book-sidebar").fadeIn();
				$("#book-content").removeClass("uk-width-medium-10-10 uk-width-medium-8-10").addClass("uk-width-medium-8-10");
			}
		}
	});
	/*//Event Click Button Add Resa
	 $(document).delegate("#btn-add-resa","click",function(){

	 });
	 //Event Click Button Add Passage
	 $(document).delegate("#btn-add-passage","click",function(){

	 });*/
	//Resize window
	resizePlan($_plan);
	resizePlan($_modalplan);
	$(window).resize(function(){
		resizePlan($_plan);
		resizePlan($_modalplan);
	});
	/////////////////////
	///Add Reservation //
	/////////////////////
	/*$(document).delegate('#btn-add-resa,#passage-resa,.add-passage,.add-resa', 'click', function(e) {
	 setTimeout(function(){
	 $("#book_date").next('span[role="button"]').trigger("click");
	 },500);
	 });*/

	/////////////////////////
	///Stylise page single //
	/////////////////////////
	if($("#i-am-a-single-page").length=="1"){
		$("body").addClass('header_double_height');
		altair_md.card_single();
		altair_md.list_outside();
	}

	////////////////////////////////////////
	///Search with a column in datatables //
	////////////////////////////////////////
	$(document).delegate(".ym-filter","click",function(e){
		e.preventDefault();
		var $target=$(this).attr("data-target");
		var $todo=$(this).attr("data-function");
		if($target!=undefined){
			$(".ym-searchable").val("");
			$('.ym-searchable[data-searchable="'+$target+'"]').val($todo);
			$('.ym-searchable[data-searchable="'+$target+'"]').select();
			$('.ym-searchable[data-searchable="'+$target+'"]').blur();
		}else{
			$(".ym-searchable").val("");
			$(".ym-searchable").select();
			$(".ym-searchable").blur();
		}
		return false;
	});

	////////////////////////////
	///Autocomplete Companies //
	////////////////////////////
	if($("#company_json").length>0){
		$("#company_json").kendoDropDownList({
			filter: "contains",
			suggest: true,
			dataTextField: "CompanyName",
			dataValueField: "CompanyID",
			dataSource: {
				serverFiltering: true,
				transport: {
					read: {
						dataType: "json",
						url: Routing.generate("company_json")
					}
				}
			}
		}).data("kendoAutoComplete");
	}
	if($("#company_json2").length>0){
		$("#company_json2").kendoDropDownList({
			filter: "contains",
			suggest: true,
			dataTextField: "CompanyName",
			dataValueField: "CompanyID",
			dataSource: {
				serverFiltering: true,
				transport: {
					read: {
						dataType: "json",
						url: Routing.generate("company_json")
					}
				}
			}
		}).data("kendoAutoComplete");
	}
	///////////////////////////
	/// Autocomplete Country //
	///////////////////////////
	if($("#country_json").length>0){
		$("#country_json").kendoDropDownList({
			filter: "contains",
			suggest: true,
			dataTextField: "CountryName",
			dataValueField: "CountryIndicatif",
			dataSource: {
				serverFiltering: true,
				transport: {
					read: {
						dataType: "json",
						url: Routing.generate("indicatif_json")
					}
				}
			}
		}).data("kendoAutoComplete");
	}
	///////////////
	///Pays json //
	///////////////
	if($(".pays_json").length>0){
		$(".pays_json").kendoDropDownList({
			dataTextField: "PaysNom",
			dataValueField: "PaysNom",
			dataSource: {
				transport: {
					read: {
						dataType: "json",
						url: Routing.generate("pays_json")
					}
				}
			},
			index: 0
		});
	}
	//////////////////
	///Floor Select //
	//////////////////
	if($("#floor_select").length>0){
		$(document).delegate("#floor_select","change",function(){
			var id=$(this).val();
			var date=$("#date_select").val();
			var service=$("#service_select").val();
			location.href= Routing.generate("floor_date_id_service",{id:id,date:date,service:service});
		});
	}
	////////////////////
	///Service Select //
	////////////////////
	if($("#service_select").length>0){
		$(document).delegate("#service_select","change",function(){
			var id=$("#floor_select").val();
			var date=$("#date_select").val();
			var service=$(this).val();
			location.href= Routing.generate("floor_date_id_service",{id:id,date:date,service:service});
		});
	}
	///////////////////////
	///Datepicker Select //
	///////////////////////
	if($("#date_select").length>0){
		$(document).delegate("#date_select","change",function(){
			var id=$("#floor_select").val();
			var date=$(this).val();
			var service=$("#service_select").val();
			location.href= Routing.generate("floor_date_id_service",{id:id,date:date,service:service});
		});
	}
	/////////////////////
	///Add xhr service //
	/////////////////////
	$(document).delegate("#service_add","click",function(e){
		e.preventDefault();
		showPreloader();
		var name=$("#service_name").val();
		var openhour=$("#service_openhour").val();
		var closehour=$("#service_closehour").val();
		var interval=$("#service_interval").val();
		$.ajax({
			type:"post",
			url: Routing.generate("service_add_xhr"),
			data: "name="+name+"&openhour="+openhour+"&closehour="+closehour+"&interval="+interval,
			success:function(data){
				hidePreloader();
				if(data.reponse=="ok"){
					location.reload();
				}else if(data.reponse=="exist"){
					alert("Le service existe déjà, merci d'utiliser un autre nom");
				}
			}
		});
		return false;
	});
	////////////////////////
	///Delete xhr service //
	////////////////////////
	$(document).delegate(".service_delete","click",function(e){
		e.preventDefault();
		$this=$(this);
		UIkit.modal.confirm("Voulez-vous bien supprimer ce service? ( SI vous le supprimer vous risquer de perdre tous les réservations pendant ce service )", function(){
			showPreloader();
			var id=$this.attr("data-id");
			$.ajax({
				type: "DELETE",
				url: Routing.generate("service_delete_xhr",{id:id}),
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						$(".service[data-id="+id+"]").fadeOut(500,function(){
							$(".service[data-id="+id+"]").remove();
						});
					}else if(data.reponse=="notexist"){
						alert("Le service n'a pas été trouvé dans la base de donnée.");
					}
				}
			});
		});
		return false;
	});
	///////////////////
	///Add xhr floor //
	///////////////////
	$(document).delegate("#floor_add","click",function(e){
		e.preventDefault();
		showPreloader();
		var name=$("#floor_name").val();
		var nbrcoverts=$("#floor_nbrcoverts").val();
		var servers=$("#floor_servers").val();
		$.ajax({
			type:"post",
			url: Routing.generate("floor_add_xhr"),
			data: "name="+name+"&nbr_covert="+nbrcoverts+"&nbr_server="+servers,
			success:function(data){
				hidePreloader();
				if(data.reponse=="ok"){
					location.reload();
				}else if(data.reponse=="exist"){
					alert("Le service existe déjà, merci d'utiliser un autre nom");
				}
			}
		});
		return false;
	});
	//////////////////////
	///Delete xhr floor //
	//////////////////////
	$(document).delegate(".floor_delete","click",function(e){
		e.preventDefault();
		$this=$(this);
		UIkit.modal.confirm("Voulez-vous bien supprimer cette étage? ( SI vous le supprimer vous risquer de perdre tous les réservations venons de cette étage )", function(){
			showPreloader();
			var id=$this.attr("data-id");
			$.ajax({
				type: "DELETE",
				url: Routing.generate("floor_delete_xhr",{id:id}),
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						$(".floor[data-id="+id+"]").fadeOut(500,function(){
							$(".floor[data-id="+id+"]").remove();
						});
					}else if(data.reponse=="notexist"){
						alert("L'étage n'a pas été trouvé dans la base de donnée.");
					}
				}
			});
		});
		return false;
	});
	////////////////////////
	///Delete xhr company //
	////////////////////////
	$(document).delegate(".company_delete","click",function(e){
		e.preventDefault();
		$this=$(this);
		UIkit.modal.confirm("Voulez-vous bien supprimer cette entreprise? ( SI vous la supprimer vous risquer de perdre tous les réservations et les clients de cette entrprise )", function(){
			showPreloader();
			var id=$this.attr("data-id");
			$.ajax({
				type: "DELETE",
				url: Routing.generate("company_delete",{id:id}),
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						$(".company[data-id="+id+"]").fadeOut(500,function(){
							$(".company[data-id="+id+"]").remove();
						});
					}else if(data.reponse=="notexist"){
						alert("L'entreprise n'a pas été trouvé dans la base de donnée.");
					}
				}
			});
		});
		return false;
	});
	//////////////////////////
	///Delete xhr concierge //
	//////////////////////////
	$(document).delegate(".concierge_delete","click",function(e){
		e.preventDefault();
		$this=$(this);
		UIkit.modal.confirm("Voulez-vous bien supprimer cette personne?", function(){
			showPreloader();
			var id=$this.attr("data-id");
			$.ajax({
				type: "DELETE",
				url: Routing.generate("concierge_delete",{id:id}),
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						$(".concierge[data-id="+id+"]").fadeOut(500,function(){
							$(".concierge[data-id="+id+"]").remove();
						});
					}else if(data.reponse=="notexist"){
						alert("Cette personne n'a pas été trouvé dans la base de donnée.");
					}
				}
			});
		});
		return false;
	});
	///////////////////////
	///ADD xhr concierge //
	///////////////////////
	$("#concierge_new").on("submit",function(){
		showPreloader();
		var concierge_new=$("#concierge_new").serialize();
		var id=parseInt($("#concierge-id").val());
		if(id>0){
			$.ajax({
				type: "POST",
				url: Routing.generate("concierge_save",{id:id}),
				data: concierge_new,
				success: function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						updateConcierge(data.post,data.id);
						UIkit.modal("#concierge_add").hide();
						resetConcierge();
					}else if(data.reponse=="notexist"){
						alert("Cette personne n'existe pas dans notre base de donnée.");
					}
				}
			});
		}else{
			$.ajax({
				type: "POST",
				url: Routing.generate("concierge_new"),
				data: concierge_new,
				success: function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						addConcierge(data.post,data.id);
						UIkit.modal("#concierge_add").hide();
						resetConcierge();
					}else if(data.reponse=="notexist"){
						alert("Cette entreprise n'existe pas dans notre base de donnée.");
					}
				}
			});
		}
		return false;
	});
	////////////////////////
	///EDIT xhr concierge //
	////////////////////////
	$(document).delegate(".concierge_edit","click",function(e){
		e.preventDefault();
		showPreloader();
		var $parent=$(this).parents(".concierge");
		var $infos=$parent.find(".concierge_info");

		var id=parseInt($parent.attr("data-id"));
		var first_name=$infos.attr("data-firstName");
		var job=$infos.attr("data-job");
		var last_name=$infos.attr("data-lastName");
		var mobile_number=$infos.attr("data-mobileNumber");
		var email=$infos.attr("data-email");
		var fixe_number=$infos.attr("data-fixeNumber");
		var sexe=$infos.attr("data-sexe");

		$("#concierge-sexe").selectize()[0].selectize.setValue(sexe);
		$("#concierge-firstName").val(first_name);
		$("#concierge-lastName").val(last_name);
		$("#concierge-mobileNumber").val(mobile_number);
		$("#concierge-email").val(email);
		$("#concierge-job").val(job);
		$("#concierge-fixeNumber").val(fixe_number);
		$("#concierge-sexe").val(sexe);
		$("#concierge-id").val(id);
		UIkit.modal("#concierge_add").show();
		hidePreloader();
		return false;
	});
	/////////////////////////
	///Delete xhr customer //
	/////////////////////////
	$(document).delegate(".customer_delete","click",function(e){
		e.preventDefault();
		$this=$(this);
		UIkit.modal.confirm("Voulez-vous bien supprimer ce client?", function(){
			showPreloader();
			var id=$this.attr("data-id");
			$.ajax({
				type: "DELETE",
				url: Routing.generate("customer_delete",{id:id}),
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						$(".customer[data-id="+id+"]").fadeOut(500,function(){
							$(".customer[data-id="+id+"]").remove();
						});
					}else if(data.reponse=="notexist"){
						alert("Ce client n'a pas été trouvé dans la base de donnée.");
					}
				}
			});
		});
		return false;
	});
	//////////////////////
	///Add xhr typetabl //
	//////////////////////
	$(document).delegate("#typetabl_add","click",function(e){
		e.preventDefault();
		showPreloader();
		var name=$("#typetabl_name").val();
		var classe=$("#typetabl_class").val();
		var min_covert=$("#typetabl_mincoverts").val();
		var max_covert=$("#typetabl_maxcoverts").val();
		$.ajax({
			type:"post",
			url: Routing.generate("typetabl_add_xhr"),
			data: "name="+name+"&class="+classe+"&min_covert="+min_covert+"&min_covert="+max_covert,
			success:function(data){
				hidePreloader();
				if(data.reponse=="ok"){
					location.reload();
				}else if(data.reponse=="exist"){
					alert("Le type de table existe déjà, merci d'utiliser un autre nom");
				}
			}
		});
		return false;
	});
	/////////////////////////
	///Delete xhr typetabl //
	/////////////////////////
	$(document).delegate(".typetabl_delete","click",function(e){
		e.preventDefault();
		$this=$(this);
		UIkit.modal.confirm("Voulez-vous bien supprimer ce type de table? ( SI vous le supprimer vous risquer de perdre tous les tables qui ont ce type et celà supprime aussi les réservations de ces tables )", function(){
			showPreloader();
			var id=$this.attr("data-id");
			$.ajax({
				type: "DELETE",
				url: Routing.generate("typetabl_delete_xhr",{id:id}),
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						$(".typetabl[data-id="+id+"]").fadeOut(500,function(){
							$(".typetabl[data-id="+id+"]").remove();
						});
					}else if(data.reponse=="notexist"){
						alert("Le type de table n'a pas été trouvé dans la base de donnée.");
					}
				}
			});
		});
		return false;
	});
	//////////////////////
	///Add xhr occasion //
	//////////////////////
	$(document).delegate("#occasion_add","click",function(e){
		e.preventDefault();
		showPreloader();
		var name=$("#occasion_name").val();
		var icon=$("#occasion_icon").val();
		var color=$("#occasion_color").val();
		$.ajax({
			type:"post",
			url: Routing.generate("occasion_add_xhr"),
			data: "name="+name+"&icon="+icon+"&color="+color,
			success:function(data){
				hidePreloader();
				if(data.reponse=="ok"){
					location.reload();
				}else if(data.reponse=="exist"){
					alert("cette occasion existe déjà, merci d'utiliser un autre nom");
				}
			}
		});
		return false;
	});
	/////////////////////////
	///Delete xhr occasion //
	/////////////////////////
	$(document).delegate(".occasion_delete","click",function(e){
		e.preventDefault();
		$this=$(this);
		UIkit.modal.confirm("Voulez-vous bien supprimer cette occasion?", function(){
			showPreloader();
			var id=$this.attr("data-id");
			$.ajax({
				type: "DELETE",
				url: Routing.generate("occasion_delete_xhr",{id:id}),
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						$(".occasion[data-id="+id+"]").fadeOut(500,function(){
							$(".occasion[data-id="+id+"]").remove();
						});
					}else if(data.reponse=="notexist"){
						alert("cette occasion n'a pas été trouvé dans la base de donnée.");
					}
				}
			});
		});
		return false;
	});
	///////////////////
	///Add xhr offer //
	///////////////////
	$(document).delegate("#offer_add","click",function(e){
		e.preventDefault();
		showPreloader();
		var name=$("#offer_name").val();
		var icon=$("#offer_icon").val();
		$.ajax({
			type:"post",
			url: Routing.generate("offer_add_xhr"),
			data: "name="+name+"&icon="+icon,
			success:function(data){
				hidePreloader();
				if(data.reponse=="ok"){
					location.reload();
				}else if(data.reponse=="exist"){
					alert("cette offre existe déjà, merci d'utiliser un autre nom");
				}
			}
		});
		return false;
	});
	//////////////////////
	///Delete xhr offer //
	//////////////////////
	$(document).delegate(".offer_delete","click",function(e){
		e.preventDefault();
		$this=$(this);
		UIkit.modal.confirm("Voulez-vous bien supprimer cette offer?", function(){
			showPreloader();
			var id=$this.attr("data-id");
			$.ajax({
				type: "DELETE",
				url: Routing.generate("offer_delete_xhr",{id:id}),
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						$(".offer[data-id="+id+"]").fadeOut(500,function(){
							$(".offer[data-id="+id+"]").remove();
						});
					}else if(data.reponse=="notexist"){
						alert("cette offre n'a pas été trouvé dans la base de donnée.");
					}
				}
			});
		});
		return false;
	});
	////////////////////
	///Add xhr state ///
	////////////////////
	$(document).delegate("#state_add","click",function(e){
		e.preventDefault();
		showPreloader();
		var name=$("#state_name").val();
		var color=$("#state_color").val();
		var flashed=$("#state_flashed").val();
		var fonction=$("#state_function").val();
		$.ajax({
			type:"post",
			url: Routing.generate("state_add_xhr"),
			data: "name="+name+"&color="+color+"&flashed="+flashed+"&function="+fonction,
			success:function(data){
				hidePreloader();
				if(data.reponse=="ok"){
					location.reload();
				}else if(data.reponse=="exist"){
					alert("cette state existe déjà, merci d'utiliser un autre nom");
				}
			}
		});
		return false;
	});
	//////////////////////
	///Delete xhr state //
	//////////////////////
	$(document).delegate(".state_delete","click",function(e){
		e.preventDefault();
		$this=$(this);
		UIkit.modal.confirm("Voulez-vous bien supprimer cette état?", function(){
			showPreloader();
			var id=$this.attr("data-id");
			$.ajax({
				type: "DELETE",
				url: Routing.generate("state_delete_xhr",{id:id}),
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						$(".state[data-id="+id+"]").fadeOut(500,function(){
							$(".state[data-id="+id+"]").remove();
						});
					}else if(data.reponse=="notexist"){
						alert("cette état n'a pas été trouvé dans la base de donnée.");
					}
				}
			});
		});
		return false;
	});
	//////////////////////////////
	///Get Information customer //
	//////////////////////////////
	$(document).delegate(".autocomplete_customer","click",function(){
		var id=$(this).attr("data-id");
		var sexe=$(this).attr("data-sexe");
		var lastname=$(this).attr("data-lastname");
		var firstname=$(this).attr("data-firstname");
		var mobilenumber=$(this).attr("data-mobilenumber");
		var indicatifmobilenumber=$(this).attr("data-indicatifmobilenumber");
		var langue=$(this).attr("data-langue");
		var datebirthday=$(this).attr("data-datebirthday");
		var vip=$(this).attr("data-vip");
		var email=$(this).attr("data-email");
		$("#customer_id").val(id);
		$("#customer_sexe").val(sexe);
		$(".btn-sexe").removeClass("active");
		$(".btn-sexe[data-val='"+sexe+"']").addClass("active");
		//$("#customer_sexe").selectize()[0].selectize.setValue(sexe);
		$("#customer_firstname").val(firstname);
		$("#customer_lastname").val(lastname);
		$("#customer_mobilenumber").val(mobilenumber);
		$("#customer_email").val(email);
		setTimeout(function(){
			$("#country_json").data('kendoDropDownList').value(indicatifmobilenumber);
		}, 100);
		$("#customer_langue").selectize()[0].selectize.setValue(langue);
		$("#customer_datebirthday").val(datebirthday);
		if($("#customer_vip").prop("checked")==false && vip=="1"){
			$("#customer_vip").click();
		}else if($("#customer_vip").prop("checked")==true && vip!="1"){
			$("#customer_vip").click();
		}

	});

	/////////////////////
	///Add Book Normal //
	/////////////////////
	if($('#form-book').length>0){
		var $formBook = $('#form-book').parsley().on('form:validated',function() {
				altair_md.update_input($('#form-book').find('.md-input-danger'));
			})
			.on('field:validated',function(parsleyField) {
				if($(parsleyField.$element).hasClass('md-input')) {
					altair_md.update_input( $(parsleyField.$element) );
				}
			});
	}
	if($('#form-customer').length>0){
		var $formCustomer = $('#form-customer').parsley().on('form:validated',function() {
				altair_md.update_input($('#form-customer').find('.md-input-danger'));
			})
			.on('field:validated',function(parsleyField) {
				if($(parsleyField.$element).hasClass('md-input')) {
					altair_md.update_input( $(parsleyField.$element) );
				}
			});
	}
	$(document).delegate("#book-saveattente",'click',function(){
		//Duplicate #book-normal
		showPreloader();
		$formBook.validate();
		$formCustomer.validate();
		if($formBook.isValid() && $formCustomer.isValid()){
			var formbook = $("#form-book").serialize();
			//var formpassage=$("#form-book-passage").serialize();
			var customer = $("#form-customer").serialize();
			$.ajax({
				type: "post",
				url: Routing.generate("book_add_xhr"),
				data: formbook + "&" + customer,
				success: function (data) {
					hidePreloader();
					if (data.reponse == "ok") {
						showNotify(data.message, data.status);
						var id = data.bookid;
						var civility = data.customersexe;
						var lastname = data.customerlastname;
						var firstname = data.customerfirstname;
						var tables = $(".input-selected-tables[data-id='2']").val();
						var nom_prenom = firstname + " " + lastname;
						var hour = data.booktime;
						var pax = data.bookpax;
						if(data.addOrupdate == "add" && $("#date-books").length>0 && data.dateBook == $("#date-books").val() && $("#dt_individual_search").length>0){
							addReservationTable(data);
						}else if(data.addOrupdate == "update" && $("#date-books").length>0 && data.dateBook == $("#date-books").val() && $("#dt_individual_search").length>0){
							$("#dt_individual_search").DataTable().row($("#dt_individual_search tr[data-id='"+data.bookid+"']")).remove().draw();
							addReservationTable(data);
						}
						if ($(".book-line[data-id='" + data.bookid + "']").length <= 0) {
							var chaine = '<li class="book-line md-bg-' + data.statecolor + ' ' + data.stateslugify + ' attr" data-class="md-bg-' + data.statecolor + '" data-state="' + data.stateslugify + '" data-timestamp="' + data.timestamp + '" data-id="' + data.bookid + '">' +
								'<div class="md-list-content">' +
								'<div class="uk-grid" data-uk-grid-margin="">' +
								'<div class="uk-width-medium-2-2">' +
								'<a href="#" class="book-edit edit-resa" data-id="' + data.bookid + '"><i class="material-icons md-color-purple-900">edit</i></a>' +
								'<strong data-uk-tooltip="{pos:\'bottom\'}" title="';
							chaine += civility + ' ' + nom_prenom + '<span class="book-civility">';
							chaine += civility + ' ' + '</span> <span class="book-name">' + nom_prenom + '</span></strong><br>' +
								'<span class="book-tables"><i class="fa fa-circle"></i>' + data.tablesId + '</span>';
							if(data.companyname != ""){
								chaine += ' <span class="uk-hidden">'+data.companyname+'</span>';
							}
							if (data.occasionname != "") {
								chaine += ' <span class="book-birthday" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.occasionname + '"><i class="' + data.occasionicon + ' ' + data.occasioncolor + '"></i></span>';
							}
							if (data.offername != "") {
								chaine += ' <span class="book-offer" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.offername + '"><i class="' + data.offericon + '"></i></span>';
							}
							if (data.customervip == "1") {
								chaine += ' <span class="book-vip" data-uk-tooltip="{pos:\'bottom\'}" title="VIP"><i class="uk-icon-user-secret uk-icon-small md-color-yellow-700"></i></span>';
							}
							chaine += '<br><span data-uk-tooltip="{pos:\'bottom\'}" title="' + pax + ' personnes"><i class="material-icons md-color-purple-900">person</i> <span class="book-pax">' + data.bookpax + '</span></span>';
							if (data.stateid == "7") {
								chaine += '<span data-uk-tooltip="{pos:\'bottom\'}" class="icon-no-show" title="0 No Show"><i class="material-icons md-color-red-A700">visibility_off</i></span>';
							}
							chaine += '<span data-uk-tooltip="{pos:\'bottom\'}" title="' + hour + '" class="uk-float-right"><span class="just-in-pending">';
							if (data.stateid == "6") {
								chaine +='<i class="uk-icon-refresh uk-icon-spin md-color-deep-orange-900"></i><span class="book-beginingwaiting md-color-deep-orange-900" data-time="'+data.BeginingWaitingTime+'"></span>';
							}
							chaine += '</span><i class="material-icons md-color-deep-orange-900">schedule</i> <span class="book-hour">' + hour + '</span><span class="book-stateid uk-hidden">' + data.stateid + '</span><span class="book-orderstate uk-hidden">' + data.orderstate + '</span></span>' +
								'</div>' +
								'</div>' +
								'</div>' +
								'</li>';
							$(".ym-book-list").append(chaine);
							if (data.dateBook != $("#date_select").val() || data.stateslugify == "cancelled") {
								$(".book-line[data-id='" + id + "']").remove();
							}
						} else {
							//Update Book
							$(".booking-container[data-id='" + id + "']").parents(".table").find(".uk-progress").addClass("uk-hidden");
							$(".book-line[data-id='" + id + "']").removeClass("blink");
							$(".book-line[data-id='" + id + "'] .book-civility").empty().text(civility);
							$(".book-line[data-id='" + id + "'] .book-name").empty().text(nom_prenom);
							$(".book-line[data-id='" + id + "'] .book-tables").empty().html('<i class="fa fa-circle"></i>' + data.tablesId);
							$(".book-line[data-id='" + id + "'] .book-pax").empty().text(pax);
							$(".book-line[data-id='" + id + "'] .book-hour").empty().text(hour);
							$(".book-line[data-id='" + id + "'] .book-stateid").empty().text(data.stateid);
							$(".book-line[data-id='" + id + "'] .book-orderstate").empty().text(data.orderstate);
							var oldclass = $(".book-line[data-id='" + id + "']").attr("data-class");
							var oldstate = $(".book-line[data-id='" + id + "']").attr("data-state");
							$(".book-line[data-id='" + id + "']").removeClass(oldclass + " " + oldstate);
							$(".book-line[data-id='" + id + "']").addClass("md-bg-" + data.statecolor + " " + data.stateslugify);
							$(".book-line[data-id='" + id + "']").attr("data-class", "md-bg-" + data.statecolor).attr("data-state", data.stateslugify);
							if (data.dateBook != $("#date_select").val() || data.stateslugify == "cancelled") {
								$(".book-line[data-id='" + id + "']").remove();
							}
						}
						//Update Table
						for (tableid in data.tablesarray) {
							if(data.stateslugify=="free"){
								var classes = $(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class");
								$(".table[data-id='" + data.tablesarray[tableid] + "']").removeClass(classes);
								$(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class", "");

								$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-grid").find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
								$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
								$(".table[data-id='" + data.tablesarray[tableid] + "'] .booking-container").remove();
							}else{
								var classes = $(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class");
								$(".table[data-id='" + data.tablesarray[tableid] + "']").removeClass(classes).addClass("md-bg-" + data.statecolor + " with-status");
								$(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class", "md-bg-" + data.statecolor);
								if ($(".table[data-id='" + data.tablesarray[tableid] + "'] .booking-container").length <= 0) {
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-dropdown").addClass("uk-dropdown-width-2");
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-width-2-2").removeClass("uk-width-2-2").addClass("uk-width-1-2").append('<span class="table-booked hidden" data-id="' + id + '"></span>');
									var vip="",occasion="",offer="";
									if (data.customervip == "1") {
										vip = ' <i class="uk-icon-user-secret uk-icon-small md-color-yellow-700" data-uk-tooltip="{pos:\'bottom\'}" title="Vip"></i> ';
									}
									if (data.occasionname != "") {
										occasion = ' <i class="' + data.occasionicon + ' ' + data.occasioncolor + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.occasionname + '"></i> ';
									}
									if (data.offername != "") {
										offer = ' <i class="' + data.offericon + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.offername + '"></i> ';
									}
									$('<span class="uk-badge uk-badge-notification nbr-covert">'+pax+'</span>').insertAfter(".table[data-id='" + data.tablesarray[tableid] + "'] .title");
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-grid").append('<div class="uk-width-1-2 booking-container" data-id="' + id + '">' +
										'<span class="name"><span class="table-civility">' + civility + '</span> <span class="tale-name">' + nom_prenom + '</span></span><br>' +
										'<span class="pax"><strong class="table-pax">' + pax + '</strong> Personne(s)</span><br>' +
										vip +
										occasion +
										offer +
										' <span class="table-bookhour">'+ hour +'</span> '+
										'<ul class="uk-nav uk-nav-dropdown uk-panel">' +
										'<li><a href="#" class="liberatetable" data-id="' + id + '"><i class="uk-icon-minus-circle"></i> Libérer</a></li>'+
										'<li><a href="#" class="book-edit edit-resa" data-id="' + id + '"><i class="material-icons">create</i> Modifier</a></li>' +
										'</ul>' +
										'</div>');
								} else {
									var vip="",occasion="",offer="";
									if (data.customervip == "1") {
										vip = ' <i class="uk-icon-user-secret uk-icon-small md-color-yellow-700" data-uk-tooltip="{pos:\'bottom\'}" title="Vip"></i> ';
									}
									if (data.occasionname != "") {
										occasion = ' <i class="' + data.occasionicon + ' ' + data.occasioncolor + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.occasionname + '"></i> ';
									}
									if (data.offername != "") {
										offer = ' <i class="' + data.offericon + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.offername + '"></i> ';
									}
									$('<span class="uk-badge uk-badge-notification nbr-covert">'+pax+'</span>').insertAfter(".table[data-id='" + data.tablesarray[tableid] + "'] .title");
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .booking-container").empty().html('<span class="name"><span class="table-civility">' + civility + '</span> <span class="tale-name">' + nom_prenom + '</span></span><br>' +
										'<span class="pax"><strong class="table-pax">' + pax + '</strong> Personne(s)</span><br>' +
										vip +
										occasion +
										offer +
										' <span class="table-bookhour">'+ hour +'</span> '+
										'<ul class="uk-nav uk-nav-dropdown uk-panel">' +
										'<li><a href="#" class="liberatetable" data-id="' + id + '"><i class="uk-icon-minus-circle"></i> Libérer</a></a></li>' +
										'<li><a href="#" class="book-edit edit-resa" data-id="' + id + '"><i class="material-icons">create</i> Modifier</a></li>' +
										'</ul>');
									if ($(".table[data-id='" + data.tablesarray[tableid] + "'] .table-booked").length > 0) {
										$(".table[data-id='" + data.tablesarray[tableid] + "'] .table-booked").attr("data-id", id);
									} else {
										$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-nav-dropdown").parents(".uk-width-1-2").append('<span class="table-booked hidden" data-id="' + id + '"></span>');
									}
								}
							}
						}
						$(".booking-container[data-id='" + id + "']").each(function () {
							var tablid = parseInt($(this).parents(".table").attr("data-id"));
							if ($(".booktablid[data-book-tablid='" + tablid + "']").length == 0) {
								var classes = $(this).parents(".table").attr("data-class");
								$(this).parents(".table").removeClass(classes+" with-status");
								$(this).parents(".table").attr("data-class","");
								$(this).parents(".table").find(".nbr-covert").remove();
								$(this).parents(".table").find(".table-booked").remove();
								$(this).parent(".uk-grid").find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
								$(this).parents(".uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
								$(this).remove();
							}
						});
						addWaitPending(data.bookid,data.BeginingWaitingTime);

						$("#form-book")[0].reset();
						$("#form-customer")[0].reset();
						UIkit.modal("#modal_overflow").hide();
					}
					showPreloader();
					if($(".ym-book[data-id='"+id+"']").length>0){
						$(".ym-book[data-id='"+id+"'] select.selectstate").data('kendoDropDownList').value(6);
						$(".ym-book[data-id='"+id+"'] select.selectstate").data('kendoDropDownList').trigger("change");
					}
					/*
					var stateHtml='<select class="uk-form-width-medium selectstate">';
					var allstates=$("#allstates").html();
					allstates=allstates.replace('value="'+book.stateid+'"','value="'+book.stateid+'" selected');
					stateHtml+=allstates;
					stateHtml+='</select>';
					'<span class="book-orderstate uk-hidden">'+book.orderstate+'</span><span class="uk-hidden ym-searchable-val">#'+book.statename+'#</span>'+stateHtml
					 */
					bookchangestate(data.bookid,6);

					dragBook();
					droppableTable();
					dragBookTabl();
					sortBooks();

						
				}
			});
			//console.log(formbook);
			//console.log(formpassage);
			//console.log(customer);
		}
		//Duplicate #book-normal
	});
	$(document).delegate("#book-saveandemail",'click',function(){
		//Duplicate #book-normal
		showPreloader();
		$formBook.validate();
		$formCustomer.validate();
		if($formBook.isValid() && $formCustomer.isValid()){
			var formbook = $("#form-book").serialize();
			//var formpassage=$("#form-book-passage").serialize();
			var customer = $("#form-customer").serialize();
			$.ajax({
				type: "post",
				url: Routing.generate("book_add_xhr"),
				data: formbook + "&" + customer,
				success: function (data) {
					hidePreloader();
					if (data.reponse == "ok") {
						showNotify(data.message, data.status);
						var id = data.bookid;
						var civility = data.customersexe;
						var lastname = data.customerlastname;
						var firstname = data.customerfirstname;
						var tables = $(".input-selected-tables[data-id='2']").val();
						var nom_prenom = firstname + " " + lastname;
						var hour = data.booktime;
						var pax = data.bookpax;
						if(data.addOrupdate == "add" && $("#date-books").length>0 && data.dateBook == $("#date-books").val() && $("#dt_individual_search").length>0){
							addReservationTable(data);
						}else if(data.addOrupdate == "update" && $("#date-books").length>0 && data.dateBook == $("#date-books").val() && $("#dt_individual_search").length>0){
							$("#dt_individual_search").DataTable().row($("#dt_individual_search tr[data-id='"+data.bookid+"']")).remove().draw();
							addReservationTable(data);
						}
						if ($(".book-line[data-id='" + data.bookid + "']").length <= 0) {
							var chaine = '<li class="book-line md-bg-' + data.statecolor + ' ' + data.stateslugify + ' attr" data-class="md-bg-' + data.statecolor + '" data-state="' + data.stateslugify + '" data-timestamp="' + data.timestamp + '" data-id="' + data.bookid + '">' +
								'<div class="md-list-content">' +
								'<div class="uk-grid" data-uk-grid-margin="">' +
								'<div class="uk-width-medium-2-2">' +
								'<a href="#" class="book-edit edit-resa" data-id="' + data.bookid + '"><i class="material-icons md-color-purple-900">edit</i></a>' +
								'<strong data-uk-tooltip="{pos:\'bottom\'}" title="';
							chaine += civility + ' ' + nom_prenom + '<span class="book-civility">';
							chaine += civility + ' ' + '</span> <span class="book-name">' + nom_prenom + '</span></strong><br>' +
								'<span class="book-tables"><i class="fa fa-circle"></i>' + data.tablesId + '</span>';
							if(data.companyname != ""){
								chaine += ' <span class="uk-hidden">'+data.companyname+'</span>';
							}
							if (data.occasionname != "") {
								chaine += ' <span class="book-birthday" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.occasionname + '"><i class="' + data.occasionicon + ' ' + data.occasioncolor + '"></i></span>';
							}
							if (data.offername != "") {
								chaine += ' <span class="book-offer" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.offername + '"><i class="' + data.offericon + '"></i></span>';
							}
							if (data.customervip == "1") {
								chaine += ' <span class="book-vip" data-uk-tooltip="{pos:\'bottom\'}" title="VIP"><i class="uk-icon-user-secret uk-icon-small md-color-yellow-700"></i></span>';
							}
							chaine += '<br><span data-uk-tooltip="{pos:\'bottom\'}" title="' + pax + ' personnes"><i class="material-icons md-color-purple-900">person</i> <span class="book-pax">' + data.bookpax + '</span></span>';
							if (data.stateid == "7") {
								chaine += '<span data-uk-tooltip="{pos:\'bottom\'}" class="icon-no-show" title="0 No Show"><i class="material-icons md-color-red-A700">visibility_off</i></span>';
							}
							chaine += '<span data-uk-tooltip="{pos:\'bottom\'}" title="' + hour + '" class="uk-float-right"><span class="just-in-pending">';
							if (data.stateid == "6") {
								chaine +='<i class="uk-icon-refresh uk-icon-spin md-color-deep-orange-900"></i><span class="book-beginingwaiting md-color-deep-orange-900" data-time="'+data.BeginingWaitingTime+'"></span>';
							}
							chaine += '</span><i class="material-icons md-color-deep-orange-900">schedule</i> <span class="book-hour">' + hour + '</span><span class="book-stateid uk-hidden">' + data.stateid + '</span><span class="book-orderstate uk-hidden">' + data.orderstate + '</span></span>' +
								'</div>' +
								'</div>' +
								'</div>' +
								'</li>';
							$(".ym-book-list").append(chaine);
							if (data.dateBook != $("#date_select").val() || data.stateslugify == "cancelled") {
								$(".book-line[data-id='" + id + "']").remove();
							}
						} else {
							//Update Book
							$(".booking-container[data-id='" + id + "']").parents(".table").find(".uk-progress").addClass("uk-hidden");
							$(".book-line[data-id='" + id + "']").removeClass("blink");
							$(".book-line[data-id='" + id + "'] .book-civility").empty().text(civility);
							$(".book-line[data-id='" + id + "'] .book-name").empty().text(nom_prenom);
							$(".book-line[data-id='" + id + "'] .book-tables").empty().html('<i class="fa fa-circle"></i>' + data.tablesId);
							$(".book-line[data-id='" + id + "'] .book-pax").empty().text(pax);
							$(".book-line[data-id='" + id + "'] .book-hour").empty().text(hour);
							$(".book-line[data-id='" + id + "'] .book-stateid").empty().text(data.stateid);
							$(".book-line[data-id='" + id + "'] .book-orderstate").empty().text(data.orderstate);
							var oldclass = $(".book-line[data-id='" + id + "']").attr("data-class");
							var oldstate = $(".book-line[data-id='" + id + "']").attr("data-state");
							$(".book-line[data-id='" + id + "']").removeClass(oldclass + " " + oldstate);
							$(".book-line[data-id='" + id + "']").addClass("md-bg-" + data.statecolor + " " + data.stateslugify);
							$(".book-line[data-id='" + id + "']").attr("data-class", "md-bg-" + data.statecolor).attr("data-state", data.stateslugify);
							if (data.dateBook != $("#date_select").val() || data.stateslugify == "cancelled") {
								$(".book-line[data-id='" + id + "']").remove();
							}
						}
						//Update Table
						for (tableid in data.tablesarray) {
							if(data.stateslugify=="free"){
								var classes = $(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class");
								$(".table[data-id='" + data.tablesarray[tableid] + "']").removeClass(classes);
								$(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class", "");

								$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-grid").find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
								$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
								$(".table[data-id='" + data.tablesarray[tableid] + "'] .booking-container").remove();
							}else{
								var classes = $(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class");
								$(".table[data-id='" + data.tablesarray[tableid] + "']").removeClass(classes).addClass("md-bg-" + data.statecolor + " with-status");
								$(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class", "md-bg-" + data.statecolor);
								if ($(".table[data-id='" + data.tablesarray[tableid] + "'] .booking-container").length <= 0) {
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-dropdown").addClass("uk-dropdown-width-2");
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-width-2-2").removeClass("uk-width-2-2").addClass("uk-width-1-2").append('<span class="table-booked hidden" data-id="' + id + '"></span>');
									var vip="",occasion="",offer="";
									if (data.customervip == "1") {
										vip = ' <i class="uk-icon-user-secret uk-icon-small md-color-yellow-700" data-uk-tooltip="{pos:\'bottom\'}" title="Vip"></i> ';
									}
									if (data.occasionname != "") {
										occasion = ' <i class="' + data.occasionicon + ' ' + data.occasioncolor + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.occasionname + '"></i> ';
									}
									if (data.offername != "") {
										offer = ' <i class="' + data.offericon + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.offername + '"></i> ';
									}
									$('<span class="uk-badge uk-badge-notification nbr-covert">'+pax+'</span>').insertAfter(".table[data-id='" + data.tablesarray[tableid] + "'] .title");
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-grid").append('<div class="uk-width-1-2 booking-container" data-id="' + id + '">' +
										'<span class="name"><span class="table-civility">' + civility + '</span> <span class="tale-name">' + nom_prenom + '</span></span><br>' +
										'<span class="pax"><strong class="table-pax">' + pax + '</strong> Personne(s)</span><br>' +
										vip +
										occasion +
										offer +
										' <span class="table-bookhour">'+ hour +'</span> '+
										'<ul class="uk-nav uk-nav-dropdown uk-panel">' +
										'<li><a href="#" class="liberatetable" data-id="' + id + '"><i class="uk-icon-minus-circle"></i> Libérer</a></li>'+
										'<li><a href="#" class="book-edit edit-resa" data-id="' + id + '"><i class="material-icons">create</i> Modifier</a></li>' +
										'</ul>' +
										'</div>');
								} else {
									var vip="",occasion="",offer="";
									if (data.customervip == "1") {
										vip = ' <i class="uk-icon-user-secret uk-icon-small md-color-yellow-700" data-uk-tooltip="{pos:\'bottom\'}" title="Vip"></i> ';
									}
									if (data.occasionname != "") {
										occasion = ' <i class="' + data.occasionicon + ' ' + data.occasioncolor + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.occasionname + '"></i> ';
									}
									if (data.offername != "") {
										offer = ' <i class="' + data.offericon + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.offername + '"></i> ';
									}
									$('<span class="uk-badge uk-badge-notification nbr-covert">'+pax+'</span>').insertAfter(".table[data-id='" + data.tablesarray[tableid] + "'] .title");
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .booking-container").empty().html('<span class="name"><span class="table-civility">' + civility + '</span> <span class="tale-name">' + nom_prenom + '</span></span><br>' +
										'<span class="pax"><strong class="table-pax">' + pax + '</strong> Personne(s)</span><br>' +
										vip +
										occasion +
										offer +
										' <span class="table-bookhour">'+ hour +'</span> '+
										'<ul class="uk-nav uk-nav-dropdown uk-panel">' +
										'<li><a href="#" class="liberatetable" data-id="' + id + '"><i class="uk-icon-minus-circle"></i> Libérer</a></a></li>' +
										'<li><a href="#" class="book-edit edit-resa" data-id="' + id + '"><i class="material-icons">create</i> Modifier</a></li>' +
										'</ul>');
									if ($(".table[data-id='" + data.tablesarray[tableid] + "'] .table-booked").length > 0) {
										$(".table[data-id='" + data.tablesarray[tableid] + "'] .table-booked").attr("data-id", id);
									} else {
										$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-nav-dropdown").parents(".uk-width-1-2").append('<span class="table-booked hidden" data-id="' + id + '"></span>');
									}
								}
							}
						}
						$(".booking-container[data-id='" + id + "']").each(function () {
							var tablid = parseInt($(this).parents(".table").attr("data-id"));
							if ($(".booktablid[data-book-tablid='" + tablid + "']").length == 0) {
								var classes = $(this).parents(".table").attr("data-class");
								$(this).parents(".table").removeClass(classes+" with-status");
								$(this).parents(".table").attr("data-class","");
								$(this).parents(".table").find(".nbr-covert").remove();
								$(this).parents(".table").find(".table-booked").remove();
								$(this).parent(".uk-grid").find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
								$(this).parents(".uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
								$(this).remove();
							}
						});
						addWaitPending(data.bookid,data.BeginingWaitingTime);

						$("#form-book")[0].reset();
						$("#form-customer")[0].reset();
						UIkit.modal("#modal_overflow").hide();
					}
					showPreloader();
					$.ajax({
						type: "POST",
						url: Routing.generate("book_confirm_email",{id:id}),
						success:function(data){
							hidePreloader();
							if(data.reponse=="sent"){
								showNotify(data.message,"success");
							}else if(data.reponse=="notexist"){
								alert("La réservation n'a pas été trouvé dans la base de donnée.");
							}
						}
					});

					dragBook();
					droppableTable();
					dragBookTabl();
					sortBooks();

						
				}
			});
			//console.log(formbook);
			//console.log(formpassage);
			//console.log(customer);
		}
		//Duplicate #book-normal
	});
	$(document).delegate("#book-normal","click",function() {
		showPreloader();
		$formBook.validate();
		$formCustomer.validate();
		if($formBook.isValid() && $formCustomer.isValid()){
			var formbook = $("#form-book").serialize();
			//var formpassage=$("#form-book-passage").serialize();
			var customer = $("#form-customer").serialize();
			$.ajax({
				type: "post",
				url: Routing.generate("book_add_xhr"),
				data: formbook + "&" + customer,
				success: function (data) {
					hidePreloader();
					if (data.reponse == "ok") {
						showNotify(data.message, data.status);
						var id = data.bookid;
						var civility = data.customersexe;
						var lastname = data.customerlastname;
						var firstname = data.customerfirstname;
						var tables = $(".input-selected-tables[data-id='2']").val();
						var nom_prenom = firstname + " " + lastname;
						var hour = data.booktime;
						var pax = data.bookpax;
						if(data.addOrupdate == "add" && $("#date-books").length>0 && data.dateBook == $("#date-books").val() && $("#dt_individual_search").length>0){
							addReservationTable(data);
						}else if(data.addOrupdate == "update" && $("#date-books").length>0 && data.dateBook == $("#date-books").val() && $("#dt_individual_search").length>0){
							$("#dt_individual_search").DataTable().row($("#dt_individual_search tr[data-id='"+data.bookid+"']")).remove().draw();
							addReservationTable(data);
						}
						if ($(".book-line[data-id='" + data.bookid + "']").length <= 0) {
							var chaine = '<li class="book-line md-bg-' + data.statecolor + ' ' + data.stateslugify + ' attr" data-class="md-bg-' + data.statecolor + '" data-state="' + data.stateslugify + '" data-timestamp="' + data.timestamp + '" data-id="' + data.bookid + '">' +
								'<div class="md-list-content">' +
								'<div class="uk-grid" data-uk-grid-margin="">' +
								'<div class="uk-width-medium-2-2">' +
								'<a href="#" class="book-edit edit-resa" data-id="' + data.bookid + '"><i class="material-icons md-color-purple-900">edit</i></a>' +
								'<strong data-uk-tooltip="{pos:\'bottom\'}" title="';
							chaine += civility + ' ' + nom_prenom + '<span class="book-civility">';
							chaine += civility + ' ' + '</span> <span class="book-name">' + nom_prenom + '</span></strong><br>' +
								'<span class="book-tables"><i class="fa fa-circle"></i>' + data.tablesId + '</span>';
							if(data.companyname != ""){
								chaine += ' <span class="uk-hidden">'+data.companyname+'</span>';
							}
							if (data.occasionname != "") {
								chaine += ' <span class="book-birthday" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.occasionname + '"><i class="' + data.occasionicon + ' ' + data.occasioncolor + '"></i></span>';
							}
							if (data.offername != "") {
								chaine += ' <span class="book-offer" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.offername + '"><i class="' + data.offericon + '"></i></span>';
							}
							if (data.customervip == "1") {
								chaine += ' <span class="book-vip" data-uk-tooltip="{pos:\'bottom\'}" title="VIP"><i class="uk-icon-user-secret uk-icon-small md-color-yellow-700"></i></span>';
							}
							chaine += '<br><span data-uk-tooltip="{pos:\'bottom\'}" title="' + pax + ' personnes"><i class="material-icons md-color-purple-900">person</i> <span class="book-pax">' + data.bookpax + '</span></span>';
							if (data.stateid == "7") {
								chaine += '<span data-uk-tooltip="{pos:\'bottom\'}" class="icon-no-show" title="0 No Show"><i class="material-icons md-color-red-A700">visibility_off</i></span>';
							}
							chaine += '<span data-uk-tooltip="{pos:\'bottom\'}" title="' + hour + '" class="uk-float-right"><span class="just-in-pending">';
							if (data.stateid == "6") {
								chaine +='<i class="uk-icon-refresh uk-icon-spin md-color-deep-orange-900"></i><span class="book-beginingwaiting md-color-deep-orange-900" data-time="'+data.BeginingWaitingTime+'"></span>';
							}
							chaine += '</span><i class="material-icons md-color-deep-orange-900">schedule</i> <span class="book-hour">' + hour + '</span><span class="book-stateid uk-hidden">' + data.stateid + '</span><span class="book-orderstate uk-hidden">' + data.orderstate + '</span></span>' +
								'</div>' +
								'</div>' +
								'</div>' +
								'</li>';
							$(".ym-book-list").append(chaine);
							if (data.dateBook != $("#date_select").val() || data.stateslugify == "cancelled") {
								$(".book-line[data-id='" + id + "']").remove();
							}
						} else {
							//Update Book
							$(".booking-container[data-id='" + id + "']").parents(".table").find(".uk-progress").addClass("uk-hidden");
							$(".book-line[data-id='" + id + "']").removeClass("blink");
							$(".book-line[data-id='" + id + "'] .book-civility").empty().text(civility);
							$(".book-line[data-id='" + id + "'] .book-name").empty().text(nom_prenom);
							$(".book-line[data-id='" + id + "'] .book-tables").empty().html('<i class="fa fa-circle"></i>' + data.tablesId);
							$(".book-line[data-id='" + id + "'] .book-pax").empty().text(pax);
							$(".book-line[data-id='" + id + "'] .book-hour").empty().text(hour);
							$(".book-line[data-id='" + id + "'] .book-stateid").empty().text(data.stateid);
							$(".book-line[data-id='" + id + "'] .book-orderstate").empty().text(data.orderstate);
							var oldclass = $(".book-line[data-id='" + id + "']").attr("data-class");
							var oldstate = $(".book-line[data-id='" + id + "']").attr("data-state");
							$(".book-line[data-id='" + id + "']").removeClass(oldclass + " " + oldstate);
							$(".book-line[data-id='" + id + "']").addClass("md-bg-" + data.statecolor + " " + data.stateslugify);
							$(".book-line[data-id='" + id + "']").attr("data-class", "md-bg-" + data.statecolor).attr("data-state", data.stateslugify);
							if (data.dateBook != $("#date_select").val() || data.stateslugify == "cancelled") {
								$(".book-line[data-id='" + id + "']").remove();
							}
						}
						//Update Table
						for (tableid in data.tablesarray) {
							if(data.stateslugify=="free"){
								var classes = $(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class");
								$(".table[data-id='" + data.tablesarray[tableid] + "']").removeClass(classes);
								$(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class", "");

								$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-grid").find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
								$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
								$(".table[data-id='" + data.tablesarray[tableid] + "'] .booking-container").remove();
							}else{
								var classes = $(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class");
								$(".table[data-id='" + data.tablesarray[tableid] + "']").removeClass(classes).addClass("md-bg-" + data.statecolor + " with-status");
								$(".table[data-id='" + data.tablesarray[tableid] + "']").attr("data-class", "md-bg-" + data.statecolor);
								if ($(".table[data-id='" + data.tablesarray[tableid] + "'] .booking-container").length <= 0) {
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-dropdown").addClass("uk-dropdown-width-2");
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-width-2-2").removeClass("uk-width-2-2").addClass("uk-width-1-2").append('<span class="table-booked hidden" data-id="' + id + '"></span>');
									var vip="",occasion="",offer="";
									if (data.customervip == "1") {
										vip = ' <i class="uk-icon-user-secret uk-icon-small md-color-yellow-700" data-uk-tooltip="{pos:\'bottom\'}" title="Vip"></i> ';
									}
									if (data.occasionname != "") {
										occasion = ' <i class="' + data.occasionicon + ' ' + data.occasioncolor + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.occasionname + '"></i> ';
									}
									if (data.offername != "") {
										offer = ' <i class="' + data.offericon + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.offername + '"></i> ';
									}
									$('<span class="uk-badge uk-badge-notification nbr-covert">'+pax+'</span>').insertAfter(".table[data-id='" + data.tablesarray[tableid] + "'] .title");
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-grid").append('<div class="uk-width-1-2 booking-container" data-id="' + id + '">' +
										'<span class="name"><span class="table-civility">' + civility + '</span> <span class="tale-name">' + nom_prenom + '</span></span><br>' +
										'<span class="pax"><strong class="table-pax">' + pax + '</strong> Personne(s)</span><br>' +
										vip +
										occasion +
										offer +
										' <span class="table-bookhour">'+ hour +'</span> '+
										'<ul class="uk-nav uk-nav-dropdown uk-panel">' +
										'<li><a href="#" class="liberatetable" data-id="' + id + '"><i class="uk-icon-minus-circle"></i> Libérer</a></li>'+
										'<li><a href="#" class="book-edit edit-resa" data-id="' + id + '"><i class="material-icons">create</i> Modifier</a></li>' +
										'</ul>' +
										'</div>');
								} else {
									var vip="",occasion="",offer="";
									if (data.customervip == "1") {
										vip = ' <i class="uk-icon-user-secret uk-icon-small md-color-yellow-700" data-uk-tooltip="{pos:\'bottom\'}" title="Vip"></i> ';
									}
									if (data.occasionname != "") {
										occasion = ' <i class="' + data.occasionicon + ' ' + data.occasioncolor + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.occasionname + '"></i> ';
									}
									if (data.offername != "") {
										offer = ' <i class="' + data.offericon + '" data-uk-tooltip="{pos:\'bottom\'}" title="' + data.offername + '"></i> ';
									}
									$('<span class="uk-badge uk-badge-notification nbr-covert">'+pax+'</span>').insertAfter(".table[data-id='" + data.tablesarray[tableid] + "'] .title");
									$(".table[data-id='" + data.tablesarray[tableid] + "'] .booking-container").empty().html('<span class="name"><span class="table-civility">' + civility + '</span> <span class="tale-name">' + nom_prenom + '</span></span><br>' +
										'<span class="pax"><strong class="table-pax">' + pax + '</strong> Personne(s)</span><br>' +
										vip +
										occasion +
										offer +
										' <span class="table-bookhour">'+ hour +'</span> '+
										'<ul class="uk-nav uk-nav-dropdown uk-panel">' +
										'<li><a href="#" class="liberatetable" data-id="' + id + '"><i class="uk-icon-minus-circle"></i> Libérer</a></a></li>' +
										'<li><a href="#" class="book-edit edit-resa" data-id="' + id + '"><i class="material-icons">create</i> Modifier</a></li>' +
										'</ul>');
									if ($(".table[data-id='" + data.tablesarray[tableid] + "'] .table-booked").length > 0) {
										$(".table[data-id='" + data.tablesarray[tableid] + "'] .table-booked").attr("data-id", id);
									} else {
										$(".table[data-id='" + data.tablesarray[tableid] + "'] .uk-nav-dropdown").parents(".uk-width-1-2").append('<span class="table-booked hidden" data-id="' + id + '"></span>');
									}
								}
							}
						}
						$(".booking-container[data-id='" + id + "']").each(function () {
							var tablid = parseInt($(this).parents(".table").attr("data-id"));
							if ($(".booktablid[data-book-tablid='" + tablid + "']").length == 0) {
								var classes = $(this).parents(".table").attr("data-class");
								$(this).parents(".table").removeClass(classes+" with-status");
								$(this).parents(".table").attr("data-class","");
								$(this).parents(".table").find(".nbr-covert").remove();
								$(this).parents(".table").find(".table-booked").remove();
								$(this).parent(".uk-grid").find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
								$(this).parents(".uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
								$(this).remove();
							}
						});
						addWaitPending(data.bookid,data.BeginingWaitingTime);

						$("#form-book")[0].reset();
						$("#form-customer")[0].reset();
						UIkit.modal("#modal_overflow").hide();
					}
					dragBook();
					droppableTable();
					dragBookTabl();
					sortBooks();

				}
			});
			//console.log(formbook);
			//console.log(formpassage);
			//console.log(customer);
		}
	});
	/////////////////////////
	///Check Customer none///
	/////////////////////////
	$(document).delegate("#customer_none","change",function(){
		if($("#customer_none").prop("checked")==false){
			$(".have-infos").show();
		}else{
			$(".have-infos").hide();
		}
	});
	///////////////////////
	///Click btn passage///
	///////////////////////
	$(document).delegate("#btn-add-passage","click",function(){
		$("#customer_id").val("");
		emptyModalInputs();
		if($("#customer_none").prop("checked")==false){
			$("#customer_none").click();
		}
		setTimeout(function(){
			$("#customer_none").prop("checked",true);
		}, 100);
		$("#customer_lastname").removeAttr("data-parsley-trigger").removeAttr("required");
		$("#book_id").val("");
		$("#form-customer")[0].reset();
		$("#form-book")[0].reset();
		$("#form-book #book_date").kendoDatePicker({format: "dd-MM-yyyy",value:new Date()});
		$("#modal_overflow").addClass("passage");
		$("#book_typebook").val("passage");
		UIkit.modal("#modal_overflow").show();
	});
	/////////////////////
	///Click btn Resa////
	/////////////////////
	$(document).delegate("#btn-add-resa","click",function(){
		$("#customer_id").val("");
		emptyModalInputs();
		if($("#customer_none").prop("checked")==true){
			$("#customer_none").click();
		}
		if($("#customer_vip").prop("checked")==true){
			$("#customer_vip").click();
		}
		setTimeout(function(){
			$("#customer_none").prop("checked",false);
		}, 100);
		$("#customer_none").prop("checked",false);
		$("#customer_lastname").attr("data-parsley-trigger","blur change").attr("required");
		$("#book_id").val("");
		$("#form-customer")[0].reset();
		emptyModalInputs();
		$("#form-book")[0].reset();
		$("#form-book #book_date").kendoDatePicker({format: "dd-MM-yyyy",value:new Date()});
		$("#modal_overflow").removeClass("passage");
		$("#book_typebook").val("resa");
		UIkit.modal("#modal_overflow").show();
	});
	/////////////////////
	/// Click btn Pax ///
	/////////////////////
	$(document).delegate(".btn-pax","click",function(){
		var valeur=parseInt($(this).attr("data-val"));
		$(".btn-pax").removeClass("active");
		$(this).addClass("active");
		$("#book_pax").val(valeur);
	});
	$(document).delegate("#book_pax","keyup click",function(){
		var valeur=parseInt($(this).val());
		$(".btn-pax").removeClass("active");
		if($(".btn-pax[data-val='"+valeur+"']").length>0){
			$(".btn-pax[data-val='"+valeur+"']").addClass("active");
		}
	});
	//////////////////////
	/// Click btn sexe ///
	//////////////////////
	$(document).delegate(".btn-sexe","click",function(){
		var valeur=$(this).attr("data-val");
		$(".btn-sexe").removeClass("active");
		$(this).addClass("active");
		$("#customer_sexe").val(valeur);
	});
	$(document).delegate("#customer_sexe","keyup click",function(){
		var valeur=$(this).val();
		$(".btn-sexe").removeClass("active");
		if($(".btn-sexe[data-val='"+valeur+"']").length>0){
			$(".btn-sexe[data-val='"+valeur+"']").addClass("active");
		}
	});
	///////////////////////
	/// Hover on a book ///
	///////////////////////
	$(document).delegate(".book-line","mouseenter",function(){
		var id=$(this).attr("data-id");
		$(".table").removeClass("hovered");
		$(".table.with-status").each(function(){
			$table=$(this);
			if($table.find(".booking-container[data-id='"+id+"']").length>0){
				$table.addClass("hovered");
			}
		});
	});
	$(document).delegate(".book-line","mouseleave",function(){
		var id=$(this).attr("data-id");
		$(".table.with-status").each(function(){
			$table=$(this);
			if($table.find(".booking-container[data-id='"+id+"']").length>0){
				$table.removeClass("hovered");
			}
		});
	});
	// Change tabs config
	$(document).delegate(".ym-tabs li","click",function(){
		var index=$(".ym-tabs li").index($(this));
		$("#indextab").val(index);
	});
	if($("#indextab").length=="1"){
		$(".ym-tabs li:eq("+$("#indextab").val()+")").find("a").trigger("click");
	}

	////////////////////////
	/// Hover on a table ///
	////////////////////////
	$(document).delegate(".table.with-status","mouseenter",function(){
		var id=$(this).attr("data-id");
		$(".book-line .booktablid[data-book-tablid='"+id+"']").each(function(){
			$(this).parents(".book-line").addClass("hovered");
		});
	});
	$(document).delegate(".table.with-status","mouseleave",function(){
		var id=$(this).attr("data-id");
		$(".book-line .booktablid[data-book-tablid='"+id+"']").each(function(){
			$(this).parents(".book-line").removeClass("hovered");
		});
	});

	////////////////////////
	/// Btn Search books ///
	////////////////////////
	$(document).delegate("#search-books","click",function(){
		var datebooks=$("#date-books").val();
		var servicebooks=$(".service-books:checked").val();
		if(servicebooks!=0){
			location.href=Routing.generate("restaurant_date_service",{date:datebooks,service:servicebooks});
		}else{
			location.href=Routing.generate("restaurant_date",{date:datebooks});
		}
	});

	///////////////////////////
	/// Filter Boutton book ///
	///////////////////////////
	$(document).delegate(".filterbook a","click",function(e){
		e.preventDefault();
		var $this=$(this);
		var $filter=$this.parents(".filterbook");
		var $li=$this.parents("li");
		$filter.find("li.uk-active").removeClass("uk-active");
		$li.addClass("uk-active");
		var filter=$this.attr("data-filter");
		if(filter!="all"){
			$(".book-line").addClass("uk-hidden");
			$(".book-line."+filter).removeClass("uk-hidden");
		}else{
			$(".book-line").removeClass("uk-hidden");
		}

		return false;
	});
	//////////////////////////
	/// Filter Search book ///
	//////////////////////////
	$('#filtersearch').focus().keyup(function(event){
		var input = $(this);
		var val  = input.val();
		// Si rien est tapé, on affiche tout
		if(val == ''){
			$('.ym-book-list .book-line').show();
			return true;
		}

		// On construit l'expression à  partir de ce qui est tapé (.*)e(.*)x(.*)e(.*)m(.*)p(.*)l(.*)e(.*)
		var regexp = '\\b(.*)';
		for(var i in val){
			regexp += '('+val[i]+')(.*)';
		}
		regexp += '\\b';
		$('.ym-book-list .book-line').show();

		// On parcourt chaque élément de la liste
		$('.ym-book-list').find('.book-line').each(function(){
			var book = $(this);
			var resultats = book.text().match(new RegExp(regexp,'i'));
			if(!resultats){
				book.hide();
			}
		})
	});
	///////////////////////////////
	/// Booking Datatable CRUD  ///
	///////////////////////////////
	if($("#page-with-datatable").length>0){
		$(document).delegate("#dt_individual_search .input-selected-tables","change",function(){
			var idvirtual=$(this).attr("data-id");
			var $this=$("#dt_individual_search .input-selected-tables[data-id='"+idvirtual+"']");
			var selectedtabls=$this.val();
			var bookid=$this.parents("tr").attr("data-id");
			if(selectedtabls!=""){
				updateTablsBook(bookid,selectedtabls);
			}
			console.log("Book "+bookid+" Selected tabls : "+selectedtabls);
		});
		$(document).delegate("#select-tables","click",function(){
			var idvirtual=$(this).attr("data-id");
			var $this=$("#dt_individual_search .input-selected-tables[data-id='"+idvirtual+"']");
			var selectedtabls=$this.val();
			var bookid=$this.parents("tr").attr("data-id");
			if(selectedtabls!="" && bookid>0){
				updateTablsBook(bookid,selectedtabls);
			}
			//console.log("Book "+bookid+" Selected tabls : "+selectedtabls);
		});
		$(document).delegate(".book_update_hour","click",function(e){
			e.preventDefault();
			var service=$(this).attr("data-service");
			var hour=$(this).attr("data-hour");
			var bookid=$(this).parents("tr").attr("data-id");
			$("#bookupdate_id").val(bookid);
			$("#bookupdate_hour option[value='"+service+'|'+hour+"']").prop("selected",true);
			UIkit.modal("#book-update-hour").show();
			return false;
		});
		$(document).delegate("#bookupdatehour","click",function(e){
			e.preventDefault();
			var servicehour=$("#bookupdate_hour").val();
			var bookid=$("#bookupdate_id").val();
			updateHourBook(bookid,servicehour);
			return false;
		});
		$(document).delegate(".input-pax","change",function(e){
			e.preventDefault();
			e.stopPropagation();
			var bookid=$(this).parents("tr").attr("data-id");
			var pax=$(this).val();
			updatePaxBook(bookid,pax);
		});
	}
	/////////////////////////////
	///Delete xhr notification //
	/////////////////////////////
	$(document).delegate(".notification_delete","click",function(e){
		e.preventDefault();
		$this=$(this);
		$parent=$this.parents(".notification");
		UIkit.modal.confirm("Voulez-vous bien supprimer cette notification?", function(){
			showPreloader();
			var id=$parent.attr("data-id");
			$.ajax({
				type: "DELETE",
				url: Routing.generate("notification_delete_xhr",{id:id}),
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						$(".notification[data-id="+id+"]").fadeOut(500,function(){
							$(".notification[data-id="+id+"]").remove();
						});
					}else if(data.reponse=="notexist"){
						alert("La notification n'a pas été trouvé dans la base de donnée.");
					}
				}
			});
		});
		return false;
	});
	//////////////////////////////
	///Confirm Booking Whatsapp //
	//////////////////////////////
	$(document).delegate("#book_confirm_whatsapp","click",function(e){
		e.preventDefault();
		var id=$(this).attr("data-id");
		showPreloader();
		$.ajax({
			type: "POST",
			url: Routing.generate("book_confirm_whatsapp",{id:id}),
			success:function(data){
				hidePreloader();
				if(data.reponse=="sent"){
					showNotify(data.message,"info");

					$(".bookchangestate").removeClass("ym-active ym-inactive").addClass("ym-inactive");
					$(".bookchangestate[data-state='"+data.state+"']").removeClass("ym-active ym-inactive").addClass("ym-active");
					var classe=$(".bookds .bookds-status").attr("data-class");
					$(".bookds .bookds-status").removeClass(classe).addClass("md-bg-"+data.class).attr("data-class","md-bg-"+data.class);
					$(".bookds .bookds-status").text(data.statename);

					addWaitPending(id,data.BeginingWaitingTime);
				}else if(data.reponse=="notexist"){
					alert("La réservation n'a pas été trouvé dans la base de donnée.");
				}else if(data.reponse=="phoneformat"){
					showNotify("Le format du téléphone n'est pas le bon.","danger");
				}
			}
		});
		return false;
	});
	//////////////////////////////
	///Pending Booking Whatsapp //
	//////////////////////////////
	$(document).delegate("#book_whatsapp_after_pending","click",function(e){
		e.preventDefault();
		var id=$(this).attr("data-id");
		showPreloader();
		$.ajax({
			type: "POST",
			url: Routing.generate("book_after_pending",{id:id}),
			success:function(data){
				hidePreloader();
				if(data.reponse=="sent"){
					showNotify(data.message,"info");

					$(".bookchangestate").removeClass("ym-active ym-inactive").addClass("ym-inactive");
					$(".bookchangestate[data-state='"+data.state+"']").removeClass("ym-active ym-inactive").addClass("ym-active");
					var classe=$(".bookds .bookds-status").attr("data-class");
					$(".bookds .bookds-status").removeClass(classe).addClass("md-bg-"+data.class).attr("data-class","md-bg-"+data.class);
					$(".bookds .bookds-status").text(data.statename);

					addWaitPending(id,data.BeginingWaitingTime);
				}else if(data.reponse=="notexist"){
					alert("La réservation n'a pas été trouvé dans la base de donnée.");
				}else if(data.reponse=="phoneformat"){
					showNotify("Le format du téléphone n'est pas le bon.","danger");
				}
			}
		});
		return false;
	});

	//////////////////////////////
	///Cancel Booking Whatsapp //
	//////////////////////////////
	$(document).delegate("#book_whatsapp_cancel","click",function(e){
		e.preventDefault();
		var id=$(this).attr("data-id");
		showPreloader();
		$.ajax({
			type: "POST",
			url: Routing.generate("book_whatsapp_cancel",{id:id}),
			success:function(data){
				hidePreloader();
				if(data.reponse=="sent"){
					showNotify(data.message,"danger");

					$(".bookchangestate").removeClass("ym-active ym-inactive").addClass("ym-inactive");
					$(".bookchangestate[data-state='"+data.state+"']").removeClass("ym-active ym-inactive").addClass("ym-active");
					var classe=$(".bookds .bookds-status").attr("data-class");
					$(".bookds .bookds-status").removeClass(classe).addClass("md-bg-"+data.class).attr("data-class","md-bg-"+data.class);
					$(".bookds .bookds-status").text(data.statename);

					addWaitPending(id,data.BeginingWaitingTime);
				}else if(data.reponse=="notexist"){
					alert("La réservation n'a pas été trouvé dans la base de donnée.");
				}else if(data.reponse=="phoneformat"){
					showNotify("Le format du téléphone n'est pas le bon.","danger");
				}
			}
		});
		return false;
	});
	///////////////////////////
	///Get messages whatsapp //
	///////////////////////////
	$(document).delegate("#mark_messages_readed","click",function(e){
		e.preventDefault();
		showPreloader();
		$.ajax({
			type: "POST",
			url: Routing.generate("book_get_messages"),
			success:function(data){
				hidePreloader();
				console.log(data);
			}
		});
		return false;
	});
	///////////////////////////
	///Confirm Booking Email //
	///////////////////////////
	$(document).delegate("#book_confirm_email","click",function(e){
		e.preventDefault();
		var id=$(this).attr("data-id");
		showPreloader();
		$.ajax({
			type: "POST",
			url: Routing.generate("book_confirm_email",{id:id}),
			success:function(data){
				hidePreloader();
				if(data.reponse=="sent"){
					showNotify(data.message,"success");

					$(".bookchangestate").removeClass("ym-active ym-inactive").addClass("ym-inactive");
					$(".bookchangestate[data-state='"+data.state+"']").removeClass("ym-active ym-inactive").addClass("ym-active");
					var classe=$(".bookds .bookds-status").attr("data-class");
					$(".bookds .bookds-status").removeClass(classe).addClass("md-bg-"+data.class).attr("data-class","md-bg-"+data.class);
					$(".bookds .bookds-status").text(data.statename);

					addWaitPending(id,data.BeginingWaitingTime);
				}else if(data.reponse=="notexist"){
					alert("La réservation n'a pas été trouvé dans la base de donnée.");
				}
			}
		});
		return false;
	});
	//////////////////////////
	///Cancel Booking Email //
	//////////////////////////
	$(document).delegate("#book_email_cancel","click",function(e){
		e.preventDefault();
		var id=$(this).attr("data-id");
		showPreloader();
		$.ajax({
			type: "POST",
			url: Routing.generate("book_cancel_email",{id:id}),
			success:function(data){
				hidePreloader();
				if(data.reponse=="ok"){
					showNotify(data.message,"danger");

					$(".bookchangestate").removeClass("ym-active ym-inactive").addClass("ym-inactive");
					$(".bookchangestate[data-state='"+data.state+"']").removeClass("ym-active ym-inactive").addClass("ym-active");
					var classe=$(".bookds .bookds-status").attr("data-class");
					$(".bookds .bookds-status").removeClass(classe).addClass("md-bg-"+data.class).attr("data-class","md-bg-"+data.class);
					$(".bookds .bookds-status").text(data.statename);

					addWaitPending(id,data.BeginingWaitingTime);
				}else if(data.reponse=="notexist"){
					alert("La réservation n'a pas été trouvé dans la base de donnée.");
				}
			}
		});
		return false;
	});
	///////////////////////////
	///Pending Booking Email //
	///////////////////////////
	$(document).delegate("#book_email_after_pending","click",function(e){
		e.preventDefault();
		var id=$(this).attr("data-id");
		showPreloader();
		$.ajax({
			type: "POST",
			url: Routing.generate("book_pending_email",{id:id}),
			success:function(data){
				hidePreloader();
				if(data.reponse=="ok"){
					showNotify(data.message,"warning");

					$(".bookchangestate").removeClass("ym-active ym-inactive").addClass("ym-inactive");
					$(".bookchangestate[data-state='"+data.state+"']").removeClass("ym-active ym-inactive").addClass("ym-active");
					var classe=$(".bookds .bookds-status").attr("data-class");
					$(".bookds .bookds-status").removeClass(classe).addClass("md-bg-"+data.class).attr("data-class","md-bg-"+data.class);
					$(".bookds .bookds-status").text(data.statename);

					addWaitPending(id,data.BeginingWaitingTime);
				}else if(data.reponse=="notexist"){
					alert("La réservation n'a pas été trouvé dans la base de donnée.");
				}
			}
		});
		return false;
	});
	/////////////////////////
	///Change state detail //
	/////////////////////////
	$(document).delegate(".bookchangestate","click",function(e){
		e.preventDefault();
		var book=$(this).attr("data-id");
		var state=$(this).attr("data-state");
		if(state=="4"){
			UIkit.modal.confirm("Voulez-vous bien libérer la table ?", function(){
				bookchangestate(book,state);
			});
		}else{
			bookchangestate(book,state);
		}
		return false;
	});
	////////////////////
	///Liberate table //
	////////////////////
	$(document).delegate(".liberatetable","click",function(e){
		e.preventDefault();
		var book=$(this).attr("data-id");
		var table=$(this).parents(".table").attr("data-id");
		UIkit.modal.confirm("Voulez-vous bien libérer la table ?", function(){
			bookliberatetable(book,table);
		});
		return false;
	});
	///////////////////////////
	/// Go to url on click ////
	///////////////////////////
	$(document).delegate(".gotourl","click",function(){
		var href=$(this).attr("href");
		location.href=href;
	});
	///////////////////////////
	///Initialize drag books //
	///////////////////////////
	dragBook();
	dragBookTabl();
	////////////////////////////////
	///Initialize droppable table //
	////////////////////////////////
	droppableTable();
	////////////////////////
	///Context Menu books //
	////////////////////////
	/*$(".book-line").contextmenu(function(e) {
		e.preventDefault();
		$(".contextmenu").remove();
		var bookid=$(this).attr("data-id");
		var chaine='<ul class="contextmenu" style="top:'+ e.clientY+'px;left:'+ e.clientX+'px;">';
		$("#allstates option").each(function(){
			chaine+='<li class="md-bg-'+$(this).attr("data-color")+'"><a href="#" class="bookchangestate" data-id="'+bookid+'" data-state="'+$(this).attr("value")+'">'+$(this).text()+'</a></li>';
		});
		chaine+='</ul>';
		$("body").append(chaine);
		return false;
	});*/
	//////////////////////
	///Click Menu books //
	//////////////////////
	$(document).delegate(".book-line","click",function(e) {
		e.preventDefault();
		$(".contextmenu").remove();
		var bookid=$(this).attr("data-id");
		var chaine='<ul class="contextmenu" style="top:'+ e.clientY+'px;left:'+ e.clientX+'px;">';
		$("#allstates option").each(function(){
			chaine+='<li class="md-bg-'+$(this).attr("data-color")+'"><a href="#" class="bookchangestate" data-id="'+bookid+'" data-state="'+$(this).attr("value")+'">'+$(this).text()+'</a></li>';
		});
		chaine+='</ul>';
		$("body").append(chaine);
		return false;
	});
	$(document).click(function (e)
	{
		var container = $(".contextmenu");

		if (!container.is(e.target) // if the target of the click isn't the container...
			&& container.has(e.target).length === 0) // ... nor a descendant of the container
		{
			container.hide();
			container.remove();
		}
	});
	////////////////////////////
	///Validate tasbles exist //
	////////////////////////////
	//if($("#plan").length>0 || $("#book_edit_form").length>0){
		$(document).delegate("#modal_overflow .input-selected-tables","change",function(){
			var idvirtual=$(this).attr("data-id");
			var $this=$("#modal_overflow .input-selected-tables[data-id='"+idvirtual+"']");
			var selectedtabls=$this.val();
			var bookid=$("#book_id").val();
			var date=$("#book_date").val();
			if(selectedtabls!=""){
				verifyTablsBook(bookid,date,selectedtabls,idvirtual);
			}
		});
		$(document).delegate("#select-tables","click",function(){
			$thisid=$(this);
			var idvirtual=$thisid.attr("data-id");
			var $this=$(".input-selected-tables[data-id='"+idvirtual+"']");/*#modal_overflow */
			var selectedtabls=$this.val();
			if($("#modal_overflow").hasClass('uk-open')){
				var bookid=$("#book_id").val();
				var date=$("#book_date").val();
			}else{
				var bookid=$this.parents("tr").attr("data-id");
				var date=$("#date-books").val();
			}
			if(selectedtabls!=""){
				verifyTablsBook(bookid,date,selectedtabls,idvirtual);
			}
		});
	//}
	//////////////////////////////////////////////
	///Show confirm for modifying blocked table //
	//////////////////////////////////////////////
	$(document).delegate("#book_blocked","click",function(){
		if($(this).prop("checked")==false){
			UIkit.modal.confirm('Êtes-vous sûr de modifier cette valeur, car il se peut que le client voudrais cette table?',function(){
				//$(this).prop("checked",false);
			});
			$(this).prop("checked",false);
		}
	});
	///////////////////////////////////////////////
	///Disable book button while updating tables //
	///////////////////////////////////////////////
	$(document).delegate(".input-selected-tables",'focus',function(){
		$("#book-normal").attr("disabled","true");
	});
	$(document).delegate(".input-selected-tables",'blur',function(){
		$("#book-normal").removeAttr("disabled");
	});

	$(document).delegate("a[data-uk-tooltip]","click",function(e){
		e.preventDefault();
		UIkit.tooltip(this,{pos:"bottom"}).show();
		return false;
	});
	$(document).delegate("#synchronise-books","click",function(e){
		showPreloader();
		e.preventDefault();
		$.ajax({
			url:Routing.generate("book_synchronisebooks"),
			success: function(data){
				if(data.reponse=="ok"){
					hidePreloader();
					$(".lastsynchronisation").empty().text(data.lastsynchronisation);
					location.reload();
				}
			}
		});
		return false;
	});

	///Clock of the site
	startTime();

	//////////////
	///Settings //
	//////////////
	//Step 1 : Logo
	/*if($(".preview-logo img").length=="1"){
	 console.log($(".preview-logo img").width());
	 console.log($(".preview-logo img").height());
	 }*/

	hidePreloader();
});
///////////////
///Functions///
///////////////

//Function : Add Reservation to table
function addReservationTable(book){
	var stateHtml='<select class="uk-form-width-medium selectstate">';
	var allstates=$("#allstates").html();
	allstates=allstates.replace('value="'+book.stateid+'"','value="'+book.stateid+'" selected');
	stateHtml+=allstates;
	stateHtml+='</select>';
	var occasion="";
	var offer="";
	var customervip="";
	var noteadmin="";
	var redeye="";
	var blocked="";
	var floorslug="";
	if(book.occasionname!=""){
		occasion='<i class="'+book.occasionicon+' uk-icon-small '+book.occasioncolor+'" data-uk-tooltip="{pos:\'bottom\'}" title="'+book.occasionname+'"></i>';
	}
	if(book.offername!=""){
		offer='<i class="'+book.offericon+' uk-icon-small" data-uk-tooltip="{pos:\'bottom\'}" title="'+book.offername+'"></i>';
	}
	if(book.customervip==1){
		customervip='<i class="md-color-yellow-700 fz18">VIP</i>';
	}
	if(book.noteadmin!="" && book.noteadmin!=null){
		noteadmin=book.noteadmin;
	}
	if(noteadmin!=""){
		redeye="md-color-red-500";
	}
	if(book.bookblocked==1){
		blocked="blocked";
	}
	if(book.floorslug!=""){
		floorslug='<span class="book-floor"><i class="md-color-red-700 fz18">'+book.floorslug+'</i></span>';
	}
	//if(book.customerFirstName)
	$("#dt_individual_search").DataTable().row.add([
		'<span class="uk-hidden ym-searchable-val">#'+book.booktime+'#</span><a href="#" class="book_update_hour" data-service="'+book.serviceid+'" data-hour="'+book.booktime+'"><strong>'+book.booktime+'</strong></a>',
		'<span class="uk-hidden ym-searchable-val">#'+book.customerfirstname+' '+book.customerlastname+'#</span><a href="#" class="edit-resa" data-id="'+book.bookid+'">'+book.customerfirstname+' '+book.customerlastname+'</a>',
		'<span class="uk-hidden ym-searchable-alltables ym-searchable-val">#'+book.alltables+'#</span><div class="book-edit-table"><input class="uk-form-width-medium k-textbox input-selected-tables '+blocked+'" type="text" data-old-val="'+book.alltables+'" data-id="'+book.bookid+'" value="'+book.alltables+'" /><a href="#" class="md-btn md-btn-small md-btn-success select-modal-plan" data-id="'+book.bookid+'"><i class="material-icons uk-text-contrast">add</i></a><input type="hidden" class="selected-tables-id " data-id="'+book.bookid+'" value=""></div>',
		'<span class="uk-hidden ym-searchable-pax ym-searchable-val">#'+book.bookpax+'#</span><input class="uk-form-width-medium number input-pax" type="number" data-old-val="'+book.bookpax+'" value="'+book.bookpax+'" min="0" max="100" step="1" />',
		'<span class="book-orderstate uk-hidden">'+book.orderstate+'</span><span class="uk-hidden ym-searchable-val">#'+book.statename+'#</span>'+stateHtml,
		'<span class="uk-hidden ym-searchable-val">#'+book.companyname+'#</span><a href="#" class="edit-resa" data-id="'+book.bookid+'">'+book.companyname+'</a>',
		'<span class="uk-hidden ym-searchable-val">#'+book.bookid+'#</span>'+occasion+' '+offer+' '+customervip+'&nbsp; <a href="#" class="edit-resa" data-id="'+book.bookid+'" data-uk-tooltip="{pos:\'bottom\'}" title="Modifier"><i class="uk-icon-pencil"></i></a>&nbsp; <a data-uk-tooltip="{pos:\'bottom\'}" title="'+noteadmin+'"><i class="uk-icon-info-circle '+redeye+'"></i></a>&nbsp; <a href="'+ Routing.generate("book_detail",{id:book.bookid}) +'" class="see-detail"><i class="uk-icon-eye"></i></a>&nbsp; '+floorslug
		/*'{% if book.occasionId %}<i class="{{ book.occasionId.icon }} uk-icon-small {{ book.occasionId.color }}" data-uk-tooltip="{pos:'bottom'}" title="{{ book.occasionId.name }}"></i> {% endif %}{% if book.customerId.vip %}<i class="uk-icon-user-secret uk-icon-small md-color-yellow-700" data-uk-tooltip="{pos:'bottom'}" title="Vip"></i> {% endif %}',
		 '<a href="#" class="edit-resa" data-id="{{ book.id }}" data-uk-tooltip="{pos:'bottom'}" title="Modifier"><i class="uk-icon-pencil"></i></a>'*/
	]);
	$("#dt_individual_search").DataTable().draw();
	numerictextInit();
	selectstateInit();
	var $tr=$("#dt_individual_search tbody tr:last");
	var $selectedstate=$tr.find(".selectstate").parents("td");
	$tr.addClass("ym-book "+book.stateslugify).attr("data-id",book.bookid).attr("data-state",book.stateslugify).attr("data-timestamp",book.timestamp);
	$selectedstate.addClass("md-bg-"+book.statecolor);
}

//Function : Make a book draggable
function dragBook(){
	if($('.book-line').length>0){
		$('.book-line').draggable();
		$('.book-line').draggable('destroy');
		$(".book-line:not(.cancelled,.free)").draggable({
			//containment: "body",
			delay: 0,
			revert:true,
			appendTo:"#plan",
			helper: "clone",
			cursorAt: { left: 25,top: 25 },
			start: function(e, ui){
				$(ui.helper).addClass("ondragresclone");
				$(this).addClass("ondragreservation");//ui.helper.context
			},
			stop: function(e, ui){
				$(this).removeClass("ondragreservation");//ui.helper.context
			}
		});
	}
}
//Function : Make a book table draggable
function dragBookTabl(){
	if($('.table').length>0){
		$('.table').draggable();
		$('.table').draggable('destroy');
		$(".table.with-status").draggable({
			//containment: "body",
			delay: 0,
			revert:true,
			appendTo:"#plan",
			helper: "clone",
			cursorAt: { left: 25,top: 25 },
			start: function(e, ui){
				$(ui.helper).addClass("ondragresclone");
				$(this).addClass("ondragreservation");//ui.helper.context
			},
			stop: function(e, ui){
				$(this).removeClass("ondragreservation");//ui.helper.context
			}
		});
	}
}
//Function : Make a table droppable
function droppableTable(){
	if($('.table').length>0) {
		$(".table").droppable();
		$('.table').droppable('destroy');
		$(".table").droppable({//:not(.with-status)
			accept: ".book-line,.table.with-status",
			hoverClass: "ondrop",
			drop: function (e, ui) {
				$this = $(this);
				showPreloader();
				$(".ondragresclone").hide();
				if ($(this).find(".booking-container").length == 1) {
					var tableid1 = $this.attr("data-id");
					var nametable1 = $this.find(".title").text();
					var tableid2 = $(ui.draggable.context).attr("data-id");
					var nametable2 = $(ui.draggable.context).find(".title").text();
					var bookid1=$this.find(".booking-container").attr("data-id");
					var bookid2=$(ui.draggable.context).find(".booking-container").attr("data-id");
					UIkit.modal.confirm('Voulez-vous switché la table '+nametable1+' avec la table '+nametable2,function(){
						switchTables(bookid1,tableid1,bookid2,tableid2);
					});
				} else {
					var tablid = $this.attr("data-id");
					var nametable = $this.find(".title").text();
					var tablesearch=$(ui.draggable.context).attr("class");
					var tabltoremoveid=0;
					if(tablesearch.search("table")>=0){
						var tabltoremoveid = parseInt($(ui.draggable.context).attr("data-id"));
						var bookid = $(ui.draggable.context).find(".booking-container").attr("data-id");
					}else{
						var bookid = $(ui.draggable.context).attr("data-id");
					}
					if(typeof bookid != "undefined"){
						$.ajax({
							type: "post",
							url: Routing.generate("book_affect_table", {tablid: tablid, id: bookid}),
							data: "tabltoremoveid="+tabltoremoveid,
							success: function (data) {
								if (data.reponse == "ok") {
									showNotify(data.message, "success");
									var $book = $(".book-line[data-id='" + bookid + "']");
									var civility = $book.find(".book-civility").text();
									var nom_prenom = $book.find(".book-name").text();
									var pax = $book.find(".book-pax").text();
									var hour = $book.find(".book-hour").text();
									var state = $book.attr("data-state");
									var classes = $book.attr("data-class");
									var timestamp = $book.attr("data-timestamp");
									var occasion=$book.find(".book-birthday").html();
									var offert=$book.find(".book-offer").html();
									var vip=$book.find(".book-vip").html();
									if(typeof occasion === "undefined"){
										occasion="";
									}
									if(typeof offert === "undefined"){
										offert="";
									}
									if(typeof vip === "undefined"){
										vip="";
									}


									if ($(".table[data-id='" + tablid + "'] .booking-container").length <= 0) {
										$(".table[data-id='" + tablid + "'] .uk-dropdown").addClass("uk-dropdown-width-2");
										$(".table[data-id='" + tablid + "'] .uk-width-2-2").removeClass("uk-width-2-2").addClass("uk-width-1-2").append('<span class="table-booked hidden" data-id="' + bookid + '"></span>');
										$(".table[data-id='" + tablid + "'] .uk-grid").append('<div class="uk-width-1-2 booking-container" data-id="' + bookid + '">' +
											'<span class="name"><span class="table-civility">' + civility + '</span> <span class="tale-name">' + nom_prenom + '</span></span><br>' +
											'<span class="pax"><strong class="table-pax">' + pax + '</strong> Personne(s)</span><br>' +
											occasion+" "+
											offert+" "+
											vip+" "+
											'<span class="table-bookhour">' + hour + '</span>' +
											'<ul class="uk-nav uk-nav-dropdown uk-panel">' +
											'<li><a href="#" class="liberatetable" data-id="' + bookid + '"><i class="uk-icon-minus-circle"></i> Libérer</a></li>'+
											'<li><a href="#" class="book-edit edit-resa" data-id="' + bookid + '"><i class="material-icons">create</i> Modifier</a></li>' +
											'</ul>' +
											'</div>');
									} else {
										$(".table[data-id='" + tablid + "'] .booking-container").empty().html('<span class="name"><span class="table-civility">' + civility + '</span> <span class="tale-name">' + nom_prenom + '</span></span><br>' +
											'<span class="pax"><strong class="table-pax">' + pax + '</strong> Personne(s)</span><br>' +
											occasion+" "+
											offert+" "+
											vip+" "+
											'<span class="table-bookhour">' + hour + '</span>' +
											'<ul class="uk-nav uk-nav-dropdown uk-panel">' +
											'<li><a href="#" class="liberatetable" data-id="' + bookid + '"><i class="uk-icon-minus-circle"></i> Libérer</a></li>'+
											'<li><a href="#" class="book-edit edit-resa" data-id="' + bookid + '"><i class="material-icons">create</i> Modifier</a></li>' +
											'</ul>');
										if ($(".table[data-id='" + tablid + "'] .table-booked").length > 0) {
											$(".table[data-id='" + tablid + "'] .table-booked").attr("data-id", bookid);
										} else {
											$(".table[data-id='" + tablid + "'] .uk-nav-dropdown").parents(".uk-width-1-2").append('<span class="table-booked hidden" data-id="' + bookid + '"></span>');
										}
									}
									$('<span class="uk-badge uk-badge-notification nbr-covert">'+pax+'</span>').insertAfter(".table[data-id='" + tablid + "'] .title");
									if ($(".book-line[data-id='" + bookid + "'] .book-tables .booktablid").length > 0) {
										$(".book-line[data-id='" + bookid + "']").find(".book-tables").append(' + <span data-book-tablid="'+tablid+'" class="booktablid">' + nametable+ '</span>');
									} else {
										$(".book-line[data-id='" + bookid + "']").find(".book-tables").append('<span data-book-tablid="'+tablid+'" class="booktablid">'+nametable+'</span>');
									}
									//$(".book-line[data-id='"+id+"']").find(".book-tables")
									$(".table[data-id='" + tablid + "']").attr("data-timestamp", timestamp).attr("data-class", classes).attr("data-state", state).addClass(classes + " " + state+" with-status");
									$(".table[data-id='" + tablid + "']").removeClass("blink");

									if(tabltoremoveid>0){
										$(".book-line[data-id='" + bookid + "'] .book-tables").empty().html('<i class="fa fa-circle"></i>' + data.tables);
										var classes = $(".table[data-id='" + tabltoremoveid + "']").attr("data-class");
										$(".table[data-id='" + tabltoremoveid + "']").removeClass(classes);
										$(".table[data-id='" + tabltoremoveid + "']").attr("data-class", "");
										$(".table[data-id='" + tabltoremoveid + "'] .uk-grid").find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
										$(".table[data-id='" + tabltoremoveid + "'] .uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
										$(".table[data-id='" + tabltoremoveid + "'] .booking-container").remove();
										$(".table[data-id='" + tabltoremoveid + "'] .table-booked").remove();
										$(".table[data-id='" + tabltoremoveid + "'] .nbr-covert").remove();
										var oldclass=$(".table[data-id='" + tabltoremoveid + "']").attr("data-class");
										var oldstate=$(".table[data-id='" + tabltoremoveid + "']").attr("data-state");
										$(".table[data-id='" + tabltoremoveid + "']").removeClass("md-bg-" + oldclass+ " " + oldstate+" with-status");
										$(".table[data-id='" + tabltoremoveid + "']").attr("data-class","").attr("data-state","");
											
									}

								} else {
									alert("Erreur");
								}
								dragBook();
								dragBookTabl();
								droppableTable();
								sortBooks();
								hidePreloader();
							}
						});
					}else{
						hidePreloader();
					}
					/********************Node*************************/
					/********************Node*************************/
				}
			}
		});
	}
}
//Function : Show Notification
function showNotify(message,status) {
	thisNotify = UIkit.notify({
		message: message,
		status: status,
		timeout: 6000,
		group: null,
		pos: 'bottom-left'
	});
	if(
		(
			($window.width() < 768)
			&& (
				(thisNotify.options.pos == 'bottom-right')
				|| (thisNotify.options.pos == 'bottom-left')
				|| (thisNotify.options.pos == 'bottom-center')
			)
		)
		|| (thisNotify.options.pos == 'bottom-right')
	) {
		var thisNotify_height = $(thisNotify.element).outerHeight();
		var spacer = $window.width() < 768 ? -6 : 8;
		$body.find('.md-fab-wrapper').css('margin-bottom',thisNotify_height + spacer);
	}
}

//Function : Get Book And customer
function getBookCustomer(bookid){
	showPreloader();
	$.ajax({
		url:Routing.generate("book_get_xhr",{id:bookid}),
		success: function(data){
			if(data.reponse=="ok"){
				$("#customer_id").val("");
				emptyModalInputs();
				$("#form-customer")[0].reset();
				$("#form-book")[0].reset();
				$("#book_date").val(data.book.date);
				$("#book_id").val(data.book.id);
				$("select#book_hour option[value='"+data.book.hour+"']").prop("selected",true);
				if($("#book_blocked").prop("checked")==false && data.book.blocked=="1"){
					$("#book_blocked").prop("checked",true);
				}else if($("#book_blocked").prop("checked")==true && data.book.blocked!="1"){
					$("#book_blocked").prop("checked",false);
				}
				$("select#book_blocked option[value='"+data.book.blocked+"']").prop("selected",true);
				//$("select#book_hour").selectize()[0].selectize.setValue(data.book.hour);
				$("#book_pax").val(data.book.pax);
				$(".btn-pax").removeClass("active");
				$(".btn-pax[data-val='"+data.book.pax+"']").addClass("active");
				$("select#book_floor option[value='"+data.book.floor+"']").prop("selected",true);
				//$("select#book_floor").selectize()[0].selectize.setValue(data.book.floor);
				$(".input-selected-tables[data-id='2']").val(data.book.tablesname);
				$(".selected-tables-id[data-id='2']").val(data.book.tablesid);
				//$("#company_json").val(data.book.company);
				//$("#company_json").data('kendoDropDownList').value(data.book.company);
				setTimeout(function(){
					$("#company_json").data('kendoDropDownList').value(data.book.company);
				}, 100);
				$("select#book_state option[value='"+data.book.state+"']").prop("selected",true);
				//$("select#book_state").selectize()[0].selectize.setValue(data.book.state);
				$("select#book_offer option[value='"+data.book.offer+"']").prop("selected",true);
				//$("select#book_offer").selectize()[0].selectize.setValue(data.book.offer);
				$("select#book_occasion option[value='"+data.book.occasion+"']").prop("selected",true);
				//$("select#book_occasion").selectize()[0].selectize.setValue(data.book.occasion);
				$("#book_noteadmin").val(data.book.note);


				if($("#customer_none").prop("checked")==true){
					$("#customer_none").click();
				}

				if($("#customer_vip").prop("checked")==false && data.customer.vip=="1"){
					$("#customer_vip").click();
				}else if($("#customer_vip").prop("checked")==true && data.customer.vip!="1"){
					$("#customer_vip").click();
				}
				$("#customer_id").val(data.customer.id);
				$("#customer_lastname").val(data.customer.lastname);
				$("#customer_firstname").val(data.customer.firstname);
				$("#customer_email").val(data.customer.email);
				$("#customer_sexe").val(data.customer.sexe);
				$(".btn-sexe").removeClass("active");
				$(".btn-sexe[data-val='"+data.customer.sexe+"']").addClass("active");
				//$("select#customer_sexe option[value='"+data.customer.sexe+"']").prop("selected",true);
				//$("select#customer_sexe").selectize()[0].selectize.setValue(data.customer.sexe);
				setTimeout(function(){
					$("#country_json").data('kendoDropDownList').value(data.customer.indicatif_mobile_number);
				}, 100);
				//$("#customer_indicatifmobilenumber").selectize()[0].selectize.setValue(data.customer.indicatif_mobile_number);
				$("#customer_mobilenumber").val(data.customer.mobile_number);
				$("select#customer_langue option[value='"+data.customer.langue+"']").prop("selected",true);
				//$("select#customer_langue").selectize()[0].selectize.setValue(data.customer.langue);
				$("#customer_datebirthday").val(data.customer.datebirthday);
				UIkit.modal("#modal_overflow").show();

				$("#company_json").data('kendoDropDownList').value(data.book.company);
			}
			hidePreloader();
		}
	})
}

//Function : Add Table
function addTable(){
	var template='';
	//unserialize serialized the form sent
	var addTables=$.unserialize($("#form-addtable").serialize());
	//recuperate variables
	var duplicate=parseInt(addTables.duplicate);
	var name=addTables.name;
	var tabl_nbr_chaire=parseInt(addTables.nbr_chaire);
	var tabl_name="",tabl_floor_id=$("#floor_select").val();
	//loop duplicated tables
	for(var i=1;i<=duplicate;i++){
		//create the html template
		var provisoire_id=randomString(8);
		template+='<div class="table uk-button-dropdown" data-id="'+provisoire_id+'" data-uk-dropdown="{mode:\'click\'}"><span class="title">';
		if(i>1){tabl_name=name+' '+i;template+=tabl_name;}else{tabl_name=name;template+=tabl_name;}
		template+='</span><span class="uk-badge uk-badge-notification nbr-covert">'+tabl_nbr_chaire+'</span>'+
			'<div class="uk-dropdown">'+
			'<div class="uk-grid uk-dropdown-grid">'+
			'<div class="uk-width-2-2">'+
			'<ul class="uk-nav uk-nav-dropdown uk-panel">'+
			'<li><a href="#"><i class="material-icons">add</i> Ajouter résa</a></li>'+
			'<li><a href="#" class="update-table"><i class="material-icons">create</i> Modifier</a></li>'+
			'<li><a href="#"><i class="material-icons">add</i> Concatener</a></li>'+
			'<li><a href="#" class="delete-table"><i class="material-icons">close</i> Supprimer</a></li>'+
			'</ul>'+
			'</div>'+
			'</div>'+
			'</div>'+
			'<div class="hidden info_table"'+
			'data-name="'+tabl_name+'"'+
			'data-nbrChaire="'+tabl_nbr_chaire+'"'+
			'data-leftp="0"'+
			'data-topp="0"'+
			'data-rotation="0"'+
			'></div>'+
			'</div>';
		$.ajax({
			type:"post",
			url: Routing.generate("tabl_add_xhr"),
			data: "name="+tabl_name+"&nbr_chaire="+tabl_nbr_chaire+"&floor_id="+tabl_floor_id+"&typetabl_id="+addTables.typetabl_id+"&provisoire_id="+provisoire_id,
			success:function(data){
				hidePreloader();
				if(data.reponse=="ok"){
					$(".table[data-id='"+data.provisoire_id+"']").attr("data-id",data.id).addClass(data.classe);
				}else if(data.reponse=="exist"){
					alert("La table existe déjà, merci d'utiliser un autre nom.");
				}
			}
		});
	}
	return template;
}

//Function : Update Table
function updateTable(id){
	var template='';
	//unserialize serialized the form sent
	var updateTable=$.unserialize($("#form-addtable").serialize());
	//recuperate variables
	var tabl_name=updateTable.name;

	var tabl_nbr_chaire=parseInt(updateTable.nbr_chaire);
	//var style=$(".table[data-id="+id+"]").attr("style");
	//.removeClass('big round rectangle square').addClass(big+round+rectangle+square)
	var tabl_floor_id=$("#floor_select").val();
	$(".table[data-id="+id+"]").find(".title").text(tabl_name);
	$(".table[data-id="+id+"] .nbr-covert").text(tabl_nbr_chaire);
	$.ajax({
		type:"post",
		url: Routing.generate("tabl_edit_xhr",{id:id}),
		data: "name="+tabl_name+"&nbr_chaire="+tabl_nbr_chaire+"&floor_id="+tabl_floor_id+"&typetabl_id="+updateTable.typetabl_id,
		success:function(data){
			if(data.reponse=="ok"){
				$(".table[data-id='"+data.id+"']").removeClass(data.removeclasse).addClass(data.classe);
				//Send socket
			}else if(data.reponse=="notexist"){
				alert("Cette table n'existe pas dans notre base de donnée.");
			}
			hidePreloader();
		}
	});
	return template;
}

//Function : Delete Table
function deleteTable(id){
	$.ajax({
		type:"DELETE",
		url: Routing.generate("tabl_delete_xhr",{id:id}),
		success:function(data){
			hidePreloader();
			if(data.reponse=="ok"){
				//do smtg with the socket
				$(".table:not(.group-table)[data-id="+id+"]").fadeOut(500,function(){
					$(".table:not(.group-table)[data-id="+id+"]").remove();
				});
			}else if(data.reponse=="notexist"){
				UIkit.modal.alert('Une erreur à été survenu.');
			}
		}
	});
}
//Function : Update Hour booking
function updateHourBook(bookid,servicehour){
	showPreloader();
	$.ajax({
		type:"POST",
		url: Routing.generate("book_update_hour_xhr",{id:bookid}),
		data:"servicehour="+servicehour,
		success:function(data){
			hidePreloader();
			if(data.reponse=="ok"){
				$("#dt_individual_search tr[data-id='"+bookid+"'] .book_update_hour strong").text(data.hour);
				$("#dt_individual_search tr[data-id='"+bookid+"'] .book_update_hour").attr("data-hour",data.hour);
				$("#dt_individual_search tr[data-id='"+bookid+"'] .ym-searchable-hour").text("#"+data.hour+"#");
				$("#dt_individual_search tr[data-id='"+bookid+"'] .book_update_hour").attr("data-service",data.service);
				UIkit.modal("#book-update-hour").hide();
			}else if(data.reponse=="notexist"){
				UIkit.modal.alert('Une erreur a été survenu.');
			}
		}
	});
}

//Function : Update Tabls booking
function updateTablsBook(bookid,selectedtabls){
	showPreloader();
	var selectedtabls=selectedtabls.replace(/\+/g,"%2B");
	$.ajax({
		type:"POST",
		url: Routing.generate("book_update_tables_xhr",{id:bookid}),
		data:"selectedtabls="+selectedtabls,
		success:function(data){
			hidePreloader();
			if(data.reponse=="ok"){
				$("#dt_individual_search tr[data-id='"+bookid+"'] .ym-searchable-alltables").text("#"+data.tables+"#");
				$("#dt_individual_search tr[data-id='"+bookid+"'] .input-selected-tables").val(data.tables);
				$("#dt_individual_search tr[data-id='"+bookid+"'] .input-selected-tables").attr("data-old-val",data.tables);
			}else if(data.reponse=="okbutsomeexist"){
				$("#dt_individual_search tr[data-id='"+bookid+"'] .ym-searchable-alltables").text("#"+data.tables+"#");
				$("#dt_individual_search tr[data-id='"+bookid+"'] .input-selected-tables").val(data.tables);
				$("#dt_individual_search tr[data-id='"+bookid+"'] .input-selected-tables").attr("data-old-val",data.tables);
				UIkit.modal.alert('La(es) table(s) '+data.existtables+' existe(s) déjà veuillez choisir d\'autres tables.');
			}else if(data.reponse=="notexist"){
				var oldval=$("#dt_individual_search tr[data-id='"+bookid+"'] .input-selected-tables").attr("data-old-val");
				$("#dt_individual_search tr[data-id='"+bookid+"'] .input-selected-tables").val(oldval);
				UIkit.modal.alert('Une erreur a été survenu.');
			}
		}
	});
}
//Function : Verify Tables booking
function verifyTablsBook(bookid,date,selectedtabls,idvirtual){
	showPreloader();
	console.log(selectedtabls);
	var selectedtabls=selectedtabls.replace(/\+/g,"%2B");
	$.ajax({
		type:"POST",
		url: Routing.generate("book_verify_tables_xhr"),
		data:"selectedtabls="+selectedtabls+"&bookid="+bookid+"&date="+date,
		success:function(data){
			hidePreloader();
			if(data.reponse=="ok"){
				$(".input-selected-tables[data-id='"+idvirtual+"']").val(data.tables);
			}else if(data.reponse=="okbutsomeexist"){
				for(b in data.blocked){
					if(data.blocked[b].blocked==true){
						UIkit.modal.alert('La table '+data.blocked[b].name+' est bloquée, veuillez la débloquée dabord.');
					}else if(data.blocked[b].blocked==false){
						UIkit.modal.confirm('Voulez-vous annulé l\'affectation de la table '+data.blocked[b].name+', car elle est associée avec une autre réservation.',function(){
							tableChangeBook(bookid,b,idvirtual,date);
						});
					}
				}
				$(".input-selected-tables[data-id='"+idvirtual+"']").val(data.tables);
				/*if(data.blocked==true){
					UIkit.modal.alert('La table '+data.existtables+' est bloquée, veuillez la débloquée dabord.');
					$(".input-selected-tables[data-id='"+idvirtual+"']").val(data.tables);
				}else if(data.blocked=="false" && data.toomanytables=="true"){
					$(".input-selected-tables[data-id='"+idvirtual+"']").val(data.tables);
				}else if(data.blocked=="false" && data.toomanytables=="false"){
					UIkit.modal.confirm('Voulez-vous annulé l\'affectation de la table '+data.existtables+', car elle associé avec une autre réservation.',tableChangeBook(data.bookid,data.tableid));
					$(".input-selected-tables[data-id='"+idvirtual+"']").val(data.tables);
				}*/
			}else if(data.reponse=="notexist"){
				$(".input-selected-tables[data-id='"+idvirtual+"']").val("");
				UIkit.modal.alert('Une erreur a été survenu.');
			}
		}
	});
}
//Function : change table of a reservation
function tableChangeBook(bookid,tableid,idvirtual,date){
	showPreloader();
	$("#book-normal").attr("disabled",true);
	if(date!=""){
		date = "&date="+date;
	}
	$.ajax({
		type: "POST",
		url: Routing.generate("book_change_tables_xhr"),
		data: "bookid=" + bookid + "&tableid=" + tableid+date,
		success: function (data) {
			hidePreloader();
			if(data.reponse=="okdate"){
				$(".input-selected-tables[data-id='"+idvirtual+"']").val(data.tablename);
				var classes = $(".table[data-id='" + tableid + "']").attr("data-class");
				$(".table[data-id='" + tableid + "']").removeClass(classes);
				$(".table[data-id='" + tableid + "']").attr("data-class", "");
				$(".table[data-id='" + tableid + "'] .uk-grid").find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
				$(".table[data-id='" + tableid + "'] .uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
				$(".booktablid[data-book-tablid='"+tableid+"']").remove();
				$(".table[data-id='" + tableid + "'] .booking-container").remove();
				$("#book-normal").removeAttr("disabled");
			}else if(data.reponse=="ok"){
				$(".booking-container[data-id='" + bookid + "']").parents(".table").find(".uk-progress").addClass("uk-hidden");
				$(".book-line[data-id='" + bookid + "'] .book-tables").empty().html('<i class="fa fa-circle"></i>' + data.tables);
				$(".book-line[data-id='" + data.otherbookid + "'] .book-tables").empty().html('<i class="fa fa-circle"></i>' + data.othertables);
				$(".input-selected-tables[data-id='"+idvirtual+"']").val(data.tables);
				var classes = $(".table[data-id='" + tableid + "']").attr("data-class");
				$(".table[data-id='" + tableid + "']").removeClass(classes);
				$(".table[data-id='" + tableid + "']").attr("data-class", "");
				$(".table[data-id='" + tableid + "'] .uk-grid").find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
				$(".table[data-id='" + tableid + "'] .uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
				$(".table[data-id='" + tableid + "'] .booking-container").remove();
				$("#book-normal").removeAttr("disabled");
			}else if(data.reponse=="notexist"){
				UIkit.modal.alert('Une erreur a été survenu.');
			}
		}
	});
}
//Function : Update Pax booking
function updatePaxBook(bookid,pax){
	showPreloader();
	$.ajax({
		type:"POST",
		url: Routing.generate("book_update_pax_xhr",{id:bookid}),
		data:"pax="+pax,
		success:function(data){
			hidePreloader();
			if(data.reponse=="ok"){
				$("#dt_individual_search tr[data-id='"+bookid+"'] .ym-searchable-pax").text("#"+data.pax+"pax#");
				$("#dt_individual_search tr[data-id='"+bookid+"'] .input-pax").val(data.pax);
				$("#dt_individual_search tr[data-id='"+bookid+"'] .input-pax.k-formatted-value").val(data.pax+" pax");
				$("#dt_individual_search tr[data-id='"+bookid+"'] .input-pax").attr("data-old-val",data.pax);
			}else if(data.reponse=="notexist"){
				var oldval=$("#dt_individual_search tr[data-id='"+bookid+"'] .input-pax").attr("data-old-val");
				$("#dt_individual_search tr[data-id='"+bookid+"'] .input-pax").val(oldval);
				UIkit.modal.alert('Une erreur a été survenu.');
			}
		}
	});
}
//Function : Add Group Table
function addGroupTable(){
	var template='';
	//unserialize serialized the form sent
	var addGroupTables=$.unserialize($("#form-addgrouptable").serialize());
	console.log(addGroupTables);
	//recuperate variables
	var name=addGroupTables.name;
	var tabl_floor_id=$("#floor_select").val();
	//create the html template
	var provisoire_id=randomString(8);
	template+='<div class="table group-table uk-button-dropdown group-'+addGroupTables.orientation+'" style="left: 0%;top: 0%;" data-id="'+provisoire_id+'" data-uk-dropdown="{mode:\'click\'}">'+
		'<span class="title">'+addGroupTables.selected_nametabls+'</span>'+
		'<span class="uk-badge uk-badge-notification nbr-covert"></span>';
	for(var i=0;i<2;i++){
		template+='<div class="sub-table rectangle"></div>';
	}
	template+='<div class="uk-dropdown">'+
		'<ul class="uk-nav uk-nav-dropdown uk-panel">'+
		'<li><a href="#"><i class="material-icons">add</i> Ajouter résa</a></li>'+
		'<li><a href="#" class="update-table"><i class="material-icons">create</i> Modifier</a></li>'+
		'<li><a href="#" class="delete-table"><i class="material-icons">close</i> Supprimer</a></li>'+
		'</ul>'+
		'</div>'+
		'</div>';

	$.ajax({
		type:"post",
		url: Routing.generate("grouptabl_add_xhr"),
		data: "name="+name+"&floor_id="+tabl_floor_id+"&orientation="+addGroupTables.orientation+"&selected_tables_id="+addGroupTables.selected_tables_id+"&provisoire_id="+provisoire_id+"&selected_nametabls="+addGroupTables.selected_nametabls,
		success:function(data){
			hidePreloader();
			if(data.reponse=="ok"){
				$(".table.group-table[data-id='"+data.provisoire_id+"']").attr("data-id",data.id);
				$(".table.group-table[data-id='"+data.id+"']").find(".title").text(data.names);
				$(".table.group-table[data-id='"+data.id+"']").find(".nbr-covert").text(data.nbrChaire);
				$(".table.group-table[data-id='"+data.id+"'] .sub-table").remove();
				$(".table.group-table[data-id='"+data.id+"']").css({top:data.TOPP+"%",left:data.LEFTP+"%"});
				for(t in data.typetables){
					var types=' square';
					if(data.typetables[t] != '') types=data.typetables[t];
					$(".table.group-table[data-id='"+data.id+"']").append('\
						<div class="sub-table '+types+'" data-id="'+t+'"></div>\
					');
					$('.table[data-id="'+t+'"]').each(function(){
						$this=$(this);
						if(!$this.hasClass('group-table')){
							$this.fadeOut('slow', function() {
								$this.remove();
							});
						}
					});
				}
				calcGroupTables($_params);
			}else if(data.reponse=="exist"){
				alert("La table existe déjà, merci d'utiliser un autre nom.");
			}
		}
	});
	return template;
}

//Function : Delete Groupe Table
function deleteGroupTable(id){
	var $grouptable=$(".table.group-table[data-id="+id+"]");
	$grouptable.find(".sub-table").each(function(){
		var $this=$(this);
		var tablid=$this.attr("data-id");
		$.ajax({
			type:"post",
			url: Routing.generate("tabl_select_xhr",{id:tablid}),
			success:function(data){
				hidePreloader();
				if(data.reponse=="ok"){
					var template="";
					template+='<div class="table uk-button-dropdown '+data.classe+'" data-id="'+data.id+'" style="left: '+data.leftp+'%;top: '+data.topp+'%;transform: rotate('+data.rotation+'deg);" data-uk-dropdown="{mode:\'click\'}"><span class="title">'+
						data.name+'</span><span class="uk-badge uk-badge-notification nbr-covert">'+data.nbrChaire+'</span>'+
						'<div class="uk-dropdown">'+
						'<div class="uk-grid uk-dropdown-grid">'+
						'<div class="uk-width-2-2">'+
						'<ul class="uk-nav uk-nav-dropdown uk-panel">'+
						'<li><a href="#"><i class="material-icons">add</i> Ajouter résa</a></li>'+
						'<li><a href="#" class="update-table"><i class="material-icons">create</i> Modifier</a></li>'+
						'<li><a href="#"><i class="material-icons">add</i> Concatener</a></li>'+
						'<li><a href="#" class="delete-table"><i class="material-icons">close</i> Supprimer</a></li>'+
						'</ul>'+
						'</div>'+
						'</div>'+
						'</div>'+
						'<div class="hidden info_table"'+
						'data-name="'+data.name+'"'+
						'data-nbrChaire="'+data.nbrChaire+'"'+
						'data-leftp="'+data.leftp+'"'+
						'data-topp="'+data.topp+'"'+
						'data-rotation="'+data.rotation+'"'+
						'></div>'+
						'</div>';
					$_plan.append(template);
				}
			}
		});
	});
	$.ajax({
		type:"DELETE",
		url: Routing.generate("grouptabl_delete_xhr",{id:id}),
		success:function(data){
			hidePreloader();
			if(data.reponse=="ok"){
				//do smtg with the socket
				$grouptable.fadeOut(500,function(){
					$grouptable.remove();
				});
			}else if(data.reponse=="notexist"){
				UIkit.modal.alert('Une erreur à été survenu.');
			}
		}
	});
}



//Function : Add Concierge
function addConcierge(data,id){
	var sexe=data.sexe;
	var image="male";
	if(sexe=="Femme") image="female";
	$("#concierge_list tbody").append('\
	<tr class="concierge" data-id="'+id+'">\
    	<td>\
            <div class="uk-grid pos-relative" data-uk-grid-margin>\
                <div class="uk-width-1-5 uk-width-small-1-5 uk-text-center">\
                    <img class="md-user-image-large" src="'+$_path+'images/'+image+'.png" alt="'+data.sexe+'"/>\
                </div>\
                <div class="uk-width-4-5 uk-width-small-4-5">\
                	<div class="uk-grid" data-uk-grid-margin>\
                        <div class="uk-width-medium-1-2 uk-width-small-1-1">\
                            <h4 class="heading_a uk-margin-small-bottom"><a href="#" title="Modifier '+data.first_name+' '+data.last_name+'" class="concierge_edit" data-id="'+id+'" data-uk-tooltip="{cls:\'uk-tooltip-small\',pos:\'bottom\'}"><span class="concierge_firstLastName">'+data.first_name+' '+data.last_name+'</span><i class="material-icons md-color-deep-purple-A400">border_color</i></a></h4>\
                            <p class="uk-margin-remove"><span class="uk-text-muted">Sexe:</span> <span class="concierge_sexe">'+data.sexe+'</span></p>\
                            <p class="uk-margin-remove"><span class="uk-text-muted">Job:</span> <span class="concierge_job">'+data.job+'</span></p>\
                        </div>\
                        <div class="uk-width-medium-1-2 uk-width-small-1-1">\
                            <p class="uk-margin-remove"><span class="uk-text-muted">Email:</span> <span class="concierge_email">'+data.email+'</span></p>\
                            <p class="uk-margin-remove"><span class="uk-text-muted">Phone:</span> <span class="concierge_mobileNumber">'+data.mobile_number+'</span></p>\
                            <p class="uk-margin-remove"><span class="uk-text-muted">Fixe:</span> <span class="concierge_fixeNumber">'+data.fixe_number+'</span></p>\
                        </div>\
                    </div>\
                </div>\
                <div class="concierge_delete_wrapper"><a href="#" class="concierge_delete" data-id="'+id+'"><i class="material-icons md-color-red-900 md-24">clear</i></a></div>\
            </div>\
            <div class="concierge_info hidden"\
            data-firstName="'+data.first_name+'"\
            data-lastName="'+data.last_name+'"\
            data-mobileNumber="'+data.mobile_number+'"\
            data-email="'+data.email+'"\
            data-job="'+data.job+'"\
            data-fixeNumber="'+data.fixe_number+'"\
            data-sexe="'+data.sexe+'"\
            ></div>\
        </td>\
    </tr>\
	');
}
//Function : Update Concierge
function updateConcierge(data,id){
	$concierge=$(".concierge[data-id='"+id+"']");
	var image="male";
	if(data.sexe=="Femme") image="female";
	$concierge.find(".concierge_image").attr("src",$_path+'images/'+image+'.png');
	$concierge.find(".concierge_firstLastName").text(data.first_name+" "+data.last_name);
	$concierge.find(".concierge_edit").attr("title",data.first_name+" "+data.last_name);
	$concierge.find(".concierge_mobileNumber").text(data.mobile_number);
	$concierge.find(".concierge_email").text(data.email);
	$concierge.find(".concierge_job").text(data.job);
	$concierge.find(".concierge_fixeNumber").text(data.fixe_number);
	$concierge.find(".concierge_sexe").text(data.sexe);
	$infos=$concierge.find(".concierge_info");
	$infos.attr("data-firstName",data.first_name);
	$infos.attr("data-lastName",data.last_name);
	$infos.attr("data-mobileNumber",data.mobile_number);
	$infos.attr("data-email",data.email);
	$infos.attr("data-job",data.job);
	$infos.attr("data-fixeNumber",data.fixe_number);
	$infos.attr("data-sexe",data.sexe);
}
//Function : Reset Concierge modal
function resetConcierge(){
	$("#concierge_new")[0].reset();
	$("#concierge-sexe").selectize()[0].selectize.setValue("");
}
//Function : Proportion Plan
function resizePlan($_plan){
	var width=$_plan.width();
	$_plan.height((width/2)+"px");
}

//Function : Show Modal Plan Tables
function showPlanTables(id){
	$("#modal-plan-container").find(".table-checkbox-id:checked").parents("label").each(function(){
		$(this).trigger("click");
	});
	var tableSelected=$(".input-selected-tables[data-id='"+id+"']").val();
	tableSelected.replace(/ /g,'');
	if(tableSelected!=""){
		var tabselected=tableSelected.split("+");
		for(ts in tabselected){
			$("#modal-plan-container").find(".table[data-name='"+tabselected[ts]+"']").parents("label").trigger("click");
		}
	}
	$("#select-tables").attr("data-id",id);
	UIkit.modal("#modal-plan-container").show();
	calcGroupTables($_params);
}

//Function : Show Modal Add Table
function showAddTable(){
	if($("#table-rectangle").prop("checked")) $("#table-rectangle").trigger('click');
	if($("#table-big").prop("checked")) $("#table-big").trigger('click');
	if($("#table-round").prop("checked")) $("#table-round").trigger('click');
	$("#form-addtable")[0].reset();
	$("#add-update-table .add-update-text").text("Ajouter");
	$("#add-update-table #update-table").attr("id","addtable").text("Ajouter");
	$("#table-bloc-duplicate").show();
	UIkit.modal("#add-update-table").show();
}
//Function : Show Modal Add Groupe Table
function showAddGroupTable(){
	$("#form-addgrouptable")[0].reset();
	$("#add-update-table .add-update-text").text("Ajouter");
	$("#add-update-table #update-table").attr("id","addtable").text("Ajouter");
	UIkit.modal("#add-update-grouptable").show();
}


//Function : Show Modal Update Table
function showUpdateTable($table){
	var id=$table.attr("data-id");
	var title=$table.find(".title").text();
	var nbr_covert=$table.find(".nbr-covert").text();
	var typetabl=$table.find(".info_table").attr("data-typeTablId");
	$("#table-id").val(id);
	$("#table-nom").val(title);
	$("#table-nbr-chaire").val(nbr_covert);
	$(".table_typetable").each(function(){
		if($(this).prop("checked")) $(this).trigger('click');
	});
	var typetabl=typetabl.split(",");
	for(tt in typetabl){
		$(".table_typetable[value='"+typetabl[tt]+"']").trigger('click');
	}
	$("#add-update-table .add-update-text").text("Modifier");
	$("#add-update-table #addtable").attr("id","update-table").text("Modifier");
	$("#table-bloc-duplicate").hide();
	UIkit.modal("#add-update-table").show();
}

//Function : Show Modal Update Group Table
function showUpdateGroupTable($table){
	var table_ids="";
	var table_names="";
	var id=$table.attr("data-id");
	var title=$table.find(".title").text();
	/*var nbr_covert=$table.find(".nbr-covert").text();
	 var typetabl=$table.find(".info_table").attr("data-typeTablId");*/
	$("#grouptable-id").val(id);
	$("#grouptable-nom").val(title);
	$table.find(".sub-table").each(function(){
		table_names=table_names+" + "+$(this).attr("data-name");
		table_ids=table_ids+","+$(this).attr("data-id");
	});

	/*$("#table-nbr-chaire").val(nbr_covert);
	 $(".table_typetable").each(function(){
	 if($(this).prop("checked")) $(this).trigger('click');
	 });
	 var typetabl=typetabl.split(",");
	 for(tt in typetabl){
	 $(".table_typetable[value='"+typetabl[tt]+"']").trigger('click');
	 }*/
	$("#add-update-grouptable #selected-group-tabls").val(table_names);
	$("#add-update-grouptable #selected-group-ids").val(table_ids);
	$("#add-update-grouptable .add-update-text").text("Modifier");
	$("#add-update-grouptable #addgrouptable").attr("id","update-grouptable").text("Modifier");
	UIkit.modal("#add-update-grouptable").show();
}

//Function : Rotatable tables
function rotateTables(){
	$( "#plan .table:not(.group-table)" ).rotatable();
	$( "#plan .table:not(.group-table)" ).rotatable('destroy');
	var params = {
		snap: 1,
		step: 45,
		stop: function(event, ui) {
			$this=$(this);
			var rotation=convertRadToDeg(ui.angle.stop);
			var rotation_start=convertRadToDeg(ui.angle.start);
			var tabl_id=parseInt($(this).attr("data-id"));
			$this.attr("data-startrotation",rotation_start);
			$.ajax({
				type:"post",
				url: Routing.generate("tabl_edit_rotation_xhr",{id:tabl_id}),
				data: "rotation="+rotation,
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						//do smtg with the socket
						$this.find(".uk-dropdown").css("transform","rotate("+(rotation*(-1))+"deg)");
					}else if(data.reponse=="notexist"){
						UIkit.modal.alert('Une erreur à été survenu.');
						$(".table[data-id='"+data.id+"']").css("transform","rotate("+$(".table[data-id='"+data.id+"']").attr("data-startrotation")+"deg)");
					}
					$this.removeAttr('data-startrotation');
				}
			});
		},
	};
	$('#plan .table:not(.group-table)').rotatable(params);
}

//Function : Destroy Rotatable tables
function destroyRotateTables(){
	$( "#plan .table:not(.group-table)" ).rotatable();
	$( "#plan .table:not(.group-table)" ).rotatable('destroy');
}

//Function : Drag tables
function dragTables($parent){
	//init draggable for tables
	$( "#plan .table" ).draggable();
	//destroy draggable for tables
	$( "#plan .table" ).draggable('destroy');
	//Draggable tables
	$( "#plan .table" ).draggable({
		grid: [ 20, 20 ],
		containment: "parent",
		stop: function( event, ui ) {
			$this=$(this);
			$ui=ui;
			var left=parseInt($this.css("left")) / ($parent.width() / 100);
			var top=parseInt($this.css("top")) / ($parent.height() / 100);
			var lastleft=parseInt($ui.originalPosition.left) / ($parent.width() / 100);
			var lasttop=parseInt($ui.originalPosition.top) / ($parent.height() / 100);
			$this.css("left",left+"%");
			$this.css("top",top+"%");
			$this.attr("data-lastleft",lastleft+"%");
			$this.attr("data-lasttop",lasttop+"%");
			var tabl_id=parseInt($this.attr("data-id"));
			var link="tabl_edit_drag_xhr";
			if($this.hasClass('group-table')){
				link="grouptabl_edit_drag_xhr";
			}
			$.ajax({
				type:"post",
				url: Routing.generate(link,{id:tabl_id}),
				data: "left="+left+"&top="+top,
				success:function(data){
					hidePreloader();
					if(data.reponse=="ok"){
						//do smtg with the socket
					}else if(data.reponse=="notexist"){
						UIkit.modal.alert('Une erreur à été survenu.');
						if($this.hasClass('group-table')){
							$(".table.group-table[data-id='"+data.id+"']").css("left",$(".table[data-id='"+data.id+"']").attr("data-lastleft"));
							$(".table.group-table[data-id='"+data.id+"']").css("top",$(".table[data-id='"+data.id+"']").attr("data-lasttop"));
						}else{
							$(".table:not(.group-table)[data-id='"+data.id+"']").css("left",$(".table[data-id='"+data.id+"']").attr("data-lastleft"));
							$(".table:not(.group-table)[data-id='"+data.id+"']").css("top",$(".table[data-id='"+data.id+"']").attr("data-lasttop"));
						}
					}
					$this.removeAttr('data-lastleft');
					$this.removeAttr('data-lasttop');
				}
			});


		}
		/*,snap: true*/ });
}

//Function : Destroy Drag Tables
function destroyDragTables(){
	$( "#plan .table" ).draggable();
	$( "#plan .table" ).draggable('destroy');
}

//Function : Show Preloader
function showPreloader(){
	return altair_helpers.content_preloader_show();
}

//Function : Hide Preloader
function hidePreloader(){
	return altair_helpers.content_preloader_hide();
}

//Function : Calculate Group Tables
function calcGroupTables(params){
	var i=1,groups=[];
	$(".group-table").each(function(){
		var $group=$(this);
		//Number of tables in the group
		var nbrTables= $(this).find(".sub-table").length;
		//init variables
		var rectangle=0,square=0,bigsquare=0,roundsquare=0,biground=0,widthGroup=0,heightGroup=0;
		var vertical=false;
		//Add an id for each group
		$group.attr("data-group-js-id",i);
		//Check if the join is vertical or not
		if($group.hasClass('group-vertical')) vertical=true;
		//loop for tables
		$group.find(".sub-table").each(function(){
			//increment types of tables
			if($(this).hasClass('big')){
				if($(this).hasClass('round')){
					var selector="biground";
					biground++;
				}else{
					var selector="bigsquare";
					bigsquare++;
				}
			}else if($(this).hasClass('rectangle')){
				var selector="rectangle";
				rectangle++;
			}else if($(this).hasClass('round')){
				var selector="roundsquare";
				roundsquare++;
			}else{
				var selector="square";
				square++;
			}
			//width and height of the group
			if(vertical){
				widthGroup=(eval("params."+selector+".width")>widthGroup) ? eval("params."+selector+".width") : widthGroup;
				heightGroup+=eval("params."+selector+".height");
			}else{
				widthGroup+=eval("params."+selector+".width");
				heightGroup=(eval("params."+selector+".height")>heightGroup)? eval("params."+selector+".height") : heightGroup;
			}
		});
		//store information about the group
		groups[i]={"width":widthGroup,"height":heightGroup,"vertical":vertical,"types":{"rectangle":rectangle,"square":square,"bigsquare":bigsquare,"biground":biground,"roundsquare":roundsquare}};
		//update the width of the group
		$group.css({"width":widthGroup+"%","height":heightGroup+"%"});
		i++;
	});
	//read information stored
	for(groupid in groups){
		var $group=$(".group-table[data-group-js-id="+groupid+"]");
		//Number of tables in the group
		var nbrTables= $group.find(".sub-table").length;
		//check if this type is defined in the group
		if(groups[groupid].types.biground>0){
			//check if the attribute of the table exist
			var valideAttr=$group.find(".sub-table.big.round").attr("data-valide");
			if(typeof valideAttr==typeof undefined || valideAttr === false){
				//width->100% for vertical group
				//height->100% for horizontal group
				if(groups[groupid].vertical){
					var percentW=100;var percentH=100/(groups[groupid].height/params.biground.height);
				}else{
					var percentW=100/(groups[groupid].width/params.biground.width);var percentH=100;
				}
				//Put the width and height of tables and add the attribute data-valide
				$group.find(".sub-table.big.round").css({"width":percentW+"%","height":percentH+"%"}).attr("data-valide","1");
			}
		}
		if(groups[groupid].types.rectangle>0){
			var valideAttr=$group.find(".sub-table.rectangle").attr("data-valide");
			if(typeof valideAttr==typeof undefined || valideAttr === false){
				if(groups[groupid].vertical){
					var percentW=100;var percentH=100/(groups[groupid].height/params.rectangle.height);
				}else{
					var percentW=100/(groups[groupid].width/params.rectangle.width);var percentH=100;
				}
				$group.find(".sub-table.rectangle").css({"width":percentW+"%","height":percentH+"%"}).attr("data-valide","1");
			}
		}
		if(groups[groupid].types.square>0){
			var valideAttr=$group.find(".sub-table.square").attr("data-valide");
			if(typeof valideAttr==typeof undefined || valideAttr === false){
				if(groups[groupid].vertical){
					var percentW=100;var percentH=100/(groups[groupid].height/params.square.height);
				}else{
					var percentW=100/(groups[groupid].width/params.square.width);var percentH=100;
				}
				$group.find(".sub-table.square").css({"width":percentW+"%","height":percentH+"%"}).attr("data-valide","1");
			}
		}
		if(groups[groupid].types.bigsquare>0){
			var valideAttr=$group.find(".sub-table.big.square").attr("data-valide");
			if(typeof valideAttr==typeof undefined || valideAttr === false){
				if(groups[groupid].vertical){
					var percentW=100;var percentH=100/(groups[groupid].height/params.bigsquare.height);
				}else{
					var percentW=100/(groups[groupid].width/params.bigsquare.width);var percentH=100;
				}
				$group.find(".sub-table.big.square").css({"width":percentW+"%","height":percentH+"%"}).attr("data-valide","1");
			}
		}

		if(groups[groupid].types.roundsquare>0){
			var valideAttr=$group.find(".sub-table.round").attr("data-valide");
			if(typeof valideAttr==typeof undefined || valideAttr === false){
				if(groups[groupid].vertical){
					var percentW=100;var percentH=100/(groups[groupid].height/params.roundsquare.height);
				}else{
					var percentW=100/(groups[groupid].width/params.roundsquare.width);var percentH=100;
				}
				$group.find(".sub-table.round").css({"width":percentW+"%","height":percentH+"%"}).attr("data-valide","1");
			}
		}
	}
	//Remove the attributes data-group-js-id and data-valide to groups,tables
	$(".group-table").removeAttr('data-group-js-id');
	$(".sub-table").removeAttr('data-valide');
}

//Function : Get Selected Tables
function get_selected_tables($val){
	var tables="";
	var ids="";
	$("#select-tables").parents("#modal-plan-container").find(".table-checkbox-id:checked").each(function(){
		tables+=$(this).parents(".table").find(".title").text()+"+";
		ids+=$(this).parents(".table").attr("data-id")+",";
	});
	tables=tables.substring(0,(tables.length-1));
	ids=ids.substring(0,(ids.length-1));
	$(".input-selected-tables[data-id='"+$val+"']").val(tables);
	$(".selected-tables-id[data-id='"+$val+"']").val(ids);
}

//Function : Select Passage Hour
function selectPassageHour(){
	$("#book_hour").click();
}

//Function : Select Passage Pax
function selectPassagePax(){
	$("select#passage-pax").next(".selectize-control").find(".selectize-input").trigger('click');
}

//Function : Select Passage Floor
function selectPassageFloor(){
	$("select#passage-floor").next(".selectize-control").find(".selectize-input").trigger('click');
}

//Function : Clock start time
function startTime() {
	var timenow=Math.round(moment().tz("Europe/London").valueOf()/1000);
	var timenowFormat=moment().tz("Europe/London").format("HH:mm");
	$("#clock span").html(timenowFormat);
	$("#clock").attr("data-timestamp",timenow);
	var datetoday=$("#date_today").val();
	var dateselected=$("#date_select,#date-books").val();
	if( $("#date_today").length>0 && $("#date_select,#date-books").length>0 && datetoday==dateselected){
		//Functions that have a relation with the clock goes here
		checkTimestampTables(timenow);

		checkTimestampBooks(timenow);

		checkPendingBooks();
	}
	console.clear();

	var t = setTimeout(startTime, 15000);
}

//Function : Add zero in the first of minutes if they are less than 10
function checkTime(i) {
	if (i < 10 && i >= 0) {i = "0" + i};
	return i;
}

//Function : Check tables that have a timestamp less than the clock
function checkTimestampTables(timenow){
	$(".book-line.reserved[data-timestamp],.book-line.noshow[data-timestamp]").each(function(){//,.book-line.late[data-timestamp]
		var bookid=$(this).attr("data-id");
		var timeTable=parseInt($(this).attr("data-timestamp"));
		var bookstate=$(this).attr("data-state");
		if(timenow>=timeTable){
			var difference=timenow-timeTable;
			if(difference <= $_timeretard && $_optionlate=="late,noshow"){
				if($(this).attr("data-state")=="late"){

				}else{
					//bookLate(bookid);
					//sortBooks();
				}
				var diffretard=$_timeretard-difference;
				var percent=Math.round(((diffretard)/$_timeretard)*100);
				if(percent>=0){
					$(".booking-container[data-id='"+bookid+"']").parents(".table").find(".book-late").removeClass("uk-hidden");
					$(".booking-container[data-id='"+bookid+"']").parents(".table").find(".book-late .uk-progress-bar").css("width",percent+"%");
				}
			}else if(difference<=$_noshow){
				if($(this).attr("data-state")=="noshow") {

				}else{
					bookNoShow(bookid);
					sortBooks();
				}
				$(".booking-container[data-id='"+bookid+"']").parents(".table").find(".book-late").addClass("uk-hidden");
				var diffnoshow=$_noshow-difference;
				var percent=Math.round(((diffnoshow)/$_noshow)*100);
				if(percent>=0 && percent<=100){
					$(".booking-container[data-id='"+bookid+"']").parents(".table").find(".book-noshow").removeClass("uk-hidden");
					$(".booking-container[data-id='"+bookid+"']").parents(".table").find(".book-noshow .uk-progress-bar").css("width",percent+"%");
				}
			}else if(difference>$_noshow){
				$(".booking-container[data-id='"+bookid+"']").parents(".table").removeAttr("data-timestamp");
				$(".booking-container[data-id='"+bookid+"']").parents(".table").find(".book-noshow").addClass("uk-hidden");
				if(bookstate!="noshow"){
					bookFreeTabls(bookid);
					sortBooks();
				}
			}
		}/*else{
		 }*/
	});
}
//Function : Check books that have a timestamp less than the clock
function checkTimestampBooks(timenow){
	$(".ym-book.reserved[data-timestamp],.ym-book.noshow[data-timestamp]").each(function(){//,.ym-book.late[data-timestamp]
		var timeTable=parseInt($(this).attr("data-timestamp"));
		var bookid=$(this).attr("data-id");
		var bookstate=$(this).attr("data-state");
		if(timenow>=timeTable){
			var difference=timenow-timeTable;
			if(difference <= $_timeretard){
				if($(this).attr("data-state")=="late"){

				}else{
					//bookLateSinTable(bookid);
					//sortBooks();
				}
			}else if(difference<=$_noshow){
				if($(this).attr("data-state")=="noshow") {

				}else{
					bookNoShowSinTable(bookid);
					sortBooks();
				}
			}else if(difference>$_noshow){
				$(this).removeAttr("data-timestamp");
				$(this).find(".book-noshow").addClass("uk-hidden");
				if(bookstate!="noshow"){
					bookFreeTablsSinTable(bookid);
					sortBooks();
				}
			}
		}/*else{
		 }*/
	});
}
//Function : Check books that have a timestamp less than the clock
function checkPendingBooks(){
	$(".book-line.pending").each(function(){
		var bookid=$(this).attr("data-id");
		$beginwaiting=$(this).find(".book-beginingwaiting");
		if($beginwaiting.length>0){
			var date=$beginwaiting.attr("data-time");
			var timewaiting=countWaiting(date);
			$beginwaiting.text(timewaiting);
		}
	});
}
//Function : Make a book late
function bookLate(bookid){
	$.ajax({
		type:"post",
		url: Routing.generate("book_booklate",{book:bookid}),
		success:function(data){
			if(data.reponse=="ok"){
				$(".booking-container[data-id='"+bookid+"']").parents(".table").removeClass (function (index, css) {
					return (css.match (/(^|\s)md-bg-\S+/g) || []).join(' ');
				}).attr("data-class","md-bg-"+data.state).addClass("md-bg-"+data.state);
				var oldstate=$(".booking-container[data-id='"+bookid+"']").parents(".table").attr("data-state");
				$(".booking-container[data-id='"+bookid+"']").parents(".table").removeClass(oldstate).attr("data-state","late");
				$(".book-line[data-id='"+bookid+"']").removeClass (function (index, css) {
					return (css.match (/(^|\s)md-bg-\S+/g) || []).join(' ');
				}).attr("data-class","md-bg-"+data.state).addClass("md-bg-"+data.state+" late");
				var oldstate=$(".book-line[data-id='"+bookid+"']").attr("data-state");
				$(".book-line[data-id='"+bookid+"']").removeClass(oldstate).attr("data-state","late");
				addWaitPending(bookid,data.BeginingWaitingTime);
				sortBooks();
			}
		}
	});
}
//Function : Make a book late
function bookLateSinTable(bookid){
	$.ajax({
		type:"post",
		url: Routing.generate("book_booklate",{book:bookid}),
		success:function(data){
			if(data.reponse=="ok"){
				$(".ym-book[data-id='"+bookid+"'] select.selectstate").data('kendoDropDownList').value(3);
				$(".ym-book[data-id='"+bookid+"'] select.selectstate").data('kendoDropDownList').trigger("change");
				var oldstate=$(".ym-book[data-id='"+bookid+"']").attr("data-state");
				$(".ym-book[data-id='"+bookid+"']").removeClass(oldstate).attr("data-state","late");
				addWaitPending(bookid,data.BeginingWaitingTime);
				sortBooks();
			}
		}
	});
}
//Function : Make a book no show
function bookNoShow(bookid){
	$.ajax({
		type:"post",
		url: Routing.generate("book_booknoshow",{book:bookid}),
		success:function(data){
			if(data.reponse=="ok"){
				$(".booking-container[data-id='"+bookid+"']").parents(".table").removeClass (function (index, css) {
					return (css.match (/(^|\s)md-bg-\S+/g) || []).join(' ');
				}).attr("data-class","md-bg-"+data.state).addClass("md-bg-"+data.state);
				var oldstate=$(".booking-container[data-id='"+bookid+"']").parents(".table").attr("data-state");
				$(".booking-container[data-id='"+bookid+"']").parents(".table").removeClass(oldstate).attr("data-state","noshow");
				$(".book-line[data-id='"+bookid+"']").removeClass (function (index, css) {
					return (css.match (/(^|\s)md-bg-\S+/g) || []).join(' ');
				}).attr("data-class","md-bg-"+data.state).addClass("md-bg-"+data.state+" noshow blink");
				var oldstate=$(".book-line[data-id='"+bookid+"']").attr("data-state");
				$(".book-line[data-id='"+bookid+"']").removeClass(oldstate).attr("data-state","noshow");
				addWaitPending(bookid,data.BeginingWaitingTime);
				sortBooks();
			}
		}
	});
}
//Function : Make a book noshow
function bookNoShowSinTable(bookid){
	$.ajax({
		type:"post",
		url: Routing.generate("book_booknoshow",{book:bookid}),
		success:function(data){
			if(data.reponse=="ok"){
				$(".ym-book[data-id='"+bookid+"'] select.selectstate").data('kendoDropDownList').value(7);
				$(".ym-book[data-id='"+bookid+"'] select.selectstate").data('kendoDropDownList').trigger("change");
				var oldstate=$(".ym-book[data-id='"+bookid+"']").attr("data-state");
				$(".ym-book[data-id='"+bookid+"']").removeClass(oldstate).attr("data-state","noshow");
				addWaitPending(bookid,data.BeginingWaitingTime);
				sortBooks();
			}
		}
	});
}
//Function : Make a book noshow and show modal
function bookFreeTabls(bookid){
	$.ajax({
		type:"post",
		url: Routing.generate("book_bookfreetabls",{book:bookid}),
		success:function(data){
			if(data.reponse=="ok"){
				if(1==2){
					$(".table[data-id='"+tablid+"']").removeClass (function (index, css) {
						return (css.match (/(^|\s)md-bg-\S+/g) || []).join(' ');
					}).attr("data-class","").removeAttr("data-state");

					$(".table[data-id='"+tablid+"'] .booking-container").each(function(){
						if($(".booktablid[data-book-tablid='"+tablid+"']").length>0){
							var classes=$(this).parents(".table").attr("data-class");
							$(this).parents(".table").removeClass(classes);
							$(this).parent(".uk-grid").find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
							$(this).parents(".uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width","initial");
							$(this).remove();
							$(this).find(".table-booked").remove();
							//DELETE BOOKING CONTAINER
							$(".booktablid[data-book-tablid='"+tablid+"']").parents(".book-tables").empty();
						}
					});
				}else{
					$(".booking-container[data-id='"+bookid+"']").parents(".table").removeClass (function (index, css) {
						return (css.match (/(^|\s)md-bg-\S+/g) || []).join(' ');
					}).attr("data-class","md-bg-"+data.state).addClass("md-bg-"+data.state);
					var oldstate=$(".booking-container[data-id='"+bookid+"']").parents(".table").attr("data-state");
					$(".booking-container[data-id='"+bookid+"']").parents(".table").removeClass(oldstate).attr("data-state","noshow");
					$(".book-line[data-id='"+bookid+"']").removeClass (function (index, css) {
						return (css.match (/(^|\s)md-bg-\S+/g) || []).join(' ');
					}).attr("data-class","md-bg-"+data.state).addClass("md-bg-"+data.state+" noshow blink");
					var oldstate=$(".book-line[data-id='"+bookid+"']").attr("data-state");
					$(".book-line[data-id='"+bookid+"']").removeClass(oldstate).attr("data-state","noshow");
					addWaitPending(bookid,data.BeginingWaitingTime);

					/*$("#modal_overflow").removeClass("passage");
					 $("#book_typebook").val("resa");
					 getBookCustomer(bookid);*/
				}

				/*$(".book-line[data-id='"+bookid+"']").removeClass (function (index, css) {
				 return (css.match (/(^|\s)md-bg-\S+/g) || []).join(' ');
				 }).attr("data-class","").removeAttr("data-state");*/
				sortBooks();
			}
		}
	});
}
//Function : Make a book noshow and show modal
function bookFreeTablsSinTable(bookid){
	$.ajax({
		type:"post",
		url: Routing.generate("book_bookfreetabls",{book:bookid}),
		success:function(data){
			if(data.reponse=="ok"){
				$(".ym-book[data-id='"+bookid+"'] select.selectstate").data('kendoDropDownList').value(7);
				$(".ym-book[data-id='"+bookid+"'] select.selectstate").data('kendoDropDownList').trigger("change");
				var oldstate=$(".ym-book[data-id='"+bookid+"']").attr("data-state");
				$(".ym-book[data-id='"+bookid+"']").removeClass(oldstate).attr("data-state","noshow");
				addWaitPending(bookid,data.BeginingWaitingTime);

				/*$("#modal_overflow").removeClass("passage");
				 $("#book_typebook").val("resa");
				 getBookCustomer(bookid);*/
				sortBooks();
			}
		}
	});
}

//Function : Convert Rad To Deg
function convertRadToDeg(radians){
	degrees = Math.round(radians * (180/Math.PI));
	return degrees;
}

//Function : Generate a random string
function randomString(len) {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	var randomstring = '';
	len = len || 20;
	for (var i = 0; i < len; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum, rnum + 1);
	}
	return randomstring;
}
//Function : Change xhr state
function selectState(e){
	$this=$(this.element.context);
	var $tdparent=$this.parentElement;
	var valstate=$this.val();
	var $selectedstate=$("#allstates").find("option[value='"+valstate+"']");
	var statename=$selectedstate.text();
	var color=$selectedstate.attr("data-color");
	var flashed=$selectedstate.attr("data-flashed");

	//console.log(datas);
	//$this.parents("td").find(".ym-searchable-val").text("#"+statename+"#");
	$this.parents("td").removeAttr("class");
	$this.parents("td").addClass("md-bg-"+color);
	if(flashed=="1") $this.parents("td").addClass("blink");
	var book=$this.parents("tr").attr("data-id");
	var state=valstate;

	if($("#noupdate").length==0){
		showPreloader();
		$.ajax({
			type:"get",
			url: Routing.generate("book_changestate",{book:book,state:state}),
			success:function(data){
				showNotify(data.message, "info");
				addWaitPending(book,data.BeginingWaitingTime);
				var dt=$("#dt_individual_search").DataTable();
				var cell=dt.cell($this.parents("td"));
				var chaine='<span class="book-orderstate uk-hidden">'+data.orderstate+'</span><span class="uk-hidden ym-searchable-val">#'+statename+'#</span>'+
					'<select class="uk-form-width-medium selectstate">';
				var allstates=$("#allstates").html();
				allstates=allstates.replace('value="'+state+'"','value="'+state+'" selected');
				chaine+=allstates;
				chaine+='</select>';
				var oldstate=$this.parents("tr").attr("data-state");
				$this.parents("tr").removeClass(oldstate).addClass(data.stateslugify).attr("data-state",data.stateslugify);
				cell.data(chaine).draw();
				selectstateInit();
				hidePreloader();
				sortBooks();
			}
		});
	}
}
function bookliberatetable(book,table){
	showPreloader();
	$.ajax({
		type:"post",
		url: Routing.generate("book_bookliberatetabl",{book:book,table:table}),
		success:function(data){
			showNotify(data.message, "info");
			if($("#plan").length>0){
				$book=$(".book-line[data-id='" + book + "']");
				$table=$(".table[data-id='" + table + "']");
				var oldclass = $table.attr("data-class");
				var oldstate = $table.attr("data-state");
				$table.removeClass(oldclass + " " + oldstate+" with-status");
				$table.attr("data-class", "").attr("data-state", "");
				$table.find(".nbr-covert").remove();
				$table.find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
				$table.find(".uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
				$table.find(".table-booked").remove();
				$table.find(".booking-container").remove();
				$book.find(".book-tables").empty().html(data.newtables);
				dragBook();
				droppableTable();
				dragBookTabl();
				sortBooks();
			}
			hidePreloader();
		}
	});
}
function bookchangestate(book,state){
	showPreloader();
	$.ajax({
		type:"get",
		url: Routing.generate("book_changestate",{book:book,state:state}),
		success:function(data){
			showNotify(data.message, "info");
			addWaitPending(book,data.BeginingWaitingTime);
			if($("#plan").length>0){
				$book=$(".book-line[data-id='" + book + "']");
				var oldclass = $book.attr("data-class");
				var oldstate = $book.attr("data-state");
				$book.removeClass(oldclass + " " + oldstate);
				$book.addClass("md-bg-" + data.class + " " + data.stateslugify);
				$book.attr("data-class", "md-bg-" + data.class).attr("data-state", data.stateslugify);
				$book.find(".book-stateid").empty().text(data.stateid);
				$book.find(".book-orderstate").empty().text(data.orderstate);
				$table=$(".table .booking-container[data-id='" + book + "']").parents(".table");
				$table.each(function(){
					var oldclass = $(this).attr("data-class");
					var oldstate = $(this).attr("data-state");
					$(this).removeClass(oldclass + " " + oldstate);
					$(this).addClass("md-bg-" + data.class + " " + data.stateslugify);
					$(this).attr("data-class", "md-bg-" + data.class).attr("data-state", data.stateslugify);
				});
				//$table.removeClass(oldclass + " " + oldstate);
				//$table.addClass("md-bg-" + data.class + " " + data.stateslugify);
				//$table.attr("data-class", "md-bg-" + data.class).attr("data-state", data.stateslugify);
				$(".contextmenu").remove();
				if(state==5 || state==4){
					$table.each(function(){
						$(this).removeClass("md-bg-" + data.class+ " " + data.stateslugify+" with-status");
						$(this).attr("data-class","").attr("data-state","");
						$(this).find(".nbr-covert").remove();

						$(this).find(".uk-width-1-2").removeClass("uk-width-1-2").addClass("uk-width-2-2");
						$(this).find(".uk-dropdown").removeClass("uk-dropdown-width-2").css("min-width", "initial");
						$(this).find(".table-booked").remove();
						$(this).find(".booking-container").remove();
					});
					$book.animate({
						opacity: 0,
						left: "200px"},
						500, function() {
						$book.remove();
					});
				}else if(state == 6){
					if($book.find(".book-beginingwaiting").length>0){
						$book.find(".book-beginingwaiting").attr("data-time",data.BeginingWaitingTime);
					}else{
						$book.find(".just-in-pending").empty().html('<span class="book-beginingwaiting md-color-deep-orange-900" data-time="'+data.BeginingWaitingTime+'"></span>');
					}
					addWaitPending(book,data.BeginingWaitingTime);
				}else if(state==2 || state==8){
					$table.each(function(){
						$(this).find(".book-late").addClass('uk-hidden').find(".uk-progress-bar").css("width","0%");
						$(this).find(".book-noshow").addClass('uk-hidden').find(".uk-progress-bar").css("width","0%");
					});
					$book.find(".icon-no-show").remove();
				}
				dragBook();
				droppableTable();
				dragBookTabl();
				sortBooks();
			}else{
				$(".bookchangestate").removeClass("ym-active ym-inactive").addClass("ym-inactive");
				$(".bookchangestate[data-state='"+state+"']").removeClass("ym-active ym-inactive").addClass("ym-active");
				var classe=$(".bookds .bookds-status").attr("data-class");
				$(".bookds .bookds-status").removeClass(classe).addClass("md-bg-"+data.class).attr("data-class","md-bg-"+data.class);
				$(".bookds .bookds-status").text(data.statename);
			}
			hidePreloader();
		}
	});
}

function sortBooks(){
	tinysort('ul.ym-book-list>.book-line','span.book-orderstate','span.book-hour');
	tinysort('#dt_individual_search tbody>tr.ym-book','span.book-orderstate','a.book_update_hour>strong');
}
//Function : Counting number minutes hours days
function countWaiting(dateassist){
	var dateassist = new Date(dateassist);
	var now = new Date();
	var diffMs = (now - dateassist); // milliseconds between now & Christmas
	var diffDays = parseInt(diffMs / 86400000); // days
	var diffHrs = parseInt((diffMs % 86400000) / 3600000); // hours
	var diffMins = parseInt(((diffMs % 86400000) % 3600000) / 60000); // minutes
	var waitedtime="";
	if(diffDays>0){
		waitedtime+=diffDays+"j ";
	}
	waitedtime+=checkTime(diffHrs)+":"+checkTime(diffMins);
	return waitedtime;
}
//Function : add wait Pending book line
function addWaitPending(bookid,datewaiting){
	if(datewaiting==""){
		if($(".book-line[data-state='pending'][data-id='"+bookid+"'] .just-in-pending").length>0){
			$(".book-line[data-state='pending'][data-id='"+bookid+"'] .just-in-pending").empty();
		}
	}else{
		if($(".book-line[data-state='pending'][data-id='"+bookid+"'] .just-in-pending").length>0){
			var chaine='<i class="uk-icon-refresh uk-icon-spin md-color-deep-orange-900"></i> <span class="book-beginingwaiting md-color-deep-orange-900" data-time="'+datewaiting+'"></span> ';
			$(".book-line[data-state='pending'][data-id='"+bookid+"'] .just-in-pending").empty().html(chaine);
		}
	}
}
function switchTables(bookid1,tableid1,bookid2,tableid2){
	$.ajax({
		type: "POST",
		url: Routing.generate("book_switch_tables_xhr"),
		data: "bookid1=" + bookid1 + "&tableid1=" + tableid1+"&bookid2=" + bookid2 + "&tableid2=" + tableid2,
		success: function (data) {
			hidePreloader();
			if(data.reponse=="ok"){
				//Traitement
				$(".booking-container[data-id='" + bookid1 + "']").parents(".table").find(".uk-progress").addClass("uk-hidden");
				$(".book-line[data-id='" + bookid1 + "'] .book-tables").empty().html('<i class="fa fa-circle"></i>' + data.tables1);
				var classes = $(".table[data-id='" + tableid1 + "']").attr("data-class");
				$(".table[data-id='" + tableid1 + "']").removeClass(classes);
				$(".table[data-id='" + tableid1 + "']").attr("data-class", "");
				var bookingcontainer1=$(".booking-container[data-id='"+bookid1+"']").html();
				var bookingcontainer2=$(".booking-container[data-id='"+bookid2+"']").html();
				$(".booking-container[data-id='"+bookid1+"']").empty().html(bookingcontainer2);
				$(".booking-container[data-id='"+bookid2+"']").empty().html(bookingcontainer1);
				$(".booking-container[data-id='"+bookid1+"']").attr("data-id","update"+bookid2);
				$(".booking-container[data-id='"+bookid2+"']").attr("data-id",bookid1);
				$(".booking-container[data-id='update"+bookid2+"']").attr("data-id",bookid2);

				$(".booking-container[data-id='" + bookid2 + "']").parents(".table").find(".uk-progress").addClass("uk-hidden");
				$(".book-line[data-id='" + bookid2 + "'] .book-tables").empty().html('<i class="fa fa-circle"></i>' + data.tables2);
				var classes = $(".table[data-id='" + tableid2 + "']").attr("data-class");
				$(".table[data-id='" + tableid2 + "']").removeClass(classes);
				$(".table[data-id='" + tableid2 + "']").attr("data-class", "");
				$(".table[data-id='" + tableid2 + "']").addClass(data.state1).attr("data-class",data.state1);
				$(".table[data-id='" + tableid1 + "']").addClass(data.state2).attr("data-class",data.state2);

			}else if(data.reponse=="notexist"){
				UIkit.modal.alert('Une erreur a été survenu.');
			}
		}
	});
}
function selectstateInit(){
	$("select.selectstate").each(function(){
		$(this).kendoDropDownList({change: selectState});
	});
}
function numerictextInit(){
	$("input.number").kendoNumericTextBox({
		format: "# pax"
	});
}
function emptyModalInputs(){
	$("select#book_floor option[value='']").prop("selected",true);
	//$("select#book_floor").selectize()[0].selectize.setValue("");
	$("select#book_offer option[value='']").prop("selected",true);
	//$("select#book_offer").selectize()[0].selectize.setValue("");
	$("select#book_state option[value='']").prop("selected",true);
	//$("select#book_state").selectize()[0].selectize.setValue("");
	$("select#book_occasion option[value='']").prop("selected",true);
	//$("select#book_occasion").selectize()[0].selectize.setValue("");
	$("#customer_sexe").val("Mr.");
	$(".btn-sexe").removeClass("active");
	$(".btn-sexe[data-val='Mr.']").addClass("active");
	//$("select#customer_sexe").selectize()[0].selectize.setValue("");
	$("select#customer_langue option[value='francais']").prop("selected",true);
	//$("select#customer_langue").selectize()[0].selectize.setValue("francais");
}
function getStatePlan(date){
	$.ajax({
		type: "GET",
		url: Routing.generate("floor_getbooks_date",{date:date}),
		success: function (data) {
			hidePreloader();
			if(data.reponse=="ok"){
				var booktables=jQuery.parseJSON(data.booktables);
				$(".modal-table").each(function(){
					var classes=$(this).attr("data-class");
					$(this).removeClass(classes);
				});
				jQuery.each( booktables, function( tableid, options ) {
				  $(".modal-table[data-id='"+tableid+"']").addClass(options.state).attr("data-class",options.state);
				});
			}else if(data.reponse=="notexist"){
				UIkit.modal.alert('Une erreur a été survenu.');
			}
		}
	});
}
////////////////////////////////////////////////STATE BOOKS////////////////////////////////////
calcGroupTables($_params);