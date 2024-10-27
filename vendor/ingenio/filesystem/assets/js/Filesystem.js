function selectRoute(route){
    //alert(route);
    document.getElementById('route').innerHTML = '<input type="hidden" name="route" value="'+route+'" />';
}
function showText(val){
   
    if(val==1){
        document.getElementById('content').style.display = "none";
        document.getElementById('btn-files').value = "OPEN FILE";
    }

    if(val==2){
        document.getElementById('content').style.display = "block";
        document.getElementById('btn-files').value = "SAVE FILE";
    }
}
function showRem(){   
    $('.btn-file').toggle();
    if($('#form-direc').css('display') == 'none'){
        $('#form-direc').css({'display':'inline-block'})
        $('#alert-route').css({'display':'none'}); 
    }
    else
    {
        $('#form-direc').css({'display':'none'})
        $('#alert-route').css({'display':'inline-block'}); 
    }
    
    
}
function showInput(route,file){
    var val = $('#btn-rename-'+file).css('display');
 
    if(val == 'none'){
        $('#span-'+file).css({'display':'none'}) 
        $('#btn-rename-'+file).css({'display':'inline-block'})
    }
    else
    {        
        $('#span-'+file).css({'display':'inline-block'}) 
        $('#btn-rename-'+file).css({'display':'none'})
    }
   
}
function hideInput(file){
  
    $('#span-'+file).css({'display':'inline-block'}) 
    $('#btn-rename-'+file).css({'display':'none'})
}
function rename(newn,complete_route,route){
    Data = {
        'new':newn,
        'complete_route':complete_route,
        'route':route,
        'action':'RENAME_FILE'
    }
    $.post('controller/controller.php',Data,function(res){
        resp = JSON.parse(res);
        if(resp.val == true){
            $('#res').html('<div class="alert alert-success">'+resp.msn+'</div>')
        }
        else
        {
            $('#res').html('<div class="alert alert-success">'+resp.msn+'</div>')
        }
        startCounter()
    })
}
function removeDir(complete_route){
    Data = {
        'complete_route':complete_route,
        'action':'DELETE_DIR'
    }
    $.post('controller/controller.php',Data,function(res){
        resp = JSON.parse(res);
        if(resp.val == true){
            $('#res').html('<div class="alert alert-success">'+resp.msn+'</div>')
        }
        else
        {
            $('#res').html('<div class="alert alert-success">'+resp.msn+'</div>')
        }
        startCounter()
    })

}
function removeFile(complete_route){
    alert("hi");
    Data = {
        'complete_route':complete_route,
        'action':'DELETE_FILE'
    }
    $.post('controller/controller.php', Data, function(res){
        resp = JSON.parse(res);
         
        if(resp.val == true){
            $('#res').html('<div class="alert alert-success">'+resp.msn+'</div>')
        }
        else
        {
            $('#res').html('<div class="alert alert-success">'+resp.msn+'</div>')
        }
        startCounter(); 
    })

}
function startCounter() {
   
        setTimeout(() => {
            location.reload();  
        }, 4000);
   
}

function selectFile(routew,route, file){    
    $('#namefile').val(file)
    $('#routefile').val(route)
    //alert(routew+file);
    //alert(route+file);
    if(isPic(file)){
        $('#pic-view').attr('src',routew+file)
        $('#view_data').html("")
    }
}
function isPic(nameF) {
    // Regular expression that it checks the common picture's extensions
    const allowedExt = /\.(jpg|jpeg|png|gif|bmp|webp|tiff|raw)$/i;
    
    // It returns true if the file's name checks with the picture's extension
    return allowedExt.test(nameF);
}
let draggedElement = null; // Variable to save the dragged element
// Event that it's triggered when the drag starts.
function dragStartHandler(event) {
    draggedElement = event.target; // Guardamos el elemento que está siendo arrastrado
    event.dataTransfer.effectAllowed = 'move'; // Permitimos el movimiento
    event.target.style.opacity = 0.5; // Cambiamos la opacidad del elemento arrastrado
}
// Event that it's triggered when the element is on an area that it can drop
function dragOverHandler(event) {
    event.preventDefault(); // Necesario para permitir el drop
    event.dataTransfer.dropEffect = 'move'; // Definimos el tipo de acción (mover)
}
// Event that it's triggered when the element is dropped
function dropHandler(event) {
    event.preventDefault();

    // If the element isn't the same that we are dragged, we proceed to move
    if (draggedElement !== event.target) {
        // Insert the moved element before the dropped one
        if (event.target.tagName === 'LI') {
            event.target.parentNode.insertBefore(draggedElement, event.target.nextSibling);
        }
    }
    
    // Restore the dragged element's style
    draggedElement.style.opacity = 1;
    draggedElement = null; // Clean the reference to the dragged element
}