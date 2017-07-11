$('.pattern-clickable').on("click", function(e){
  if (e.target.nodeName != "A" && e.target.nodeName != "BUTTON") {
    window.location.href = "pattern.php?id=" + this.id;
  }
});
