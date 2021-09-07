import 'bootstrap';
window.$ = window.jQuery = require('jquery');
var Chart = require('chart.js');

$(document).ready(function() {

	$('[data-toggle="tooltip"]').tooltip();
	$('.toast').toast('show');

	var pieChart 		= document.getElementById('overallChart');
	var attendanceChart = document.getElementById('attendanceChart');
	var origin 			= window.location.origin;
	var birthday 		= document.getElementById('birthday-modal');
	var travels 		= document.getElementById('travelOrder');
	var reservation 	= document.getElementById('vehicleReservation');
	var start_date 		= document.getElementById('start_date');
	var end_date 		= document.getElementById('end_date');
	var date 			= document.getElementById('date');
	var notifCount 		= $('#notification-count').text();
	var content  		= $('#notification-content').html();
	var template 		= '<div class="popover rounded-0" role="tooltip">'+'<div class="arrow"></div>'+
						   '<div class="card-header notif-header p-2 px-3"><div class="d-flex align-items-center"><span class="float-left mx-auto w-100">Notifications</span><a href="'+origin+'/notifications/read/all" class="text-nowrap">Mark All as Read</a></div></div>'+
						   '<div class="popover-body p-0"></div>'+
					   '</div>';


	var report 			= document.getElementById('report');

	if(birthday) {
		$('#birthday-modal').modal('show');

		$('#birthday-modal').on('hidden.bs.modal', function(e) {
			$.each($('.birthday-rows'), function(i, e) {
				$.get($(this).data('route'));
			});
		});
	}

	if(notifCount != "") {
		$('#notifications').popover({
			trigger: 'focus',
			placement: 'bottom',
			html: true,
			content: content,
			template: template,
		});
	}

	$('#confirmationModal').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });

	if(date) {
		datepicker();
	}

	if($('#pdsDate')) {
		$('#pdsDate').datepicker({
			yearRange: "-100:+1",
			changeMonth: true,
			changeYear: true,
		});	
	}
	

	if(start_date && end_date) {
		if(reservation) {
			date_range_reservation();
		}
		else {
			date_range();
		}
	}

	$('.clickable-row, #newDTR, #newChild, #newEducation, #newAttendance, #newSchedule, #newCOC, #newBalance, #newCredit, .viewBtn, #newBtn, #notificationBtn').click(function() {

		var url 		= $(this).data('url');
		var viewUrl 	= $(this).data('view');
		var tab 		= $(this).data('tab');

		if(tab) {
			if(tab == 'yes') {
				window.open($(this).data("href"), "_blank");
			}
			else {
				window.location = $(this).data("href");
			}
		}

		$.get(url, function(data) {
			$('#formContainer').html(data);
			$('#statusContainer').html(data);
			$('#viewBtn').attr("href", viewUrl);
		});
	});

	if($('.chosen-select')) {
		$('.chosen-select').chosen();
		resizeChosen();
		jQuery(window).on('resize', resizeChosen);
	}

	if($('#approvalModal')) {
		$('#approvalModal').on('shown.bs.modal', function() {
			$('.chosen-select', this).chosen('destroy').chosen();
			date_range();
		});
	}

	if(travels) {
		checked('.general_funds', '#general_funds');
	    checked('.project_funds', '#project_funds');
	    checked('.others', '#others');

	    $('#general_funds').click(function() {
	    	checked('#general_funds', '.general_funds');
	    });
	    $('#project_funds').click(function() {
	    	checked('#project_funds', '.project_funds');
	    });
	    $('#others').click(function() {
	    	checked('#others', '.others');
	    });

	    $('.general_funds').click(function() {
	    	checked('.general_funds', '#general_funds');
	    });
	    $('.project_funds').click(function() {
	    	checked('.project_funds', '#project_funds');
	    });
	    $('.others').click(function() {
	    	checked('.others', '#others');
	    });
	}

	$('#start_date, #end_date').on('change', function() {
		var start 	= $('#start_date').val();
		var end 	= $('#end_date').val();

		if(start == end) {
			$('#time').removeAttr('disabled', true);
		}
		else {
			$('#time').attr('disabled', true);
		}
	});

	$('#vacation_leave').click(function() {
		if($(this).is(':checked')) {
			$('#vl_specify').removeAttr('disabled', true);

			if($('#vl_specify').change(function() {
				if($(this).find(":selected").text() == 'Others') {
					$('#vacation_leave_specify').removeAttr('disabled', true);
				}
				else if($(this).find(":selected").val() != "") {
					$('#vacation_leave_specify').attr('disabled', true).val("");
				}
				$('.vl_location').removeAttr('disabled', true);
			}));

			$('.vl_location').click(function() {
				if($(this).is(':checked')) {
					$('#vacation_location_specify').removeAttr('disabled', true);
				}
			});

			// Disable SL & remove values
			$('#sl_specify').attr('disabled', true).val("");
			$('.sl_location').attr('disabled', true).prop('checked', false);
			$('#sick_leave_specify').attr('disabled', true).val("");
			$('#sick_location_specify').attr('disabled', true).val("");
		}
	});

	$('#sick_leave').click(function() {
		if($(this).is(':checked')) {
			$('#sl_specify').removeAttr('disabled', true);

			if($('#sl_specify').change(function() {
				if($(this).find(":selected").text() == 'Others') {
					$('#sick_leave_specify').removeAttr('disabled', true);
				}
				else if($(this).find(":selected").val() != "") {
					$('#sick_leave_specify').attr('disabled', true).val("");
				}
				$('.sl_location').removeAttr('disabled', true);
			}));

			$('.sl_location').click(function() {
				if($(this).is(':checked')) {
					$('#sick_location_specify').removeAttr('disabled', true);
				}
			});


			// Disable VL & remove values
			$('#vl_specify').attr('disabled', true).val("");
			$('.vl_location').attr('disabled', true).prop('checked', false);
			$('#vacation_leave_specify').attr('disabled', true).val("");
			$('#vacation_location_specify').attr('disabled', true).val("");
		}
	});

	$('#spl').click(function() {
		if($(this).is(':checked')) {
			// Disable SL & remove values
			$('#sl_specify').attr('disabled', true).val("");
			$('.sl_location').attr('disabled', true).prop('checked', false);
			$('#sick_leave_specify').attr('disabled', true).val("");
			$('#sick_location_specify').attr('disabled', true).val("");

			// Disable VL & remove values
			$('#vl_specify').attr('disabled', true).val("");
			$('.vl_location').attr('disabled', true).prop('checked', false);
			$('#vacation_leave_specify').attr('disabled', true).val("");
			$('#vacation_location_specify').attr('disabled', true).val("");
		}
	});

	var dates = [];
	$('body').on('change', '#dates', function() {
		var value 	= $(this).val();
		var newHTML = [];
		var closeBtn = '<button type="button btn-sm leave_delete" class="close" style="font-size: 12px"><span aria-hidden="true" class="text-white ml-1">&times;</span></button>';
		dates.push(value);
		$.each(dates, function(index, value) {
			newHTML.push('<span class="badge badge-primary pt-1" data-id='+value+'>'+value+closeBtn+'</span>');
		});
		
		$('#date_container').html(newHTML.join(" "));
		$('#date_container').on('click', 'button', function(e) {
			e.preventDefault();
			var deleted = $(this).parent().data('id');
			dates = jQuery.grep(dates, function(value) {
			  return value != deleted;
			});
			$(this).parent().remove();
			$('#leave_dates').val(dates);
		});
		$('#leave_dates').val(dates);
	});

	if(attendanceChart) {
		var date = $('#dashboard-date').val();
		$.ajax({
			url: '/api/charts/attendance/'+date,
			dataType: 'JSON',
			success: function(data) {
				renderChart(data);
			}
		});
	}

	if(pieChart) {
		var total = 0;
		var data = {
		    labels: ["Travel Order", "Offset", "Leave", "Office", "Work from Home"],
		    datasets: [{
		            fill: true,
		            backgroundColor: ['#28a745','#fd7e14', '#20c997', '#696969','#007bff'],
		            data: [$('#travelCount').text(), $('#offsetCount').text(), $('#leaveCount').text(), $('#officeCount').text(), $('#wfhCount').text()],
		    }]
		};

		renderPieChart(data, pieChart);
	}

	if(report) {
		var year = $('#year').val();
		var mod  = $('#module').val();

		$.ajax({
			url: '/api/report/'+year+'/'+mod,
			dataType: 'JSON',
			success: function(data) {
				renderReport(data, mod);
			}
		});
	}

	health_check();
});

function datepicker()
{
	var dateFormat = 'mm/dd/yy',
	from = $('#date').datepicker();
}

function resizeChosen()
{
	$(".chosen-container").each(function() {
    	$(this).attr('style', 'width: 100%');
   	});
}

function checked(id, className) 
{
    if($(id).is(':checked')) {
        $(className).prop('checked', true);
    }
    else {
        $(className).prop('checked', false);
    }
}

function date_range()
{
	var dateFormat = 'mm/dd/yy',
	from = $('#start_date').datepicker().on('change', function() {
	            to.datepicker('option', 'minDate', getDate(this));
	        }),
	to = $('#end_date').datepicker().on('change', function() {
	        from.datepicker('option', 'maxDate', getDate(this));
	    });
	function getDate(element) {
	    var date;
	    try {
	        date = $.datepicker.parseDate(dateFormat, element.value);
	    } catch( error ) {
	        date = null;
	    }
	    return date;
	}
}

function date_range_reservation()
{
	var origin = window.location.origin;
	var dateFormat = 'mm/dd/yy',
	from = $('#start_date').datepicker({
		onSelect: function(date) {
			getVehicles(from.val(), to.val());
		}
	}),
	to = $('#end_date').datepicker({
		onSelect: function(date) {
			getVehicles(from.val(), to.val());
		}
	});

	function getDate(element) {
	    var date;
	    try {
	        date = $.datepicker.parseDate(dateFormat, element.value);
	    } catch( error ) {
	        date = null;
	    }
	  return date;
	}

	$('#travel_order').click(function() {
		$('#travel_order').is(':checked') ? $('#include').load(origin+'/include/travel') : $('#include').html('');
	});
}

function getVehicles(from, to) 
{
	var route = $('#route').attr("value");
	$('#vehicles').html("");
	$.ajax({
		url: route,
		data: { start_date: from, end_date: to },
		dataType: 'JSON',
		success: function(data) {
			$.each(data, function(i, e) {
				if(e.group == null) {
					$('#vehicles').append("<a href='#' class='vehicles' value='"+e.id+"'><span class='badge badge-primary'>"+e.plate_number+"</span></a>"+" ");
				}
				else {
					$('#vehicles').append("<a href='#' class='vehicles' value='"+e.id+"'><span class='badge badge-primary'>"+e.plate_number+" - "+e.group.alias+"</span></a>"+" ");
				}
			});
		}
	}).done(function() {
		$('#vehicle_label').removeAttr('hidden');
		$('.vehicles').click(function() {
        	$('.badge').removeClass('badge-success').addClass('badge-primary');
        	$(this).find('span').removeClass('badge-primary').addClass('badge-success');
        	$('#plate_number').val($(this).text());
        	$('#vehicle_id').val($(this).attr('value'));
        });
	});
}

function renderPieChart(data, pieChart) {
	var myPieChart = new Chart(pieChart, {
		type: 'pie',
		data: data,
		options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: {
				position: 'bottom'
			},
			onClick: function(e) {
				var activePoints 	= myPieChart.getElementsAtEvent(e);
	        	var selectedIndex 	= activePoints[0]._index;
	        	var labels 			= this.data.labels[selectedIndex];
	        	if(labels == 'Travel Order') {
	        		$('#travelsModal').modal('show');
	        	}
	        	else if(labels == 'Offset') {
	        		$('#offsetModal').modal('show');
	        	}
	        	else if(labels == 'Work from Home') {
	        		$('#wfhModal').modal('show');
	        	}
	        	else if(labels == 'Office') {
	        		$('#officeModal').modal('show');
	        	}
	        	else if(labels == 'Leave') {
	        		$('#leaveModal').modal('show');
	        	}
			}
		}
	}); 
}

function renderChart(data) {
	var myChart = new Chart(attendanceChart, {
		type: 'bar',
		data: {
			labels: data['labels'],
			datasets: [{
				label: 'Work from Home',
				data: data['wfh'],
				backgroundColor: '#007bff',
			}, {
				label: 'Office',
				data: data['office'],
				backgroundColor: '#696969',
			}, {
				label: 'Travel',
				data: data['travels'],
				backgroundColor: '#28a745',
			}, {
				label: 'Offset',
				data: data['offset'],
				backgroundColor: '#fd7e14',
			}, {
				label: 'Leave',
				data: data['leave'],
				backgroundColor: '#20c997',
			}],
		},
		options: {
			legend: false,
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				xAxes: [{ stacked: true }],
				yAxes: [{ stacked: true }]
			},
	        onClick: function(e) {
	        	var activePoints = myChart.getElementAtEvent(event);

			    if (activePoints.length > 0) {
			    	var clickedDatasetIndex = activePoints[0]._datasetIndex;
			    	var clickedElementIndex = activePoints[0]._index;
			    	var clickedDatasetPoint = myChart.data.datasets[clickedDatasetIndex];
			    	var date 	= $('#dashboard-date').val();
			    	var label 	= clickedDatasetPoint.label;
			    	var unit 	= this.data.labels[clickedElementIndex];
			    	var url 		= '/charts/attendance/'+unit+'/'+label+'/'+date;
			       	$.get(url, function(data) {
						$('#formContainer').html(data);
			   			$('#chartModal').modal('show');
					});
			    }
	        }
    	}
	});
}

function renderReport(data, mod)
{
	var myChart = new Chart(report, {
		type: 'bar',
		data: {
			labels: data['labels'],
			datasets: [{
				label: (mod == 'Health Check' ? 'Health Declaration' : 'Approved'),
				data: data['approved'],
				backgroundColor: '#007bff',
			}, {
				label: (mod == 'Health Check' ? '' : 'Disapproved'),
				data: data['disapproved'],
				backgroundColor: (mod == 'Health Check' ? '#fff' : '#dc3545'),
			}],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				xAxes: [{ stacked: true }],
				yAxes: [{ stacked: true }]
			}
    	}
	});
}

function getChartData(array) {
    var a = [], b = [], prev;

    array.sort();
    for (var i = 0; i < array.length; i++) {
        if(array[i] !== prev) {
            a.push(array[i]);
            b.push(1);
        }
        else {
            b[b.length-1]++;
        }
        prev = array[i];
    }
    return [a, b];
}

function health_check()
{
	var yes = [];
	$('#no').click(function() {
		$('.no_class').prop('checked', true);
		healthDeclarationNo();
	});

	$.each($('.is_risky'), function(index, value) {
		var id = this.id;
		$("input[name="+id+"]").change(function() {
			if($('#'+id).is(':checked')) {
				yes.push(id);
			}
			else {
				yes = yes.filter(e => e !== id);
			}
			if(yes.length > 0) {
				healthDeclarationYes();
			}
			else {
				healthDeclarationNo();
			}
		});
	});

	$('.work_location').click(function() {
		contactTrace();
		$('#attendance_location').val($(this).val());
	});

}
function healthDeclarationYes()
{
	$('.work_location').prop('checked', false).prop('disabled', true);
	$('.mode_of_conveyance').prop('required', false);
	$('#home').prop('checked', true);
	$('#memo').removeClass('d-none').slideDown('slow');
	$('#attendance_location').val(0);
	$('#mode_of_conveyance, #vehicle_plate_number').slideUp("slow");
}

function healthDeclarationNo()
{
	$('.work_location').prop('checked', false).prop('disabled', false);
	$('#memo').slideUp("slow");
	$('#attendance_location').val("");
}

function contactTrace()
{
	if($('#office').is(':checked')) {
		$('.mode_of_conveyance').prop('required', true);
		$('#mode_of_conveyance').removeClass('d-none').slideDown('slow');
		$('.mode_of_conveyance').change(function() {
			officeVehicle();
		});
		officeVehicle();
	}
	else {
		$('.mode_of_conveyance').prop('required', false);
		$('#mode_of_conveyance').slideUp("slow");
		$('#vehicle_plate_number').slideUp("slow");
	}
}

function officeVehicle()
{
	if($('#office_vehicle, #carpool').is(':checked')) {
		$('#vehicle_plate_number').removeClass('d-none').slideDown('slow');
	}
	else {
		$('#vehicle_plate_number').slideUp("slow");
		$('#remarks').val("");
	}
}