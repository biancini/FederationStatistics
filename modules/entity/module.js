var entity_data, entity_chart;

function draw_entity() {
	$.ajax({
		url:      'getstats.php',
		type:     'POST',
		dataType: 'json',
		success: function(data){
			//console.log(data);

			entity_data = google.visualization.arrayToDataTable([
				['Entity Type', 'Count', 'Details'],
				['Identity Provider', data["idps"].length, data["idps"]],
				['Service Provider',  data["sps"].length, data["sps"]]
			]);
			var options = {
				title: 'IDEM entities by type',
				pieHole: 0.4,
				legend: { "position": "bottom" }
			};
			entity_chart = new google.visualization.PieChart(document.getElementById('entity_graph'));
			entity_chart.draw(entity_data, options);
			google.visualization.events.addListener(entity_chart, 'select', select_entity);
		},
		error: function(data) {
			alert("Error while retrieving");
			console.log("Error while retrieving " + data);
		},
	});
}

function select_entity() {
	var selectedItem = entity_chart.getSelection()[0];
	$("#entity_details").empty();

	if (selectedItem) {
		var value = entity_data.getValue(selectedItem.row || 0, selectedItem.column || 0);
		var entities = entity_data.getValue(selectedItem.row || 0, 2);
		//console.log('The user selected ' + value);

		var html = "<h3>List of all the " + value + " of the IDEM federation:</h3><ul>";
		for (var i = 0; i < entities.length; ++i) {
			html += "<li><a href=\"#\" onclick=\"show_entity('" + entities[i]["id"] + "');\">" + entities[i]["name"] + "</a></li>";
		}
		html += "</ul>";

		$("#entity_details").append(html);
	}
}

function show_entity(entityId) {
	var url = "../../getentity.php?id=" + entityId;
	$("#entityframe").attr('src', url);
}
