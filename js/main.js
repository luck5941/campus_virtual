function loadList(lista,listado, listadoVal = null){            
	var listadoVal = (listadoVal == null) ? listado : listadoVal;
	var dentro = '<option class="grade" value="">'+lista+'</option>',
     	select = '<select id="grade">dentro</select>';
    for (var i = 0; i<listado.length; i++){     
        dentro += '<option value ="'+ listadoVal[i] +'" >' + listado[i] + '</option>'        
    }    
    var saw = select.replace('dentro', dentro) + '<select id="cursos"><option>Cursos</option></select><div class="radios"></div>';
    $('#notificaciones').append(saw)

};

function loadRadio(arr) {
	var txt = '';
	for (var i = 0; i<arr.length; i++){     
        txt += arr[i][2] +' '+arr[i][1]+ '<input type="radio" value ="'+ arr[i][0]+'_'+arr[i][1] +'" ></input>'+'<br>';
    }    
    
    $('#notificaciones .radios').html(txt);
}

var $radio = $(':radio'),
    flag = true
$radio.prop("checked", false)
$('body').on('click', ':radio', function(){
    flag = (flag) ? false : true
    $(this).prop("checked", flag)
})

$('a').click(function(e){
    if($(this).attr('href') == '#')
        e.preventDefault();
})

