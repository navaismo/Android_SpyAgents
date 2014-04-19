//FirstView Component Constructor
function FirstView() {
	//create object instance, a parasitic subclass of Observable
	//ventana principal
	var self = Ti.UI.createView({layout: 'vertical', top: 10 });
	// vista de boton
	var buttonView = Ti.UI.createView({layout: 'horizontal', height: 60});
	//vista para los botones dinamicos
	var chansView = Ti.UI.createScrollView({
		contentWidth: 'auto',
  		contentHeight: 'auto',
  		showVerticalScrollIndicator: true,
  		showHorizontalScrollIndicator: false,
  		backgroundImage: '/logo.png',
		layout: 'vertical'
	
	});

	//añadimos ambas vistas a la ventana principal
	self.add(buttonView);
	self.add(chansView);	
	//var settings
	var uSExten;
	var uSId;
	var uSUrl;
	var uSystem;
	
	//añadimos una barra de progreso para inidicar las peticiones al server.
	var progressIndicator = Ti.UI.Android.createProgressIndicator({
  		message: 'Wait, fetching results...',
  		location: Ti.UI.Android.PROGRESS_INDICATOR_DIALOG,
  		type: Ti.UI.Android.PROGRESS_INDICATOR_DETERMINANT,
  		cancelable: true,
  		min: 0,
  		max: 10
	});
	
	//funcion para obtener los valores de los settings
	Ti.App.addEventListener('get_settings', function(){
		uSExten = Ti.App.Properties.getString('uexten');
	    uSId = Ti.App.Properties.getString('uid');
		uSUrl = Ti.App.Properties.getString('uurl');
		uSystem = Ti.App.Properties.getString('usystem');
		if( uSUrl == null || uSExten == null || uSUrl == null){
			alertSettings.show();
		}
		//alert('focused & vals: '+uSExten+" "+uSId+" "+uSUrl);		
	});
			
	//creamos las alertas
	// sin llamadas
	var alertNoCalls = Ti.UI.createAlertDialog({
		title: 'Without Channels',
		message: 'No active calls to monitor.',
		ok: 'Close'
	});
	// error al contactar el server. timeout?
	var alertError = Ti.UI.createAlertDialog({
		title: 'Error',
		message: 'An error Ocurred contacting the server. Please try again.',
		ok: 'Close'
	});
	// Establecer settings primero
	var alertSettings = Ti.UI.createAlertDialog({
		title: 'Settings',
		message: 'Before start set your settings',
		ok: 'Close'
	});
	// La ID es invalida
	var alertNoID = Ti.UI.createAlertDialog({
		title: 'Forbidden',
		message: 'You don\'t have permission to spy channels. Please contact the administrator.',
		ok: 'Close'
	});
		
	//creamos boton para obtener peers activos
	var getpeersButton = Ti.UI.createButton({
		title: 'Get active Channels',
		color: 'white',
		font: {fontWeight: "bold" },
	   	left:18,
    	height: 50,
    	right:5,
    	borderRadius: 4,
    	borderColor: 'blue',
    	backgroundSelectedColor: '#343434',
    	style:Titanium.UI.iPhone.SystemButtonStyle.PLAIN, 
    	backgroundGradient:{ 
        	type:'linear', 
        	colors:[{color:'#4A97F6', position:0.0}, {color:'#1F6CE5', position:1.0}], 
        	backFillStart: false 
    	}
	});
	
	//cambiar el color en cada click
	getpeersButton.addEventListener('touchstart', function(e){
    this.backgroundGradient = {	
    	type: 'linear',	
    	colors: [{color:'#FFFFFF', position:0.0},{color:'#BDBDBD', position:1.0}],
    	backFillStart: false }
	});
	// regresar al color original despues del click
	getpeersButton.addEventListener('touchend', function(e){
    this.backgroundGradient = {	
    	type: 'linear',	
    	colors: [{color:'#4A97F6', position:0.0},{color:'#1F6CE5', position:1.0}],
    	backFillStart: false }
	});
	
	//en el click enviamos la peticion al server para obtener los peers activos
	getpeersButton.addEventListener('click', function(){
		//url destino
		var url;
		
		//selecion de url segun el sistema 
		if (uSystem == 'asterisk'){
			url = "http://"+uSUrl+"/spyagents/getchans.php?id="+uSId;	
		}else if( uSystem == 'freepbx'){
			url = "http://"+uSUrl+"/getchans.php?id="+uSId;
		}else if (uSystem == 'elastix') {
			url = "https://"+uSUrl+"/modules/spyagents/getchans.php?id="+uSId;
		}
		// variables para botones y peers 
		var peersButtons = [];
		var peers = [];
		var json, i;
 
 		//limpiar viejos controles
 		if(chansView.children){
 			chansView.removeAllChildren();
 			progressIndicator.hide();	
 		}
 		//loop del progreso
 		for ( i= 0; i<70; i++ ){
 			progressIndicator.value = i;
 			progressIndicator.show();
 		}
 		//creamos el cliente web
		var xhr = Ti.Network.createHTTPClient({
    		onload: function() {    			    			
    			//Ti.API.debug(this.responseText);
    			//obtenemos la respueta JSON del server
    			json = JSON.parse(this.responseText);
    			
    			if (json[0].active_peer == '123_no_id_123'){
    				//alert('No tiene permisos.');
    				alertNoID.show();
    				progressIndicator.hide();
    			}else if (json[0].active_peer == '123_no_peers_123'){
    				//alert('No hay llamadas activas.');
    				alertNoCalls.show();
    				progressIndicator.hide();
    			}
    			else{
    				progressIndicator.hide();
    			// por cada elemento activo creamos un boton
    				for (i = 0; i < json.length; i++) {
						peers[i] = json[i].active_peer;
    	    			peersButtons[i] = Ti.UI.createButton({
        	    			title: 'Spy Peer ' + peers[i],
        	    			color: 'white',
        	    			font: {fontWeight: "bold" },            				
	   						backgroundSelectedColor:'#A89BC7',
    						left:5,
    						height: 50,
    						right:5,
    						borderRadius: 4,
    						borderColor: 'yellow',
    						style:Titanium.UI.iPhone.SystemButtonStyle.PLAIN, 
    						backgroundGradient:{ 
        						type:'linear', 
        						colors:[{color:'#f3ae1b', position:0.0}, {color:'#bb6008', position:1.0}], 
        						backFillStart: false 
    						}
        				});
	        			//asociamos un resultado a cada boton
    	    			peersButtons[i].result = peers[i];
    	    			
    	    			//cambiamos el color cada que lo tocamos.
    	    			peersButtons[i].addEventListener('touchstart', function(e){
  							this.backgroundGradient = {	
    						type: 'linear',	
    						colors: [{color:'#FFFFFF', position:0.0},{color:'#BDBDBD', position:1.0}],
    						backFillStart: false }
						});
						// regresamos al color original del boton
						peersButtons[i].addEventListener('touchend', function(e){
    						this.backgroundGradient = {	
    						type: 'linear',	
    						colors: [{color:'#f3ae1b', position:0.0},{color:'#bb6008', position:1.0}],
    						backFillStart: false }
						});
    	    			
        				// creamos un evento click para cada boton
        				peersButtons[i].addEventListener('click', function(e){
        					//enviamos una alerta con el boton presionado
        					//alert('Presionaste el peer: ' + e.source.result);
        					// enviamos la peticion para espiar la extension del boton presionado
        					var spyurl;
        					if (uSystem == 'asterisk'){
								spyurl = 'http://'+uSUrl+'/spyagents/spy.php?id='+uSId+'&exten='+uSExten+'&spy_exten='+e.source.result;	
							}else if( uSystem == 'freepbx'){
								spyurl = 'http://'+uSUrl+'/spy.php?id='+uSId+'&exten='+uSExten+'&spy_exten='+e.source.result;
							}else if (uSystem == 'elastix') {
								spyurl = 'https://'+uSUrl+'/modules/spyagents/spy.php?id='+uSId+'&exten='+uSExten+'&spy_exten='+e.source.result;
							}
        					//   
        					var xhr2 = Ti.Network.createHTTPClient({
    							onload: function() {    			    			
    							},
	    						onerror: function(e) {
    								Ti.API.debug("STATUS: " + this.status);
    								Ti.API.debug("TEXT:   " + this.responseText);
    								Ti.API.debug("ERROR:  " + e.error);
    								alert('There was an error retrieving the remote data. Try again.');
    							},
    							// 5 segundos de timeout
    							timeout:5000
							});
							//enviamos la peticion GET 
							xhr2.open("GET", spyurl);
							xhr2.setRequestHeader('User-Agent','Digital-Merge SpyAgents Mobile App');
							xhr2.send();							   				        				
        				});
        				//añadimos los nuevos botones a la vista de canales
	        			chansView.add(peersButtons[i]);        			
    	           }
			}
    	},
    		// enviamos mensaje de error
    		onerror: function(e) {
    		Ti.API.debug("STATUS: " + this.status);
    		Ti.API.debug("TEXT:   " + this.responseText);
    		Ti.API.debug("ERROR:  " + e.error);
    		//alert('Hubo un Error al contactar con el server. Intentelo Nuevamente');
    		alertError.show();
    		progressIndicator.hide();
    	},
    	// 5 segundos de timeout
    	timeout:5000
		});
		//enviamos la peticion GET 
		xhr.open("GET", url);
		xhr.setRequestHeader('User-Agent','Digital-Merge SpyAgents Mobile App');
		xhr.send();
		
		
	});
	
	buttonView.add(getpeersButton);
			
	return self;
}

module.exports = FirstView;
