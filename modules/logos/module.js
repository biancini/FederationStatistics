var logos_data, logos_chart;

function draw_logos() {
	$.ajax({
		url:      'modules/logos/getstats.php',
		type:     'POST',
		dataType: 'json',
		success: function(data){
			//console.log(data);

			logos_data = google.visualization.arrayToDataTable([
				['Logos', 'Count', 'Details'],
				['OK', data["ok"].length, data["ok"]],
				['Miss Language',  data["miss_lang"].length, data["miss_lang"]],
				['Miss Size',  data["miss_size"].length, data["miss_size"]],
				['Wrong Logoes',  data["ko"].length, data["ko"]],
			]);
			var options = {
				title: 'Logos stats for IdPs',
				pieHole: 0.4,
				legend: { "maxLines": 2, "position": "top" }
			};
			logos_chart = new google.visualization.PieChart(document.getElementById('logos_graph'));
			logos_chart.draw(logos_data, options);
			google.visualization.events.addListener(logos_chart, 'select', select_logos);
		},
		error: function(data) {
			alert("Error while retrieving");
			console.log("Error while retrieving " + data);
		},
	});
}

function select_logos() {
	var selectedItem = logos_chart.getSelection()[0];
	$("#logos_details").empty();

	if (selectedItem) {
		var value = logos_data.getValue(selectedItem.row || 0, selectedItem.column || 0);
		var entities = logos_data.getValue(selectedItem.row || 0, 2);
		//console.log('The user selected ' + value);

		var html = "<h3>List of entities with " + value.toLowerCase() + ":</h3><ul>";
		for (var i = 0; i < entities.length; ++i) {
			html += "<li class='entitylist'><a href=\"#\" onclick=\"return show_entity(this, '" + entities[i]["id"] + "');\">" + entities[i]["name"] + "</a></li>";
		}
		html += "</ul>";

		$("#logos_details").append(html);
	}

	document.getElementById('entityframe').innerHTML = '';
}
