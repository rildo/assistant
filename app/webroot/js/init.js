$(function () {
	$('[data-toggle="tooltip"]').tooltip();

	/**
	 * Notification
	 */

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
	
	
	
	
	/**
	 * Film
	 */
	
	// Filtre 
	var filtre = {
		"filter_hd": false,
		"filter_sd": false,
		"filter_new": false
	};
	$("#filter_hd").click(function() {
		filtre["filter_sd"]=false;
		$("#filter_sd").removeClass("button-primary");
	});
	$("#filter_sd").click(function() {
		filtre["filter_hd"]=false;
		$("#filter_hd").removeClass("button-primary");
	});
	$(".filter").click(function(e) {
		e.preventDefault();
		var ref = $(this).attr("id");
		if (filtre[ref]===false) filtre[ref] = true;
		else filtre[ref] = false;
		$(this).toggleClass("button-primary");
		
		updateFiltre();
		return false;
	});
	
	function updateFiltre() {
		$('#film td').each(function () {
			var valid = true;
			if (filtre.filter_new && $(this).children(".new").length===0) valid=false;
			if (filtre.filter_hd && ($(this).children(".quality").length===0 || !$(this).children(".quality").html().match("HD"))) valid=false;
			if (filtre.filter_sd && ($(this).children(".quality").length===0 || $(this).children(".quality").html().match("HD"))) valid=false;
			if (valid) {
				$(this).show();
			}
			else {
				$(this).hide();
			}
		});
	}
	
	//Rechargement au scroll
	var check = false;
	$(window).scroll(function() {
		if ($("#film").length>0 && $("#nextFilm").length>0) {
			var source = "body";
			if (navigator.userAgent.match("Firefox")) source="html";
			if (!check && $(source).scrollTop()+$(window).height() > $(document).height()-200) {
				check = true;
				var url = $("#nextFilm").attr("href");
				if (typeof url != "undefined") {
					$.get(url, function(msg) {
						$("#nextFilm").parent().remove();
						$("#film").children("tbody").append(msg);
						check=false;
						updateFiltre();
					});
				}
			}
		}
	});
});