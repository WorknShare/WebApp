$(function() {
	
	var colorPalette = ['#ff4444','#ffbb33','#00C851','#33b5e5','#2BBBAD', '#4285F4', '#aa66cc'];

	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1;
	var yyyy = today.getFullYear(); 

	$('.input-daterange').daterangepicker({
		locale: {
			"daysOfWeek": ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
			"monthNames": ["janv.", "févr.", "mars", "avril", "mai", "juin", "juil.", "août", "sept.", "oct.", "nov.", "déc."],
			"separator": " - ",
	        "applyLabel": "Appliquer",
	        "cancelLabel": "Annuler",
	        "fromLabel": "De",
	        "toLabel": "à",
	        "customRangeLabel": "Personnalisé",
			"format": "DD/MM/YYYY",
			"firstDay":1
		},
		startDate: dd + '/' + mm + '/' + yyyy,
		endDate: dd + '/' + mm + '/' + yyyy,
	});

	$( document ).ready(function() {
    	$.refreshPlansPie();
    	$.refreshPlans();
	});


	//-------------------------------
	//PLANS PIE
	//-------------------------------

	var pieOptions = {
		segmentShowStroke    : true,
		segmentStrokeColor   : '#fff',
		segmentStrokeWidth   : 1,
		percentageInnerCutout: 50,
		animationSteps       : 100,
		animationEasing      : 'easeOutBounce',
		animateRotate        : true,
		animateScale         : false,
		responsive           : true,
		maintainAspectRatio  : false,
		legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
		tooltipTemplate      : '<%=label%>: <%=value %> clients'
	};
	var pieChart;

	$("#refreshPlansPie").click(function() {
		$.refreshPlansPie();
	});

	$.refreshPlansPie = function() {
		var url = $("#plansPie").data('url');
		$.ajax({
			method: 'GET',
			url: url,
				data: '',
				dataType: "json"
			})
			.done(function(data) {
				$.updatePlansPie(data.plans);
			})
			.fail(function(data) {
				$.alert('error', 'Une erreur est survenue. Impossible de récupérer les statistiques demandées');
			});
	}

	$.updatePlansPie = function(data) {

		$("#planPieNotEnoughData").hide();

		var pieChartCanvas = $('#plansPie').get(0).getContext('2d');
		if(pieChart == undefined) {
			pieChart = new Chart(pieChartCanvas);
		}
		var pieData = [];

		//Clear legend
		var legend = $('#plansPieLegend');
		legend.empty();

		//Set pie size
		pieChartCanvas.canvas.height = 150;
		pieChartCanvas.canvas.style.height = "150px";

		var i = 0;
		var ok = false;
		$.each(data, function(i, item) {
			if(item.users_count > 0) ok = true;
			var color = colorPalette[i%colorPalette.length];
			pieData.push({value: item.users_count, color: color, highlight: color, label: item.name});
			if(ok)
				legend.append('<li><i class="fa fa-circle-o" style="color:'+ color +'"></i> '+ item.name +'</li>');
			i++;
		});

		pieChart.Doughnut(pieData, pieOptions);

		if(data.length <= 0 || !ok) {
			$("#planPieNotEnoughData").show();
		}

	}

	//-------------------------------


	//-------------------------------
	//PLANS
	//-------------------------------

	var plansOptions = {
		    showScale               : true,
		    scaleShowGridLines      : false,
		    scaleGridLineColor      : 'rgba(0,0,0,.05)',
		    scaleGridLineWidth      : 1,
		    scaleShowHorizontalLines: true,
		    scaleShowVerticalLines  : true,
		    bezierCurve             : true,
		    bezierCurveTension      : 0.3,
		    pointDot                : false,
		    pointDotRadius          : 4,
		    pointDotStrokeWidth     : 1,
		    pointHitDetectionRadius : 20,
		    datasetStroke           : true,
		    datasetStrokeWidth      : 2,
		    datasetFill             : false,
		    legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
		    maintainAspectRatio     : false,
		    responsive              : true
		};
	var plansChart;

	$("#refreshPlans").click(function() {
		$.refreshPlans();
	});

	$('#daterangePlans').on('apply.daterangepicker', function(ev, picker) {
		$.refreshPlans();
	});

	$.refreshPlans = function() {
		var url = $("#plans").data('url');
		var picker = $("#daterangePlans").data('daterangepicker');
		$.ajax({
			method: 'GET',
			url: url,
				data: 'date_start=' + picker.startDate.format('YYYY-MM-DD') + "&date_end=" + picker.endDate.format('YYYY-MM-DD'),
				dataType: "json"
			})
			.done(function(data) {
				$.updatePlans(data);
			})
			.fail(function(data) {
				$.alert('error', 'Une erreur est survenue. Impossible de récupérer les statistiques demandées');
			});
	}

	$.updatePlans = function(data) {

		$("#planNotEnoughData").hide();

		var planChartCanvas = $('#plans').get(0).getContext('2d');
		
		//Clear
		var legend = $('#plansLegend');
		legend.empty();

		var i = 0;
		$.each(data.datasets, function(i, item) {
			var color = colorPalette[i%colorPalette.length];
			item.strokeColor = color;
			item.pointColor = color;
			legend.append('<li><i class="fa fa-circle-o" style="color:'+ color +'"></i> '+ item.label +'</li>');
			i++;
		});

		if(plansChart != undefined) {
			plansChart.destroy();
			plansChart = undefined;
		} 
			
			plansChart = new Chart(planChartCanvas, {
				type: 'line',
				data: data
			});


		if(data.datasets.length <= 0) {
			$("#planNotEnoughData").show();
		}

		plansChart = plansChart.Line(data, plansOptions);

	}

	//-------------------------------

});