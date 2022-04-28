function salas(A) {
    var mud = document.getElementById('salas' + A);

    switch (A) {
        case 1:
            mud.style.display = 'block';
            document.getElementById('salas2').style.display = 'none';
            document.getElementById('salas3').style.display = 'none';
            document.getElementById('salas4').style.display = 'none';
            document.getElementById('salas5').style.display = 'none';
            document.getElementById('legend').innerHTML = 'BLOCO B - 1º ANDAR';
            break;
        case 2:
            mud.style.display = 'block';
            document.getElementById('salas1').style.display = 'none';
            document.getElementById('salas3').style.display = 'none';
            document.getElementById('salas4').style.display = 'none';
            document.getElementById('salas5').style.display = 'none';
            document.getElementById('legend').innerHTML = 'BLOCO B - TÉRREO';
            break;
        case 3:
            mud.style.display = 'block';
            document.getElementById('salas1').style.display = 'none';
            document.getElementById('salas2').style.display = 'none';
            document.getElementById('salas4').style.display = 'none';
            document.getElementById('salas5').style.display = 'none';
            document.getElementById('legend').innerHTML = 'BLOCO C - 1º ANDAR';
            break;
        case 4:
            mud.style.display = 'block';
            document.getElementById('salas1').style.display = 'none';
            document.getElementById('salas2').style.display = 'none';
            document.getElementById('salas3').style.display = 'none';
            document.getElementById('salas5').style.display = 'none';
            document.getElementById('legend').innerHTML = 'BLOCO C - EXTENÇÃO';
            break;
        case 5:
            mud.style.display = 'block';
            document.getElementById('salas1').style.display = 'none';
            document.getElementById('salas2').style.display = 'none';
            document.getElementById('salas3').style.display = 'none';
            document.getElementById('salas4').style.display = 'none';
            document.getElementById('legend').innerHTML = 'BLOCO C - TÉRREO';
            break;
        default:

    }
}

function add_sala(){
    document.getElementById("form-sala").style.display="block"
}
function remove_sala(){
    document.getElementById("form-sala").style.display="none"
}