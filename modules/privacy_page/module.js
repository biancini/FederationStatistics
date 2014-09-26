var privacy_page_data, privacy_page_chart;

function draw_privacy_page() {
	$.ajax({
		url:      'modules/privacy_page/getstats.php',
		type:     'POST',
		dataType: 'json',
		success: function(data){
			//console.log(data);

			privacy_page_data = google.visualization.arrayToDataTable([
				['Privacy Page', 'Count', 'Details'],
				['No Page', data["zero"].length, data["zero"]],
				['Only Italian',  data["only_it"].length, data["only_it"]],
				['Only English',  data["only_en"].length, data["only_en"]],
				['Both Languages',  data["ok"].length, data["ok"]],
			]);
			var options = {
				title: 'Privacy Pages stats',
				pieHole: 0.4,
				legend: { "maxLines": 2, "position": "top" }
			};
			privacy_page_chart = new google.visualization.PieChart(document.getElementById('privacy_page_graph'));
			privacy_page_chart.draw(privacy_page_data, options);
			google.visualization.events.addListener(privacy_page_chart, 'select', select_privacy_page);
		},
		error: function(data) {
			alert("Error while retrieving");
			console.log("Error while retrieving " + data);
		},
	});
}

function select_privacy_page() {
	var selectedItem = privacy_page_chart.getSelection()[0];
	$("#privacy_page_details").empty();

	if (selectedItem) {
		var value = privacy_page_data.getValue(selectedItem.row || 0, selectedItem.column || 0);
		var entities = privacy_page_data.getValue(selectedItem.row || 0, 2);
		//console.log('The user selected ' + value);

		var html = "<h3>List of entities with " + value.toLowerCase() + ":</h3><ul>";
		for (var i = 0; i < entities.length; ++i) {
			html += "<li class='entitylist'><a href=\"#\" onclick=\"return show_entity(this, '" + entities[i]["id"] + "');\">" + entities[i]["name"] + "</a></li>";
		}
		html += "</ul>";

		$("#privacy_page_details").append(html);
	}

	document.getElementById('entityframe').innerHTML = '';
}

function show_entity(entitylist, entityId) {
	$('.entitylist').removeClass('highlight');
	entitylist.className = 'highlight entitylist';

	$.ajax({
		url: "getentity.php?id=" + entityId,
		success: function(data) {
			var brush = new SyntaxHighlighter.brushes.Xml();
			brush.init({ toolbar: false });
			var html = brush.getHtml(data);
			document.getElementById('entityframe').innerHTML = html;
		}
	});
	return false;
}
