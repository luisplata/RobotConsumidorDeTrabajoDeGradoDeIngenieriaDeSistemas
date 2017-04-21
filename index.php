<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>Proyecto de Grado</title>
        
    </head>
    <body style="margin:0px;padding:0px">
        <div id="content"></div>        

		<script src="lib/kiwi.js"></script>
		<script>
		
			var state = new Kiwi.State('Play');
			
			var game;
			var mi_imagen;
			var mitad;
			var cuarto;
			var robot;
			var json;
			var instrucciones ;
			var tamanioDePantalla;
			var posicionAnterior = {x:0,y:0};

			state.preload = function () {
				//cargamos el fondo
				this.addImage('tablero', mi_imagen.src);
				this.addImage('robot',robot.src);
			};

			state.create = function () {

			//variables
				//this.contador = 0;
				//objetos
				this.tablero = new Kiwi.GameObjects.Sprite(this, this.textures.tablero, 0, 0);
				
				this.robot = new Kiwi.GameObjects.Sprite(this, this.textures.robot,0,0);
				

				this.addChild(this.tablero);
				this.addChild(this.robot);
				
				//escalada del tablero
				this.tablero.scaleY=0.5;
				this.tablero.scaleX=0.5;
				//posicionamiento del tablero
				this.tablero.x = -(cuarto);
				this.tablero.y = -(cuarto);
				var escalada = 0.18;
				//escalada del robot
				this.robot.scaleY = this.robot.scaleX = escalada;
				//posicionamiento del robot
				tamanioDePantalla = (this.game.stage.width/8);
				this.robot.x = (robot.mitad);
				this.robot.y =(robot.mitad);
				posicionAnterior.x = posicionAnterior.y = robot.mitad;
				//this.robot.x = (robot.mitad)+672;
				//this.robot.y =(robot.mitad)+;//96 es el tamaño de cada cuadro
				
			};
			var indice = 0;//indicar por donde vamos
			var haciaDondeMiraElRobot = 2;//0=arriba;1=derecha;2=abajo;3=izquierda
			var velocidad = 1;
			
			function derecha(robot){
				robot.x += velocidad;
			}
			function izquierda(robot){
				robot.x -= velocidad;
			}
			function arriba(robot){
				robot.y -= velocidad;
			}
			function abajo(robot){
				robot.y += velocidad;
			}
			
			function adelante(x,y,robot){
				
				//console.log((posicionAnterior.y - tamanioDePantalla)+" "+y);
				
				switch (haciaDondeMiraElRobot){
					case 0:
						
						arriba(robot);
						if((posicionAnterior.y - tamanioDePantalla) == y ){
							posicionAnterior.x = x;
							posicionAnterior.y = y;
							indice++;
						}
						break;
					case 1:
						derecha(robot);
						if((posicionAnterior.x + tamanioDePantalla) == x ){
							posicionAnterior.x = x;
							posicionAnterior.y = y;
							indice++;
						}
						break;
					case 2:
						abajo(robot);
						//console.log(y - tamanioDePantalla); 	
						if((posicionAnterior.y + tamanioDePantalla) == y ){
							posicionAnterior.x = x;
							posicionAnterior.y = y;
							indice++;
						}
						break;
					case 3:
						izquierda(robot);
						break;
				}
				
			}
			
			function giroDerecha(){
				haciaDondeMiraElRobot++;
				indice++;
			}
			function giroIzquierda(){
				haciaDondeMiraElRobot--;
				indice++;
			}
			
			state.update = function () {
				//se ejecutara toda la secuencia del robot andante
				//para despues realizar las rotaciones del robot para que se vea realiza
				//console.log(instrucciones.secuencia);
				
				//movimiento del robot va a ser de 5 px
				//console.log(instrucciones.secuencia[indice]);
				//se realiza el movimiento
				switch(instrucciones.secuencia[indice]){
					case 0:
						//adelante
						adelante(this.robot.x,this.robot.y,this.robot);
						//console.log(instrucciones.secuencia[indice]);
						break;
					
					case 1:
						//giro izquierda
						giroIzquierda();
						//console.log(instrucciones.secuencia[indice]);
						break;
					
					case 2:
						//giro derecha
						giroDerecha();
						//console.log(instrucciones.secuencia[indice]);
						break;
				}
				
				
				if(indice == instrucciones.secuencia.length){
					//ejecutamos la secuencia de fin del juego
					alert("Fin del juego! :P");
					indice++;
				}
				
			};



		</script>
		
		<script>		
			/*
			Aqui se realiza las peticiones hacia el servidor donde debe responder que hay una solucion al laberinto
			*/
			var gameOptions = {
				renderer: Kiwi.RENDERER_WEBGL,
				width: 512,
				height: 512
			};
			document.addEventListener("DOMContentLoaded", function(){
			  
				console.log("Comenzo a preguntar");
				//en 10 sec
				setTimeout(comenzar,200);
			});
			//Las opciones del simulador
			
			
			function comenzar(){
				
				//obtenemos el json
				json = '{"imagen":"http://localhost/p2/images/Tablero.jpg","puntoEntrada":1,"puntoSalida":8,"secuencia":[0,0,1,0,0,0,2,0,1,0,2,0,1,0,2,0,0,1,0,0,1,0]}';
				instrucciones = JSON.parse(json);
				
				console.log(instrucciones);
				
				
				mi_imagen = new Image();
				robot = new Image();
				
				mi_imagen.src = mi_imagen.src = instrucciones.imagen;
				robot.src= "./images/robot.png";
				
				//si no carga alguno reiniciamos hasta que cargue
				mi_imagen.height == 0 ? location.reload(true):console.log("cargo la imagen");
				robot.height == 0 ? location.reload(true):console.log("cargo el robot");
				
				//obtenemos el tamaño de la imagen a partir de su 50%;
				mitad = mi_imagen.height/2;
				cuarto = mitad/2;
				//obtenemos el tamaño de la imagen del robot
				robot.mitad = ((robot.height*0.18)-robot.height)/2;
				
				gameOptions.width=mitad;
				gameOptions.height=mitad;
				
				
				console.log("Comenzo a ejecutar");
				
				game = new Kiwi.Game('', 'Proyecto de grado', state, gameOptions);
			}
		</script>
	
    </body>
</html>