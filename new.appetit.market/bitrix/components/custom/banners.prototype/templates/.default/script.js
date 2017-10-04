$(document).ready(function() {
	function isLocalStorageAvailable() {
  		try {
    		return 'localStorage' in window && window['localStorage'] !== null;
  		} catch (e) {
    		return false;
  		}
	}

	if ($('#banner-popup').length && isLocalStorageAvailable())
	{
		var name = 'banner-popup-show';
		if (localStorage.getItem(name) != 1) {
			setTimeout(function() {
				localStorage.setItem(name, 1);
				$.fancybox('#banner-popup');
			}, 15000);
		} else {
			$('#banner-popup').remove();
		}
	}
});