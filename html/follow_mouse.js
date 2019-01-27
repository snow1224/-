function YY_Mousetrace(event) {

    yy_ml=(event.clientX + document.body.scrollLeft);
    yy_mt=(event.clientY + document.body.scrollTop);
    document.querySelector('#cursor').style.left=yy_ml+10+"px";
    document.querySelector('#cursor').style.top=yy_mt+10+"px";
}

document.addEventListener('mousemove',YY_Mousetrace);
