$(function () {
	
	$('#prefix').on("keyup",function () {
		$('#prefix-content').text($(this).val());
	});
	
	$('#suffix').on("keyup",function () {
		$('#suffix-content').text($(this).val());
	});
	
	/**
	 * Minutes settings
	 */
	$('#TriggerMinute-helper').on("change", function() {
		if (!$('#TriggerMinute-helper option:selected').text().startsWith('--')) {
			$('#TriggerMinute').val($('#TriggerMinute-helper').val().trim().replace(':',''));
		}
	});
	$('#TriggerMinute').on("change", function() {
		if ($("#TriggerMinute-helper option[value=':" + $('#TriggerMinute').val() + "']").val() != undefined) {
			$('#TriggerMinute-helper option[value=":' + $('#TriggerMinute').val() + '"]').prop('selected', true);
		} else {
			$('#TriggerMinute-helper option[value="0"]').prop('selected', true);
		}
	});
	
	/**
	 * Hours settings
	 */
	$('#TriggerHour-helper').on("change", function() {
		if (!$('#TriggerHour-helper option:selected').text().startsWith('--')) {
			$('#TriggerHour').val($('#TriggerHour-helper').val().trim().replace(':',''));
		}
	});
	$('#TriggerHour').on("change", function() {
		if ($("#TriggerHour-helper option[value=':" + $('#TriggerHour').val() + "']").val() != undefined) {
			$('#TriggerHour-helper option[value=":' + $('#TriggerHour').val() + '"]').prop('selected', true);
		} else {
			$('#TriggerHour-helper option[value="0"]').prop('selected', true);
		}
	});
	
	/**
	 * Days settings
	 */
	$('#TriggerDay-helper').on("change", function() {
		if (!$('#TriggerDay-helper option:selected').text().startsWith('--')) {
			$('#TriggerDay').val($('#TriggerDay-helper').val().trim().replace(':',''));
		}
	});
	$('#TriggerDay').on("change", function() {
		if ($("#TriggerDay-helper option[value=':" + $('#TriggerDay').val() + "']").val() != undefined) {
			$('#TriggerDay-helper option[value=":' + $('#TriggerDay').val() + '"]').prop('selected', true);
		} else {
			$('#TriggerDay-helper option[value="0"]').prop('selected', true);
		}
	});
	
	/**
	 * Month settings
	 */
	$('#TriggerMonth-helper').on("change", function() {
		if (!$('#TriggerMonth-helper option:selected').text().startsWith('--')) {
			$('#TriggerMonth').val($('#TriggerMonth-helper').val().trim().replace(':',''));
		}
	});
	$('#TriggerMonth').on("change", function() {
		if ($("#TriggerMonth-helper option[value=':" + $('#TriggerMonth').val() + "']").val() != undefined) {
			$('#TriggerMonth-helper option[value=":' + $('#TriggerMonth').val() + '"]').prop('selected', true);
		} else {
			$('#TriggerMonth-helper option[value="0"]').prop('selected', true);
		}
	});
	
	/**
	 * Week days settings
	 */
	$('#TriggerWeekday-helper').on("change", function() {
		if (!$('#TriggerWeekday-helper option:selected').text().startsWith('--')) {
			$('#TriggerWeekday').val($('#addtriggerWeekday-helper').val().trim().replace(':',''));
		}
	});
	$('#TriggerWeekday').on("change", function() {
		if ($("#TriggerWeekday-helper option[value=':" + $('#TriggerWeekday').val() + "']").val() != undefined) {
			$('#TriggerWeekday-helper option[value=":' + $('#TriggerWeekday').val() + '"]').prop('selected', true);
		} else {
			$('#TriggerWeekday-helper option[value="0"]').prop('selected', true);
		}
	});
	
	/**
	 * General common settings
	 */
	$('#TriggerCommon-settings').on("change", function() {
		cron = $('#TriggerCommon-settings').val().split(' ');
		$('#TriggerMinute').val(cron[0]);
		$('#TriggerMinute').trigger("change");
		$('#TriggerHour').val(cron[1]);
		$('#TriggerHour').trigger("change");
		$('#TriggerDay').val(cron[2]);
		$('#TriggerDay').trigger("change");
		$('#TriggerMonth').val(cron[3]);
		$('#TriggerMonth').trigger("change");
		$('#TriggerWeekday').val(cron[4]);
		$('#TriggerWeekday').trigger("change");
	});
	
});