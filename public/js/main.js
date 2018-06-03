var canv;
var inputBox; //html div
var textIn; //html textarea
var posted; //bool has the user posted something to the canvas?
var croakType = 0;

function init(){
	canv = document.getElementById("canv");
	canv.width = .95 * document.defaultView.innerWidth;
	canv.height = .95 * document.defaultView.innerHeight;
	canv.addEventListener("click", clickCanv, false);
	inputZone = document.getElementById("input-zone");
	textIn = document.getElementById("textIn");

	setInterval(function(){
		getCroaks()
	}, 10000);

}

function getCroaks(){
	axios.get('/croaks')
	.then(function(response){
		for (var i = 0; i < response.data.length; i++){
			drawCroak(response.data[i]);
		}
	})
	.catch(function(error){
		console.log(error);
	});
}

function resize(){
	canv.width = .95 * document.defaultView.innerWidth;
	canv.height = .85 * document.defaultView.innerHeight;
}

function croak(t, x, y){
	console.log("croakin");
	var req = {
		type: t,
		x: x,
		y: y
	}

	switch(t){
		case 0: //txt
			req.content = textIn.value;
			break;
		case 1: //img
			break;
		case 2: //audio
			break;
		default: //vid
			break;
	}

	axios.post('/croaks', req)
	.then(function (response) {
    console.log(response);
  })
  .catch(function (error) {
    console.log(error);
  });
}

function updateViewInput( t){


	switch (t){
		case postType.txt:
			break;
		case postType.aud:
			break;
		case postType.img:
			break;
		case postType.vid:
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

/*
	show a marker on the canvas for where it will be
	show how much remaining info allowed or how long imprint will remain
	upload new croak to the database
*/
function clickCanv(e){
	console.log(e);
	x = canv.getContext("2d");
	m = getMousePos(canv, e);

	x.font = "30px Arial";
	x.fillText(textIn.value, m.x, m.y);

	croak(0, m.x, m.y);

	var a = 1.0;
	setInterval(function(){
		x.clearRect(0, 0, canv.width, canv.height);
		x.strokeStyle = "rgba(200, 0, 0, " + a + ")";
		x.strokeText(textIn.value, m.x, m.y);
		a -= .0005;
	}, 500);



	x.fillStyle = "#000000";
  x.fillRect (m.x, m.y, 4, 4);
}

function drawCroak(c){
	x = canv.getContext("2d");
	console.log(c);
	switch(Number(c.type)){
		case 0:
			x.font = "30px Arial";
			setInterval(function(){
				//x.clearRect(0, 0, canv.width, canv.height);
				x.strokeStyle = "rgba(200, 0, 0, 1)";
				x.strokeText(c.content, Number(c.x), Number(c.y));
			}, 500);
			break;
		default:
			break;
	}

}
