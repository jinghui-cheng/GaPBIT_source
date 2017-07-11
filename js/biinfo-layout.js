/*function onWindowLoad() {
  if ($(window).width() > 992) {
    var maxHeight = Math.max($('#info-section-about').height(),
                              $('#info-section-why-game').height(),
                              $('#info-section-why-design').height());
    $('#info-section-about').height(maxHeight-20);
    $('#info-section-why-game').height(maxHeight-20);
    $('#info-section-why-design').height(maxHeight-20);
  }
}

window.onload = onWindowLoad;*/

$(".collapse-persona").on("show.bs.collapse", function(e) {
	$(this).siblings(".panel-heading").children("a").children("i").removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
});

$(".collapse-persona").on("hide.bs.collapse", function(e) {
	$(this).siblings(".panel-heading").children("a").children("i").removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
});

$(".info-section-collapse > .collapse").on("show.bs.collapse", function(e) {
	$(".info-section-collapse > .collapse").not(this).collapse('hide');
	if ($(window).width() > 992) {
		var contentHeight =
			parseInt($("#right-panel").css("height")) -
			4 * parseInt($(".info-section-collapse > .info-section-title").css("height")) -
			3 * (parseInt($(".info-section-collapse").css("margin-bottom")) + parseInt($(".info-section-collapse").css("margin-top")));
		$(this).children(".well").css("height", contentHeight+"px");
	} else {
		$('html, body').animate({
      scrollTop: $(this).offset().top
    }, 200);
	}
});

$(".info-section-collapse > .collapse").on("hide.bs.collapse", function(e) {
	$(".backLinkToAbout").addClass("hide");
});

$("#gdpInAboutTool").on("click", function(){
	$("#aboutPatterns").collapse("show");
	$("#backToAboutFromAboutPatterns").removeClass("hide");
});

$("#gbiInAboutTool").on("click", function(){
	$("#whyUseGames").collapse("show");
	$("#backToAboutFromWhyUseGames").removeClass("hide");
});

$(".backLinkToAbout").on("click", function(){
	$("#aboutThisTool").collapse("show");
});

$(window).load(function() {
	$("#aboutThisTool").collapse("show");
});
