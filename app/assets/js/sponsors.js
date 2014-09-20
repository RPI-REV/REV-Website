$(".sponsor").click(function() {
    if (this.attr("link") !== '') {
        window.location.replace(this.attr("link"));
    }
});