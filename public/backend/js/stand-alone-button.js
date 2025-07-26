(function( $ ){

    $.fn.filemanager = function(type, options) {
      type = type || 'file';

      console.log(type,"File Type");
  
      this.on('click', function(e) {
        var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
        var target_input = $('#' + $(this).data('input'));
        var lfmImageInput = $(this).data('input');
        var lfmPtype  = $(this).data('ptype');
        var target_preview = $('#' + $(this).data('preview'));
        var deviceimg =$(this).data('device');
        var mh = deviceimg == "m" ? 16 : 5;
         

        window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
        window.SetUrl = function (items) {
          var allfiles = "";
          var file_path = items.map(function (item) {
            return item.url;
          }).join(',');
  
          const ofile = target_input.val();
          if(ofile && type == "gallery"){
             allfiles = ofile+","+file_path
          }else{
            allfiles = file_path;
          }

          console.log(allfiles,"all files");
          // set the value of the desired input to image url
          target_input.val('').val(allfiles).trigger('change');
  
          // clear previous preview
          target_preview.html('');

          // set or change the preview image src
          allfiles.split(',').forEach(function (item,key) {
            let imgElement ="";
            if(lfmPtype != "g"){
              imgElement = "<div class='"+lfmImageInput+"lfmc"+key+"'><img src='"+item+"' style='height:"+mh+"rem;' class='lfmimage custom-image-input w-100'><div><button type='button' onclick='removeImage(\""+lfmImageInput+"\","+key+")' class='btn btn-sm btn-danger remove-image w-100' style='border-radius: 1px 1px 8px 8px;'>Remove</button></div></div>";
            }
            else{
              console.log("ag");
              imgElement += "<li class='draggable w-100 draggableItem"+key+" "+lfmImageInput+"lfmc"+key+"' draggable='true'>";
              imgElement += "<input type='hidden' name='image_order[]' value='"+item+"' id='galleryImage"+key+"'>";
              imgElement += "<img src='"+item+"' class='lfmimage w-100'><div><button type='button' onclick='removeGImage(this)' class='btn btn-sm btn-danger w-100' style='border-radius: 1px 1px 8px 8px;'>Remove</button><div><input type='radio' name='default_image' value='"+key+"'> Default Image</div></li>";
            }
            target_preview.append(imgElement);
          });
  
          var listItens = document.querySelectorAll('.draggable');
          [].forEach.call(listItens, function(item) {
             addEventsDragAndDrop(item);
          });
          // trigger change event
          target_preview.trigger('change');
        };
        return false;
      });
    }
  
  })(jQuery);
  

  function removeImage(tinput,index){
     let inputimgs = $('#'+tinput).val().split(',');
     console.log("Removed ",inputimgs);
     inputimgs.splice(0,1);
     $('.'+tinput+'lfmc'+index).remove();
     $('#'+tinput).val(inputimgs.join(','));
  }