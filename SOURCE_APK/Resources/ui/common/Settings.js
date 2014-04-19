function Settings(){
	//ventana principal 
	var self = Ti.UI.createWindow({
		layout: 'vertical', 
		orientationModes: [Ti.UI.PORTRAIT],
		windowSoftInputMode: Ti.UI.Android.SOFT_INPUT_ADJUST_PAN
	});
	
	//Vista de Propiedades
	var uSView = Ti.UI.createScrollView({
		layout:'horizontal',
		contentWidth: 'auto',
  		contentHeight: 'auto',
  		showVerticalScrollIndicator: true,
  		showHorizontalScrollIndicator: false,
		top: 25
	});
	
	//Vista Acerca de...
	var aboutView = Ti.UI.createScrollView({
		contentWidth: 'auto',
  		contentHeight: 'auto',
  		showVerticalScrollIndicator: true,
  		showHorizontalScrollIndicator: false,
		layout:'horizontal'		
	});
	
	//Vista arrastable que contiene los Settings y Acerca de...
	var SettingsView = Ti.UI.createScrollableView({
		views: [uSView, aboutView],
		showPagingControl: true
	});
	self.add(SettingsView);
	
	//creamos primer fila de la tabla
	var Srow1 = Ti.UI.createTableViewRow({
		height:'auto',
		//touchEnabled: false
    	selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	
	//creamos label exten
	var extenLabel = Ti.UI.createLabel({
		text: 'Extension:',
		color: 'white',
		font: { fontSize: 10 },
		shadowColor: 'yellow',
  		shadowOffset: {x:5, y:5},
		left: 10
	});
	//creamos textfield exten
	var extenField = Ti.UI.createTextField({
		left: 80,
		width: 160,		
		keyboardType: Ti.UI.KEYBOARD_DEFAULT,
		borderStyle: Ti.UI.INPUT_BORDERSTYLE_NONE,
    	textAlign:"right"
	});
	Srow1.add(extenLabel);
	Srow1.add(extenField);
	
	var Srow2 = Ti.UI.createTableViewRow({
		height:'auto',
    	selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	var idLabel = Ti.UI.createLabel({
		text: 'ID:           ',
		color: 'white',
		font: { fontSize: 10 },
		shadowColor: 'yellow',
  		shadowOffset: {x:5, y:5},
		left: 10
	});
	
	var idField = Ti.UI.createTextField({
		left: 80,
		width: 160,		
    	textAlign:"right",
    	borderStyle: Ti.UI.INPUT_BORDERSTYLE_NONE,
		keyboardType: Ti.UI.KEYBOARD_DEFAULT
	});
	Srow2.add(idLabel);
	Srow2.add(idField);


	var Srow3 = Ti.UI.createTableViewRow({
		height:'auto',
		touchEnabled: false,
    	selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	
	var urlLabel = Ti.UI.createLabel({
		text: 'Server:     ',
		color: 'white',
		font: { fontSize: 10 },
		shadowColor: 'yellow',
  		shadowOffset: {x:5, y:5},
		left: 10
	});
	
	var urlField = Ti.UI.createTextField({
		left: 80,
		width: 160,		
		textAlign:	"right",
		borderStyle: Ti.UI.INPUT_BORDERSTYLE_NONE,
		keyboardType: Ti.UI.KEYBOARD_DEFAULT
	});
	Srow3.add(urlLabel);
	Srow3.add(urlField);

	var Srow4 = Ti.UI.createTableViewRow({
		height:	'auto',
		touchEnabled: false,
    	selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	
	var astSwitch = Ti.UI.createSwitch({
  		style: Ti.UI.Android.SWITCH_STYLE_CHECKBOX,
  		//textAlign:Ti.UI.TEXT_ALIGNMENT_CENTER,
  		title:	'Plain Asterisk',
  		value:	false,
  		left: 80
  		//width: 300 // necessary for textAlign to be effective
	}); 
	
	var Srow5 = Ti.UI.createTableViewRow({
		height:'auto',
		touchEnabled: false,
    	selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	var fpbxSwitch = Ti.UI.createSwitch({
  		style: Ti.UI.Android.SWITCH_STYLE_CHECKBOX,
  		//textAlign:Ti.UI.TEXT_ALIGNMENT_CENTER,
  		title:	'FreePBX',
  		value:	false,
  		left: 80
  		//width: 300 // necessary for textAlign to be effective
	});
	
	var Srow6 = Ti.UI.createTableViewRow({
		height:'auto',
		touchEnabled: false,
    	selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	var elasSwitch = Ti.UI.createSwitch({
  		style: Ti.UI.Android.SWITCH_STYLE_CHECKBOX,
  		//textAlign:Ti.UI.TEXT_ALIGNMENT_CENTER,
  		title:	'Elastix',
  		value:	false,
  		left: 80
  		//width: 300 // necessary for textAlign to be effective
	}); 
	Srow4.add(astSwitch);
	Srow5.add(fpbxSwitch);
	Srow6.add(elasSwitch);

	astSwitch.addEventListener('change',function(e){
  		//Ti.API.info('Switch value: ' + astSwitch.value);
  		if (astSwitch.value==true){
  			fpbxSwitch.value = false;
  			elasSwitch.value = false;
  		}  		
	});
	fpbxSwitch.addEventListener('change',function(e){
  		//Ti.API.info('Switch value: ' + astSwitch.value);
  		if (fpbxSwitch.value==true){
  			astSwitch.value = false;
  			elasSwitch.value = false;
  		}  		
	});
	elasSwitch.addEventListener('change',function(e){
  		//Ti.API.info('Switch value: ' + astSwitch.value);
  		if (elasSwitch.value==true){
  			fpbxSwitch.value = false;
  			astSwitch.value = false;
  		}  		
	});
	
	var Srow7 = Ti.UI.createTableViewRow({
		height:'auto',
		touchEnabled: false,
    	selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});

	var saveButton = Ti.UI.createButton({
		title: '  Save  ',
		color: 'white',
		font: {fontWeight: "bold" },
	   	/*backgroundColor:'gray',
	   	*/backgroundSelectedColor: '#BDBDBD',
    	left: 5,
    	height: 50,
    	right:5,
    	borderRadius: 4,
    	borderColor: 'black',
    	style:Titanium.UI.iPhone.SystemButtonStyle.PLAIN, 
    	backgroundGradient:{ 
        	type:'linear', 
        	colors:[{color:'#ef4444', position:0.0}, {color:'#992f2f', position:1.0}], 
        	backFillStart: false 
    	}
	});	
	//cambiamos el color on press
	saveButton.addEventListener('touchstart', function(e){
  		this.backgroundGradient = {	
    	type: 'linear',	
    	colors: [{color:'#FFFFFF', position:0.0},{color:'#BDBDBD', position:1.0}],
    	backFillStart: false }
	});
	
	saveButton.addEventListener('touchend', function(e){
    	this.backgroundGradient = {	
    	type: 'linear',	
    	colors: [{color:'#ef4444', position:0.0},{color:'#992f2f', position:1.0}],
    	backFillStart: false }
	});

	saveButton.addEventListener('click',function(){		
		if(astSwitch.value == true){
			Ti.App.Properties.setString('usystem', 'asterisk');
		}else if(fpbxSwitch.value== true){
			Ti.App.Properties.setString('usystem', 'freepbx');
		}else if(elasSwitch.value == true){
			Ti.App.Properties.setString('usystem', 'elastix');
		}	
		Ti.App.Properties.setString('uexten', extenField.value);
		Ti.App.Properties.setString('uid', idField.value);
		Ti.App.Properties.setString('uurl', urlField.value);
		alert('Settings Saved');
				
	});
	Srow7.add(saveButton);
	var Sdata = [Srow1,Srow2,Srow3,Srow4,Srow5,Srow6,Srow7];
	var Stable = Ti.UI.createTableView({
    	data:	Sdata,
    	height: 500,
    	style: Ti.UI.iPhone.TableViewStyle.GROUPED
	});

	uSView.add(Stable);
	//uSView.add(picker);
	
	//creamos una alerta
	var alertSettings = Ti.UI.createAlertDialog({
		title: 'Settings',
		message: 'before start set your settings',
		ok: 'Close'
	});
	//obtenemos los valores guardados de los campos
	var uSExten = Ti.App.Properties.getString('uexten');
	var uSId = Ti.App.Properties.getString('uid');
	var uSUrl = Ti.App.Properties.getString('uurl');
	var uSystem = Ti.App.Properties.getString('usystem');
	
	if ( uSExten == null ){
		alertSettings.show();
	}else{
		extenField.value = uSExten;
		idField.value = uSId;
		urlField.value = uSUrl;
		if (uSystem == 'asterisk'){
			astSwitch.value = true;
			fpbxSwitch.value = false;
			elasSwitch.value = false;
		}else if( uSystem == 'freepbx'){
			astSwitch.value = false;
			fpbxSwitch.value = true;
			elasSwitch.value = false;
		}else if (uSystem == 'elastix') {
			astSwitch.value = false;
			fpbxSwitch.value = false;
			elasSwitch.value = true;
		}
	}
		
	var Arow1 = Ti.UI.createTableViewRow({
		height:'auto',
		touchEnabled: false
    	//selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	var aboutLabel = Ti.UI.createLabel({
		text: 'ABOUT',
		color: 'white',
		font: { fontSize: 20, fontWeight: "bold" },
		shadowColor: 'yellow',
  		shadowOffset: {x:5, y:5},
		textAlign: Ti.UI.TEXT_ALIGNMENT_CENTER,
	});
	Arow1.add(aboutLabel);
	
	var Arow2 = Ti.UI.createTableViewRow({
		height:'auto',
		touchEnabled: false
    	//selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	var versionLabel = Ti.UI.createLabel({
		text: 'Version:    0.1',
		color: 'white',
		font: { fontSize: 20 },
		shadowColor: 'yellow',
  		shadowOffset: {x:5, y:5},
		textAlign: Ti.UI.TEXT_ALIGNMENT_CENTER
	});
	Arow2.add(versionLabel);
	
	var Arow3 = Ti.UI.createTableViewRow({
		height:'auto',
		touchEnabled: false
    	//selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	var madeLabel = Ti.UI.createLabel({
		text: 'By:    Navaismo',
		color: 'white',
		font: { fontSize: 20 },
		shadowColor: 'yellow',
  		shadowOffset: {x:5, y:5},
		//left: 10,
		textAlign: Ti.UI.TEXT_ALIGNMENT_CENTER
	});
	Arow3.add(madeLabel);
	
	var Arow4 = Ti.UI.createTableViewRow({
		height:'auto',
		touchEnabled: false
    	//selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	var contactLabel = Ti.UI.createLabel({
		text: 'Email:    info@digital-merge.com',
		color: 'white',
		font: { fontSize: 20 },
		shadowColor: 'yellow',
  		shadowOffset: {x:5, y:5},
		//left: 10,
		textAlign: Ti.UI.TEXT_ALIGNMENT_CENTER,
		autoLink: Ti.UI.AUTODETECT_ALL
	});
	/*contactLabel.addEventListener('click',function(){
		Titanium.Platform.openURL('');
	});*/
	Arow4.add(contactLabel);
	
	var Arow5 = Ti.UI.createTableViewRow({
		height:'auto',
		touchEnabled: false
    	//selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	var siteLabel = Ti.UI.createLabel({
		text: 'Site:     http://digital-merge.com',
		color: '#63D2E0',
		font: { fontSize: 20 },
		shadowColor: 'yellow',
  		shadowOffset: {x:5, y:5},
		//left: 10,
		textAlign: Ti.UI.TEXT_ALIGNMENT_CENTER,
		autoLink: Ti.UI.AUTODETECT_ALL
	});
	
	siteLabel.addEventListener('click',function(){
		Titanium.Platform.openURL('http://digital-merge.com');
	});
	Arow5.add(siteLabel);

	var Arow6 = Ti.UI.createTableViewRow({
		height:'auto',
		touchEnabled: false
    	//selectionStyle:Ti.UI.iPhone.TableViewCellSelectionStyle.NONE
	});
	var manualLabel = Ti.UI.createLabel({
		text: 'Help:     User Guide',
		color: '#63D2E0',
		font: { fontSize: 20 },
		shadowColor: 'yellow',
  		shadowOffset: {x:5, y:5},
		//left: 10,
		textAlign: Ti.UI.TEXT_ALIGNMENT_CENTER,
		autoLink: Ti.UI.AUTODETECT_ALL
	});
	
	manualLabel.addEventListener('click',function(){
		Titanium.Platform.openURL('http://dl.dropbox.com/u/1277237/SpyAgents_Guide.pdf');
	});
	Arow6.add(manualLabel);
	
	
	var Adata = [Arow1,Arow2,Arow3,Arow4,Arow5,Arow6];
	var Atable = Ti.UI.createTableView({
		data: Adata,
		touchEnabled: false
		
	});
	aboutView.add(Atable);
	
	
	
	return self;
}
module.exports = Settings;