// JavaScript Document click poster to play
$('.video').on('click', function(e) {
  if (!navigator.userAgent.match(/firefox/i)) {
    if (this.paused) {
      this.play();
    } else {
      this.pause();
    }
  }
});
