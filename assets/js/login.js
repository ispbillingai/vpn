function load(){
    "use strict";
    document.getElementById('msg').style.display = 'block';
    setTimeout(function(){
        document.getElementById("sendForm").submit();
    }, 500);
}
function pass(){
    "use strict";
    if(document.getElementById('password').type === 'text'){
        document.getElementById('password').type = 'password';
        document.getElementById('btn_pass').innerHTML = '<i class="far fa-eye"></i>';
    }else{
        document.getElementById('password').type = 'text';
        document.getElementById('btn_pass').innerHTML = '<i class="far fa-eye-slash"></i>';
    }
}
function accepted(){
    "use strict";
    document.getElementById('accept').checked = true;
    $('.terms-conditions-modal-lg').modal('hide');
}