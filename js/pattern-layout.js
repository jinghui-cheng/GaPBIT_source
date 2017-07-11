function adjustWellHeights() {
  if ($(window).width() >= 992) {
    $('#pattern-section-problem').height('auto');
    $('#pattern-section-solution').height('auto');
    var maxHeight = Math.max($('#pattern-section-problem').height(), $('#pattern-section-solution').height());
    $('#pattern-section-problem').height(maxHeight);
    $('#pattern-section-solution').height(maxHeight);
    $('#pattern-secton-related-patterns').height($('#pattern-summary').height() - parseInt($(".pattern-section").css("margin-bottom")));
  } else if ($(window).width() >= 768) {
    $('#pattern-section-problem').height('auto');
    $('#pattern-section-solution').height('auto');
    $('#pattern-secton-related-patterns').height($('#pattern-summary').height() - parseInt($(".pattern-section").css("margin-bottom")));
  } else {
    $('#pattern-section-problem').height('auto');
    $('#pattern-section-solution').height('auto');
    $('#pattern-secton-related-patterns').height('auto');
  }
}

function adjustTherapistCommentHeights() {
  if ($(window).width() >= 768) {
    $.each($('.example-game-detailed-info'), function (key, value) {
      var diff = $(value.parentElement).children('.example-game-graph').height() -
                  $(value.parentElement).children('.example-game-detailed-info').height();
      if (diff > 0) {
        $(value.parentElement).children('.example-game-detailed-info').children('.therapist-comments-well').height(
          $(value.parentElement).children('.example-game-detailed-info').children('.therapist-comments-well').height() + diff
        );
      }
    });
  }
}

function adjustTopPadding() {
  var padingtop = $('.pattern-basic-info').height();
  $('.container').css('padding-top', padingtop+'px');
}

$(document).ready(function(){
  //adjust layout
  adjustWellHeights();
  adjustTherapistCommentHeights();
  adjustTopPadding();

  var scroll_start = 0;
  var startchange = $('.container');
  var offset = startchange.offset();
  if (startchange.length){
    $(document).scroll(function() {
      scroll_start = $(this).scrollTop();
      if(scroll_start > offset.top-50) {
        $(".pattern-basic-info").addClass('scrolled-down');
      } else {
        $('.pattern-basic-info').removeClass('scrolled-down');
      }
   });
  }

  //Tooltip for touch screens
	var toolOptions;
	var toolOptions2;
	var isOS = /iPad|iPhone|iPod/.test(navigator.platform);
	var isAndroid = /(android)/i.test(navigator.userAgent);

	if (isOS){
		$("[data-toggle=tooltip]").tooltip();

		$("[data-toggle=tooltip]").css( 'cursor', 'pointer' );
		 $('body').on("touchstart", function(e){
			$("[data-toggle=tooltip]").each(function () {
				// hide any open tooltips when the anywhere else in the body is clicked
				if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.tooltip').has(e.target).length === 0) {
					$(this).tooltip('hide');
				}////end if
			});
		});
	} else {
		$("[data-toggle=tooltip]").tooltip();
	}
});

$(window).on('resize', function() {
  adjustWellHeights();
  adjustTherapistCommentHeights();
  adjustTopPadding();
});

$(".collapse-example-game").on("show.bs.collapse", function(e) {
	$(this).siblings(".panel-heading").children("a").children("i").removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
});

$(".collapse-example-game").on("hide.bs.collapse", function(e) {
	$(this).siblings(".panel-heading").children("a").children("i").removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
});

$(".collapse-example-game").on("shown.bs.collapse", function(e) {
  adjustTherapistCommentHeights();
});
