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
				
				//Creamos el texto de fin de juego
				this.fin = new Kiwi.HUD.Widget.TextField( this.game, 'FIN DEL LABERINTO', 50, 50 );
				this.game.huds.defaultHUD.addWidget( this.fin );
				this.fin.style.color = '#5F5F5F';
				
				//creamos la altura en X y Y para ponerlos en 0 al iniciar
				this.robot.x2 = this.robot.y2 = 0;
				
				//console.log(robot.mitad);

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
				
				//ahora calculamos el lugar de partida, apartir de estar en el 0,0
				if(instrucciones.puntoEntrada >= 0 && instrucciones.puntoEntrada <= 7){
					this.robot.x += instrucciones.puntoEntrada*tamanioDePantalla;
					this.robot.y += tamanioDePantalla*0;
					console.log("X: "+this.robot.x+" Y: "+this.robot.y);
					
				}else if(instrucciones.puntoEntrada >= 8 && instrucciones.puntoEntrada <= 15){
					this.robot.x += (instrucciones.puntoEntrada - (8*1))*tamanioDePantalla;
					this.robot.y += tamanioDePantalla*1;
					console.log("X: "+this.robot.x+" Y: "+this.robot.y);
					
				}else if(instrucciones.puntoEntrada >= 16 && instrucciones.puntoEntrada <= 23){
					this.robot.x += (instrucciones.puntoEntrada - (8*2))*tamanioDePantalla;
					this.robot.y += tamanioDePantalla*2;
					console.log("X: "+this.robot.x+" Y: "+this.robot.y);
					
				}else if(instrucciones.puntoEntrada >= 24 && instrucciones.puntoEntrada <= 31){
					this.robot.x += (instrucciones.puntoEntrada - (8*3))*tamanioDePantalla;
					this.robot.y += tamanioDePantalla*3;
					console.log("X: "+this.robot.x+" Y: "+this.robot.y);
					
				}else if(instrucciones.puntoEntrada >= 32 && instrucciones.puntoEntrada <= 39){
					this.robot.x += (instrucciones.puntoEntrada - (8*4))*tamanioDePantalla;
					this.robot.y += tamanioDePantalla*4;
					console.log("X: "+this.robot.x+" Y: "+this.robot.y);
					
				}else if(instrucciones.puntoEntrada >= 40 && instrucciones.puntoEntrada <= 47){
					this.robot.x += (instrucciones.puntoEntrada - (8*5))*tamanioDePantalla;
					this.robot.y += tamanioDePantalla*5;
					console.log("X: "+this.robot.x+" Y: "+this.robot.y);
					
				}else if(instrucciones.puntoEntrada >= 48 && instrucciones.puntoEntrada <= 55){
					this.robot.x += (instrucciones.puntoEntrada - (8*6))*tamanioDePantalla;
					this.robot.y += tamanioDePantalla*6;
					console.log("X: "+this.robot.x+" Y: "+this.robot.y);
					
				}else if(instrucciones.puntoEntrada >= 56 && instrucciones.puntoEntrada <= 63){
					this.robot.x += (instrucciones.puntoEntrada - (8*7))*tamanioDePantalla;
					this.robot.y += tamanioDePantalla*7;
					console.log("X: "+this.robot.x+" Y: "+this.robot.y);
					
				}
				
				posicionAnterior.x = this.robot.x;
				posicionAnterior.y = this.robot.y;
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
				
				console.log(posicionAnterior.y+ tamanioDePantalla +" = "+y);
				
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
			
			function giroDerecha(robot){
				haciaDondeMiraElRobot++;
				robot.rotation += Math.PI * 0.5
				indice++;
			}
			function giroIzquierda(robot){
				haciaDondeMiraElRobot--;
				robot.rotation -= Math.PI * 0.5
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
						giroIzquierda(this.robot);
						//console.log(instrucciones.secuencia[indice]);
						break;
					
					case 2:
						//giro derecha
						giroDerecha(this.robot);
						//console.log(instrucciones.secuencia[indice]);
						break;
				}
				
				
				if(indice == instrucciones.secuencia.length){
					//ejecutamos la secuencia de fin del juego
					console.log("Fin del juego");
					return false;
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
				json = '{"imagen":"http://localhost/p2/images/Tablero.jpg","puntoEntrada":0,"secuencia":[0,0,1,0,0,0,2,0,1,0,2,0,1,0,2,0,0,1,0,0,1,0]}';
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