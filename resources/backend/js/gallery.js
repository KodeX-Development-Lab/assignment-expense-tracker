var btn = document.querySelector('.add');
var remove = document.querySelector('.draggable');
 
function dragStart(e) {
  dragSrcEl = this;
  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.innerHTML);
};
 
function dragEnter(e) {
  this.classList.add('over');
}
 
function dragLeave(e) {
  e.stopPropagation();
  this.classList.remove('over');
}
 
function dragOver(e) {
  e.preventDefault();
  e.dataTransfer.dropEffect = 'move';
  return false;
}
 
function dragDrop(e) {
  if (dragSrcEl != this) {
    dragSrcEl.innerHTML = this.innerHTML;
    this.innerHTML = e.dataTransfer.getData('text/html');
  }
  var values = $("input[name='image_order[]']")
              .map(function(){
                console.log( $(this).val());
                return $(this).val();
              }).get().join(',')
  $('#thumbnail3').val(values);
  return false;
}
 
function dragEnd(e) {
  console.log("D END")
  var listItens = document.querySelectorAll('.draggable');
  [].forEach.call(listItens, function(item) {
    item.classList.remove('over');
    item.style.opacity = '1';
  });
  
}
  function addEventsDragAndDrop(el) {
    el.addEventListener('dragstart', dragStart, false);
    el.addEventListener('dragenter', dragEnter, false);
    el.addEventListener('dragover', dragOver, false);
    el.addEventListener('dragleave', dragLeave, false);
    el.addEventListener('drop', dragDrop, false);
    el.addEventListener('dragend', dragEnd, false);
  }
   
  var listItens = document.querySelectorAll('.draggable');
  [].forEach.call(listItens, function(item) {
    console.log(item);
    addEventsDragAndDrop(item);
  });

  function removeGImage(e){
    e.parentElement.parentElement.remove();
    var values = $("input[name='image_order[]']")
    .map(function(){
      console.log( $(this).val());
      return $(this).val();
    }).get().join(',')
    $('#thumbnail3').val(values);
  }