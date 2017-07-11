function changeViewTo(view) {
  $('#view-by-goal').addClass("hide");
  $('#view-by-name').addClass("hide");
  $('#view-by-category').addClass("hide");
  $('#view-by-relation').addClass("hide");

  switch (view) {
    case "goal":
      $('#view-by-goal').removeClass("hide");
      $('.btn-expand-all').removeClass("hide");

      if ($('#view-by-goal-expanded').hasClass('hide')) {
        $('.btn-expand-all').html('Expand All');
      } else {
        $('.btn-expand-all').html('Collapse All');
      }

      break;
    case "name":
      $('#view-by-name').removeClass("hide");
      $('.btn-expand-all').addClass("hide");
      break;
    case "category":
      $('#view-by-category').removeClass("hide");
      $('.btn-expand-all').removeClass("hide");

      if ($('#view-by-category-expanded').hasClass('hide')) {
        $('.btn-expand-all').html('Expand All');
      } else {
        $('.btn-expand-all').html('Collapse All');
      }

      break;
    case "relation":
      $('#view-by-relation').removeClass("hide");
      $('.btn-expand-all').addClass("hide");

      //for the relationship image
      $('img[usemap]').rwdImageMaps();
      $('img[usemap]').maphilight();
      break;
    default:
      break;
  }
}

$('.btn-expand-all').on("click", function(){
  var view = $('#sel-view-by').val();
  var target = "";
  switch (view) {
    case "goal":
      target = "view-by-goal";
      break;
    case "category":
      target = "view-by-category";
      break;
    default:
      break;
  }

  if ($(this).html() == "Expand All") {
    $('#'+target+'-collapsed').addClass('hide');
    $('#'+target+'-expanded').removeClass('hide');
    $(this).html('Collapse All');
  } else {
    $('#'+target+'-collapsed').removeClass('hide');
    $('#'+target+'-expanded').addClass('hide');
    $(this).html('Expand All');
  }
});

$(window).load(function () {
    view = $('#sel-view-by').val();
    changeViewTo (view);
});

$('#sel-view-by').change(function () {
    view = $('#sel-view-by').val();
    changeViewTo (view);
});

//for the relationship image
jQuery(window).bind('resize', function(e)
{
    window.resizeEvt;
    jQuery(window).resize(function()
    {
        clearTimeout(window.resizeEvt);
        window.resizeEvt = setTimeout(function()
        {
            jQuery('img[usemap]').maphilight();
        }, 250);
    });
});
