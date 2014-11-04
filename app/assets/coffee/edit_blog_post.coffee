$('.blog').markdown {
  savable: yes
  onSave: (e) -> alert e.$textarea.attr("id")
}