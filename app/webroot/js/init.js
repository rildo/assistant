$(function () {
	$('[data-toggle="tooltip"]').tooltip();

	// Quick Notification
	$("#deleteAllNotification").on("click", function (e) {
		e.preventDefault();
		var btn = $(this);
		$.post($(this).attr("href"), function () {
			$(".notifBadgeZone .badge.important").fadeOut(function () {
				$(this).remove();
			});
			$(".notification").fadeOut(function () {
				$(this).remove();
			});
			btn.fadeOut(function() {
				$(this).remove();	
			});
		});
		return false;
	});
	
	//Rechargement de la liste des notfications
	$(".user-details").on("click", function() {
		var url = $("#user-notification").attr("href");
		$.get(url, function(msg) {
			$("#listNotification").html(msg);
		});
	});
	
	//Verifie les badges notifications toutes les 30 secondes
	function getCountNotRead() {
		var url = $("#countNotRead").attr("href");
		$.get(url, function(nb) {
			if (nb>0) {
				$(".notifBadgeZone").each(function() {
					var badge = $(this).children(".badge.important");
					if (badge.length==0) {
						$(this).append("<span class=\"badge important\">"+nb+"</span>");
					}
					else {
						badge.html(nb);
					}
				});
			}
		});
	}
	// Récurence toutes les 30 secondes
	setInterval(getCountNotRead, 30000);
	// Verification rapide au bout de deux secondes
	setTimeout(getCountNotRead, 2000);
});