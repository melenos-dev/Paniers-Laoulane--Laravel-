$('input[type="search"]').hover(function() {
	this.focus();
});

$(".search").on("click", function (e) {
	e.preventDefault();
	//$('input[type="search"]').addClass('searchS');
});