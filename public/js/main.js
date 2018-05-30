var canv;

function init(){
	canv = document.getElementById("canv");
	canv.width = .95 * document.defaultView.innerWidth;
	canv.height = .95 * document.defaultView.innerHeight;
	canv.addEventListener("click", clickCanv, false);
}

function resize(){
	canv.width = .95 * document.defaultView.innerWidth;
	canv.height = .95 * document.defaultView.innerHeight;
}

function updateViewInput( t){


	switch (t){
		case 0: //text
			break;
		case 1: //music
			break;
		case 2: //image
			break;
		case 3: //video
			break;
	}
}

function getMousePos(canvas, evt) {
    var rect = canvas.getBoundingClientRect();
    return {
      x: evt.clientX - rect.left,
      y: evt.clientY - rect.top
    };
}

function clickCanv(e){
	console.log(e);
	x = canv.getContext("2d");
	m = getMousePos(canv, e);

	x.fillStyle = "#000000";
  x.fillRect (m.x, m.y, 4, 4);
}
