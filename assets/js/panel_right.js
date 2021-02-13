! function(e) {
	"use strict";

	function t(t) {
		t ? e(".right-sidebar-mini").addClass("right-sidebar") : e(".right-sidebar-mini").removeClass("right-sidebar")
		t ? e("body").addClass("right-sidebar-close") : e("body").removeClass("right-sidebar-close")
	}
	e(document).ready(function() {
		var a = !1;
		t(a), e(document).on("click", ".right-sidebar-toggle", function() {
			t(a = !a)
		})
	})
}(jQuery);
