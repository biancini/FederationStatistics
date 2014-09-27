var request_initiator_data, request_initiator_chart;

function draw_request_initiator() {
	$.ajax({
		url:      'modules/request_initiator/getstats.php',
		type:     'POST',
		dataType: 'json',
		success: function(data){
			//console.log(data);

			request_initiator_data = google.visualization.arrayToDataTable([
				['Request Initiator', 'Count', 'Details'],
				['Present', data["ok"].length, data["ok"]],
				['Absent',  data["ko"].length, data["ko"]]
			]);
			var options = {
				title: 'Request initiator stats for SPs',
				pieHole: 0.4,
				legend: { "position": "top" },
				titleTextStyle: { fontSize: 19 },
				fontName: "Helvetica",
				fontSize: 12,
			};
			request_initiator_chart = new google.visualization.PieChart(document.getElementById('request_initiator_graph'));
			request_initiator_chart.draw(request_initiator_data, options);
			google.visualization.events.addListener(request_initiator_chart, 'select', select_request_initiator);
		},
		error: function(data) {
			alert("Error while retrieving");
			console.log("Error while retrieving " + data);
		},
	});
}

function select_request_initiator() {
	var selectedItem = request_initiator_chart.getSelection()[0];
	$("#request_initiator_details").empty();

	if (selectedItem) {
		var value = request_initiator_data.getValue(selectedItem.row || 0, selectedItem.column || 0);
		var entities = request_initiator_data.getValue(selectedItem.row || 0, 2);
		//console.log('The user selected ' + value);

		var html = "<h3>List of all the " + value + " of the IDEM federation:</h3><ul>";
		for (var i = 0; i < entities.length; ++i) {
			html += "<li class='entitylist'><a href=\"#\" onclick=\"return show_entity(this, '" + entities[i]["id"] + "');\">" + entities[i]["name"] + "</a></li>";
		}
		html += "</ul>";

		$("#request_initiator_details").append(html);
	}

	document.getElementById('entityframe').innerHTML = '';
}
