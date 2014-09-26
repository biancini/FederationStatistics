function updateMarker(moduleName) {
	$.ajax({
		url:      'modules/'+moduleName+'/getstats.php?view=marker',
		type:     'GET',
		dataType: 'json',
		success: function(data){
			console.log(data);
			$('#'+moduleName+'_marker').addClass(data);
		},
		error: function(data) {
			console.log("Error while retrieving marker for module " + moduleName);
		},
	});
}

function show_entity(entitylist, entityId) {
	$('.entitylist').removeClass('highlight');
	entitylist.className = 'entitylist highlight';

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
