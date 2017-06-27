$(function(){
$('.carousel').flickity({
  // options
  cellAlign: 'left',
  wrapAround: dotclear_wrap_arround,
  autoPlay:dotclear_flickity_play,
  freeScroll: true,
  contain: true,
  watchCSS:true,
  pageDots: dotclear_page_dots,
  prevNextButtons: dotclear_prev_next,
  selectedAttraction: 0.02,
  friction: 0.4
});
});