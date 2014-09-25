var info_page_data, info_page_chart;

function draw_info_page() {
	$.ajax({
		url:      'getstats.php',
		type:     'POST',
		dataType: 'json',
		success: function(data){
			//console.log(data);

			info_page_data = google.visualization.arrayToDataTable([
				['Info Page', 'Count', 'Details'],
				['No Page', data["zero"].length, data["zero"]],
				['Only Italian',  data["only_it"].length, data["only_it"]],
				['Only English',  data["only_en"].length, data["only_en"]],
				['Both Languages',  data["ok"].length, data["ok"]],
			]);
			var options = {
				title: 'Information Pages stats',
				pieHole: 0.4,
				legend: { "position": "bottom" }
			};
			info_page_chart = new google.visualization.PieChart(document.getElementById('info_page_graph'));
			info_page_chart.draw(info_page_data, options);
			google.visualization.events.addListener(info_page_chart, 'select', select_info_page);
		},
		error: function(data) {
			alert("Error while retrieving");
			console.log("Error while retrieving " + data);
		},
	});
}

function select_info_page() {
	var selectedItem = info_page_chart.getSelection()[0];
	$("#info_page_details").empty();

	if (selectedItem) {
		var value = info_page_data.getValue(selectedItem.row || 0, selectedItem.column || 0);
		var entities = info_page_data.getValue(selectedItem.row || 0, 2);
		//console.log('The user selected ' + value);

		var html = "<h3>List of entities with " + value + ":</h3><ul>";
		for (var i = 0; i < entities.length; ++i) {
			html += "<li><a href=\"#\" onclick=\"show_entity('" + entities[i]["id"] + "');\">" + entities[i]["name"] + "</a></li>";
		}
		html += "</ul>";

		$("#info_page_details").append(html);
	}
}

function show_entity(entityId) {
        var url = "../../getentity.php?id=" + entityId;
        $("#entityframe").attr('src', url);
}
