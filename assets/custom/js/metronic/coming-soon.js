var ComingSoon = function () {

    return {
        //main function to initiate the module
        init: function () {
            var austDay = new Date();
            austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
            $('#defaultCountdown').countdown({until: austDay});
            $('#year').text(austDay.getFullYear());
			
			//check if localhost development or production live
			if (window.location.origin == "http://localhost") {
				$.backstretch([
						window.location.origin + "/Websites/acode/assets/metronic/assets/pages/media/bg/1.jpg",
						window.location.origin + "/Websites/acode/assets/metronic/assets/pages/media/bg/2.jpg",
						window.location.origin + "/Websites/acode/assets/metronic/assets/pages/media/bg/3.jpg",
						window.location.origin + "/Websites/acode/assets/metronic/assets/pages/media/bg/4.jpg"
					], {
					fade: 1000,
					duration: 10000
				});
			} else {
				$.backstretch([
						window.location.origin + "/assets/metronic/assets/pages/media/bg/1.jpg",
						window.location.origin + "/assets/metronic/assets/pages/media/bg/2.jpg",
						window.location.origin + "/assets/metronic/assets/pages/media/bg/3.jpg",
						window.location.origin + "/assets/metronic/assets/pages/media/bg/4.jpg"
					], {
					fade: 1000,
					duration: 10000
				});
			}
        }

    };

}();

jQuery(document).ready(function() {    
   ComingSoon.init(); 
});