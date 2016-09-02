var isLogin=false;
var debug=window.location.origin=="http://localhost"?true:false;
if(debug)console.log("Modo Depuración");
function detectBD()
{
	var mod="test";
	try {
        localStorage.setItem(mod, mod);
        localStorage.removeItem(mod);
        return true;
    } catch(e) {
        return false;
    }
}
var storageEnabled=detectBD();
if(debug && storageEnabled)console.log("Almacenamiento disponible");
function showMenu(el)
{
	if(el.style.left=="200px")
	{
		el.style.left="";
		tag("header")[0].style.left="";
	}
	else
	{
		el.style.left="200px";
		tag("header")[0].style.left="0";
	}
}
function showReg(i)
{
  id("container-login").style.display="table";
 if(i=="login")
 {
   if(id("log").style.display=="table-cell")id("container-login").style.display=id("log").style.display="none";
	else id("log").style.display="table-cell";
	id("reg").style.display="none";
 }
 else{
	if(id("reg").style.display=="table-cell")id("container-login").style.display=id("reg").style.display="none";
	else id("reg").style.display="table-cell";
	id("log").style.display="none";
 }
}
function loadPDF(file,canvasN){
  var canvas = id(canvasN);
  $.get(file+".png")
    .done(function() {
	  var img = document.createElement("img");
	  img.src=file+".png";
	  img.className="autohide";
	  canvas.parentNode.insertBefore(img,canvas);
	  canvas.remove();
    }).fail(function() {
	  PDFJS.getDocument(file).then(function(pdf) {

	  pdf.getPage(1).then(function(page) {
      var scale = 0.5;
      var viewport = page.getViewport(scale);

	  canvas.className="autohide";
      var context = canvas.getContext('2d');
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      var renderContext = {
        canvasContext: context,
        viewport: viewport
      };
	  page.render(renderContext).promise.then(function(){
		var dataURL= canvas.toDataURL();
		$.ajax({
		type: "POST",
		url: "srcphp/savepreview.php",
		data: {image: dataURL,name: file}
		}).done(function( respond ) {
		if(debug)console.log(respond);
			});
		  });
		});
	  }).then(null, function(error){canvas.remove();});;
    })

}
function sendMsg(mesg,to)
{
  $.post("srcphp/chat.php",
    {
        msg: mesg,
        sendto: to,
		type: "send"
    },
    function(data, status){
        if(debug)console.log("Data: " + data + "\nStatus: " + status);
		getMessages();
    });
}
function createChat(user)
{
  var elemDiv = document.createElement('div');
  elemDiv.className = 'chat color1';
  elemDiv.id = user;
  elemDiv.style.bottom="-220px";
  user=user=="global"?"chat":user;
  elemDiv.innerHTML = "<table class='header' onclick='hideChat(this)'><tr><td style='width:32px'><img src='img/chat.png' /></td><td>"+user.toUpperCase()+"</td><td style='width:28px' onclick='newWindowChat()'><img src='img/newwindow.png'/></td></tr></table><div class='messages'></div><textarea rows='1' onkeypress='msgPress(event,this)' maxlength='200'></textarea>";
  tag("header")[0].appendChild(elemDiv);
}
function msgPress(evt,element)
{
  if(evt.keyCode==13 && element.value!=""){
	sendMsg(element.value,element.parentNode.id);
	element.value="";
	setTimeout(function(){element.value="";},200);
  }
}
function hideChat(element)
{
  if(element.parentNode.style.bottom=="")element.parentNode.style.bottom="-220px";else element.parentNode.style.bottom="";
}

function detectNColumns(){
	if(window.innerWidth>1400)return 4;
	else if(window.innerWidth>1000)return 3;
	else if(window.innerWidth>700)return 2;
	else return 1;
}

function loadTypeAhead()
{
typeBooks.initialize();
typeSubjects.initialize();
$('#search .typeahead').typeahead({
highlight: true
},
{
name: 'libros',
displayKey: 'b',
source: typeBooks.ttAdapter(),
templates: {
header: '<h3 class="type-name">Libros</h3>'
}
},
{
name: 'materias',
displayKey: 's',
source: typeSubjects.ttAdapter(),
templates: {
header: '<h3 class="type-name">Materias</h3>'
}
});

}
function getBooks(offset,limit,subject)
{
  id("loader").style.display="block";
  id("bigContainer").innerHTML="";
  $.post("srcphp/get.php",
    {
		type: "books",offset:offset,limit:limit
    },
    function(data, status){
    	if(data=="]")data="[]";
        var ms=JSON.parse(data);
		var n=new Array();var nn=0;
		var out=bookDiv;
		ms.forEach(function(m){
		 out += organizeBook(m,nn);
		 n[nn]=new Array();
		 n[nn][0]=m.link;n[nn][1]="canv"+nn;
		 nn++;
		});
		id("bigContainer").innerHTML=out;
		n.forEach(function(m){
		  loadPDF(m[0],m[1]);
		});
		id("loader").style.display="none";
		
		$('#uploadBook .typeahead').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
		},
		{
		name: 'subjects',
		displayKey: 's',
		source: typeSubjects.ttAdapter()
		});
    });
}
function organizeBook(m,nn)
{
	var dlt="";
	if(m.uploader==myName || myType=="dev")dlt="<div class='delete' onclick='del(this.parentNode,\"book\",\""+m.id+"\")'>Eliminar</div>";
	var out="<div class='list' style='opacity:0' >"+dlt+"<table class='bookTable'>\
		 <tr><td rowspan='4'><canvas id=\"canv"+nn+"\"></canvas></td>\
		 <td><h1>"+m.title+"</h1></td></tr>\
		 <tr><td><b>"+m.size+"</b></td></tr>\
		 <tr><td>"+m.subject+"</td></tr>\
		 <tr><td><h5><img class='avatar2' src='users/"+m.uploader+".png' onerror=\"this.src='img/avatar.png'\" />"+m.uploader+"</h5></td></tr>\
		 <tr class='color3'><td><a href='web/viewer.html?file=../"+m.link+"'\ target='_blank'>Ver</a>\
		 </td><td><a class='color3' href='"+m.link+"' download>Descargar</a></td></tr></table></div>";
		 return out;
}
var lnxCont={id:"bigContainer",margin:10,columns:detectNColumns(),width:innerWidth>800?innerWidth-240:innerWidth-20};
function getSubjects(offset,limit)
{
  id("loader").style.display="block";
  $.post("srcphp/get.php",
    {
		type: "subjects",offset:offset,limit:limit
    },
    function(data, status){
    	if(debug)console.log(data);
    	if(data=="]")data="[]";
        var ms=JSON.parse(data);
		var out="";
		ms.forEach(function(m){
		  out+=organizeSubject(m);
		});
		id("bigContainer").innerHTML=out;
		id("loader").style.display="none";
    });
  id("bigContainer").innerHTML="";
}
function organizeSubject(m)
{
	var col=getRandomColor("rgb");
	var out = "<div onclick='getFromSub(\""+m.title+"\",0,10)' class='list subColor' style='opacity:0;background-color:"+col+"' ><div class='padding'><h1>"+m.title+"</h1>";
		  if(m.teachers!="")out +="<label>Profesores:</label>"+m.teachers;
		  if(m.time!="")out +="<label>Horarios:</label>"+m.time;
		  out += "</div></div>";
		  return out;
}
function search(s,offset,limit)
{
	if(s=="")return;
  id("loader").style.display="block";
  $.post("srcphp/get.php",
    {
		type: "search",offset:offset,limit:limit,search:s
    },
    function(data, status){
    	if(debug)console.log(data);
    	if(data=="]")data="[]";
    	if(data=="['Usuario no registrado']")displayMsg("Reingrese por favor");
        var ms=JSON.parse(data);
		var out="";
    	var n=new Array();var nn=0;
		ms.forEach(function(m){
			switch(m.type)
			{
				case "file":out+=organizeFile(m);break;
				case "app":out+=organizeApp(m);break;
				case "book":out+=organizeBook(m,nn);
				n[nn]=new Array();
		 		n[nn][0]=m.link;n[nn][1]="canv"+nn;
		 		nn++;
				break;
				case "video":out+=organizeVideo(m);break;
			}
		});
		id("bigContainer").innerHTML=out;
		n.forEach(function(m){
		  loadPDF(m[0],m[1]);
		});
		id("loader").style.display="none";
    });
  id("bigContainer").innerHTML="";
}
function getFromSub(s,offset,limit)
{
  id("loader").style.display="block";
  $.post("srcphp/get.php",
    {
		type: "subjectSelect",offset:offset,limit:limit,subject:s
    },
    function(data, status){
    	if(debug)console.log(data);
    	if(data=="]")data="[]";
        var ms=JSON.parse(data);
		var out="";
    	var n=new Array();var nn=0;
		ms.forEach(function(m){
			switch(m.type)
			{
				case "file":out+=organizeFile(m);break;
				case "app":out+=organizeApp(m);break;
				case "book":out+=organizeBook(m,nn);
				n[nn]=new Array();
		 		n[nn][0]=m.link;n[nn][1]="canv"+nn;
		 		nn++;
				break;
				case "video":out+=organizeVideo(m);break;
			}
		});
		id("bigContainer").innerHTML=out;
		n.forEach(function(m){
		  loadPDF(m[0],m[1]);
		});
		id("loader").style.display="none";
    });
  id("bigContainer").innerHTML="";
}
function getApps(offset,limit)
{
  id("loader").style.display="block";
  $.post("srcphp/get.php",
    {
		type: "apps",offset:offset,limit:limit
    },
    function(data, status){
    	if(debug)console.log(data);
    	if(data=="]")data="[]";
        var ms=JSON.parse(data);
		var out=appDiv;
		ms.forEach(function(m){
		  out += organizeApp(m);
		});
		id("bigContainer").innerHTML=out;
		id("loader").style.display="none";
    });
  id("bigContainer").innerHTML="";
}
function organizeApp(m)
{
	var dlt="";
	if(m.uploader==myName || myType=="dev")dlt="<div class='delete' onclick='del(this.parentNode,\"app\",\""+m.id+"\")'>Eliminar</div>";
	var img="<img src='apps/"+m.id+".png' onerror='this.style.display=\"none\"' />";
	var extras=m.linux==""?"":"<a target='_blank' href='"+m.linux+"'><img src='img/linux.png' /></a>";
	extras+=m.windows==""?"":"<a target='_blank' href='"+m.windows+"'><img src='img/windows.png' /></a>";
	extras+=m.android==""?"":"<a target='_blank' href='"+m.android+"'><img src='img/android.png' /></a>";
	extras+=m.ios==""?"":"<a target='_blank' href='"+m.ios+"'><img src='img/ios.png' /></a>";
	if(debug)console.log(extras);
	var out="<div class='list' style='opacity:0' >"+dlt+"<div class='padding'>\
	<h1>"+img+m.title+"</h1>\
	<div class='appLink'><a target='_blank' href='"+m.web+"'><img src='img/web.png' /></a><br>Webapp</div>\
	<div class='appLink'>"+extras+"<br>Nativas</div>\
	<h4>"+m.subject+"</h4>\
	<h5>"+m.uploader+"</h5>\
	</div></div>";
	return out;
}
function getVideos(offset,limit)
{
  id("loader").style.display="block";
  $.post("srcphp/get.php",
    {
		type: "videos",offset:offset,limit:limit
    },
    function(data, status){
    	if(debug)console.log(data);
    	if(data=="]")data="[]";
        var ms=JSON.parse(data);
		var out=videoDiv;
		ms.forEach(function(m){
		  out += organizeVideo(m);
		});
		id("bigContainer").innerHTML=out;
		id("loader").style.display="none";
    });
  id("bigContainer").innerHTML="";
}
function organizeVideo(m)
{
	var dlt="";
	if(m.uploader==myName || myType=="dev")dlt="<div class='delete' onclick='del(this.parentNode,\"video\",\""+m.id+"\")'>Eliminar</div>";
	var out = "<div class='list' style='opacity:0' >"+dlt+"<div class='padding'>\
	<h1>"+m.title+"</h1>\
		  <iframe src='"+m.link+"' allowfullscreen></iframe>";
		  out += "<div class='padding'><h2>"+m.subject+"</h2><h5>"+m.uploader+"</h5></div></div></div>";
		  return out;
}
function getFiles(offset,limit)
{
  id("loader").style.display="block";
  $.post("srcphp/get.php",
    {
		type: "files",offset:offset,limit:limit
    },
    function(data, status){
    	if(debug)console.log(data);
    	if(data=="]")data="[]";
        var ms=JSON.parse(data);
		var out=fileDiv;
		ms.forEach(function(m){
		  out+=organizeFile(m);
		});
		id("bigContainer").innerHTML=out;
		id("loader").style.display="none";
    });
  id("bigContainer").innerHTML="";
}
function organizeFile(m)
{
	var dlt="";
	if(m.uploader==myName || myType=="dev")dlt="<div class='delete' onclick='del(this.parentNode,\"file\",\""+m.id+"\")'>Eliminar</div>";
	var out = "<div class='list' style='opacity:0' >"+dlt+"<div class='padding'>";
	out += "<h1>"+m.title+"</h1><div class='linksFile'>"+m.link.autoLink()+"</div><h5>"+m.uploader+"</h5></div></div>";
	return out;
}
function getRandomColor(color)
{
	var r = parseInt(Math.random()*255);
	var g = parseInt(Math.random()*255);
	var b = parseInt(Math.random()*255);
	return "rgb("+r+","+g+","+b+")";
}
var lastMSG="";
var getMessages=function(){
  $.post("srcphp/chat.php",
    {
		type: "get"
    },
    function(data, status){
    	if(lastMSG!=data)
    	{
    	if(data=='No puedes acceder al chat')
    		{reconnect();return 0;}
    	lastMSG=data;
    	if(debug)console.log(data);
        var ms=JSON.parse(data);
		var out="";
		ms.forEach(function(m){
		  var color = m.from==myName?"color2":"color1";
		  var date=moment.tz(m.date,'Atlantic/Azores').fromNow();
		  var rep = /((https?:\/\/)[^ \n]+\.(gif|png|jpe?g))/ig;
		  var msg=m.msg.replace(rep,"<a href='$1' target='_blank'><img src='$1'/></a>");
		  var mess="<div class='chat-message "+color+"'>\
		  <div class='from'>"+m.from+"</div><div class='text'>"+msg+"</div>\
		  <div class='date'>"+date+"</div></div>";
		  var fl="";
		  var avatar="<img class='avatar' src='users/"+m.from+".png' onerror=\"this.src='img/avatar.png'\" />";
		  if(m.from==myName)out="<div class='tableMsg' style='text-align:right'>"+mess+avatar+"</div>"+out;
		  else  out="<div class='tableMsg' style='text-align:left'>"+avatar+mess+"</div>"+out;
		 
			});
		id("global").children[1].innerHTML=out;
		setTimeout(function(){id("global").children[1].scrollTop = id("global").children[1].scrollHeight;},500);
		}
    });
}
function displayMsg(str)
{
	if(id("fullMsg")!=null)return 0;
  var elemDiv = document.createElement('table');
  elemDiv.id = 'fullMsg';
  elemDiv.style.bottom="-220px";
  elemDiv.innerHTML = "<tr><td><div class='window'><div id='close' onclick='removeMsg()'>x</div>"+str+"</div><tr></td>";
  document.body.appendChild(elemDiv);
}
function removeMsg(){id("fullMsg").remove()}
var typeBooks = new Bloodhound({
datumTokenizer: Bloodhound.tokenizers.obj.whitespace('b'),
queryTokenizer: Bloodhound.tokenizers.whitespace,
prefetch: {
url: 'srcphp/get.php?type=books',
filter: function(list) {
return $.map(list, function(sub) { return { b: sub }; });
}
}
});

var typeSubjects = new Bloodhound({
datumTokenizer: Bloodhound.tokenizers.obj.whitespace('s'),
queryTokenizer: Bloodhound.tokenizers.whitespace,
prefetch: {
url: 'srcphp/get.php?type=subjects',
filter: function(list) {
return $.map(list, function(sub) { return { s: sub }; });
}
}
});
function newWindowChat()
{
	window.open("chat.php","Chat","height=400,width=500");
}
function reconnect()
{
	if(localStorage.user==undefined)return 0;
	if(localStorage.user=="")return 1;
	$.post("srcphp/check.php",
    {
		user_name: localStorage.user,user_pass:localStorage.pass,s:"0",send:"0"
    },
    function(data, status){
    	if(lastMSG!=data)
    	{
    	if(debug)console.log(data);
    	if(data=="Reconectado" && !isLogin)location.reload();
    }
    });
}
function logout()
{
	localStorage.pass="";
	localStorage.user="";
	location='srcphp/logout.php';
}
function del(el,typ,iden)
{
	if(confirm("¿Está seguro que desea eliminarlo?")==false)return 0;
	el.remove();
	$.post("srcphp/delete.php",
    {
		type: typ,id:iden
    },
    function(data, status){
    	if(lastMSG!=data)
    	{
    	if(debug)console.log(data);
    }
    });
}
var uploader,upFileSize;
function uploadR()
{
	uploader = new plupload.Uploader({
	  browse_button: 'browse',
	  multi_selection: false,
	  url: 'srcphp/upload.php',
	  chunk_size: '500kb',
	  max_retries: 99,
	  multipart : true,
	  multipart_params : {'book_title': '','subject': '','book_rating': '','book_dir': ''},
	  filters : [
        {title : "PDF", extensions : "pdf"}
	    ]

	});
 
	uploader.init();


	uploader.bind('FilesAdded', function(up, files) {
	  var html = '';
	  console.log(files);
	  plupload.each(files, function(file) {
	    html += file.name + ' (' + plupload.formatSize(file.size) + ')';
	    upFileSize=plupload.formatSize(file.size);
	  });
	  id('filelist').innerHTML = html;
	});

	uploader.bind('UploadProgress', function(up, file) {
	  id('progressUp').innerHTML = file.percent + "%";
	});

	uploader.bind('Error', function(up, err) {
	  if(debug)console.log("Error #" + err.code + ": " + err.message);
	});

	id('start-upload').onclick = function() {
		uploader.settings.multipart_params["book_title"] = id("book_title").value;
		uploader.settings.multipart_params["subject"] = id("subject").value;
		uploader.settings.multipart_params["book_size"] = upFileSize;
		uploader.settings.multipart_params["book_dir"] = btoa(Math.random()).replace(/=/gi,"");
	  	uploader.start();
	  	if(debug)console.log("Subiendo");
	};
	uploader.bind('ChunkUploaded', function(up, file, info) {
     if(debug)console.log(info.response);
	});
	uploader.bind('UploadComplete', function(up, file) {
     removeMsg();
     getBooks(0,20);
	});
}

function uploadAvatar()
{
	uploader = new plupload.Uploader({
	  browse_button: 'browse',
	  multi_selection: false,
	  url: 'srcphp/savepreview.php',
	  resize: {
		  width: 128,
		  height: 128,
		  crop: true,
		  resample: true
		},
	  filters : [
        {title : "Imágenes", extensions : "png,jpg"}
	    ]

	});
 
	uploader.init();

	uploader.bind('FilesAdded', function(up, files) {

	  plupload.each(files, function(file) {
	  	var preloader = new mOxie.Image();
	  	 preloader.onload = function() {
                    preloader.downsize( 128, 128 , true ,true,true);
                    id("avatarPreview").src=preloader.getAsDataURL() ;
                };
			preloader.load( file.getSource() );
	  });

	});

	uploader.bind('UploadProgress', function(up, file) {
	  id('progressUp').innerHTML = file.percent + "%";
	});

	uploader.bind('Error', function(up, err) {
	  if(debug)console.log("Error #" + err.code + ": " + err.message);
	});

	id('start-upload').onclick = function() {
	  	uploader.start();
	  	if(debug)console.log("Subiendo");
	};
	uploader.bind('UploadComplete', function(up, file) {
		location.reload();
	});
}