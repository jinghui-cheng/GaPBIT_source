function goback() {
  if (document.referrer.indexOf("pattern.php?id=") >= 0) {
    $.cookie("backFromURL", window.location.href);
  } else {
    $.cookie("backFromURL", "");
  }
  window.history.back();
}

function handleGoBack() {
  //continue going back until reaching a different URL
  if ($.cookie("backFromURL") !== null && $.cookie("backFromURL") !== "" &&
    $.cookie("backFromURL") == window.location.href) {
      goback();
  } else {
    $.cookie("backFromURL", "");
  }
}

window.addEventListener("pageshow", handleGoBack, false);

$('#go-back').on('click', function(e) {
  goback();
});
