 
window.addEventListener('load', function()
{
  loadTypeAhead();
  if(isLogin){
  	localStorage.user=myName;
  	localStorage.pass=myPass;
	createChat("global");
	window.setInterval(getMessages,10000);
	getMessages();
	moment.locale("es");
	switch(urlPage)
	{
		case "archivos":getFiles(0,20);break;
		case "apps":getApps(0,20);break;
		case "videos":getVideos(0,20);break;
		case "libros":getBooks(0,20);break;
	}
	window.setInterval(function(){linx.container(lnxCont.id,lnxCont.margin,lnxCont.columns,'portrait',lnxCont.width);},1500);
  }
  else if(storageEnabled)
  {
  	reconnect();
  }
	id("loader").style.display="none";
  id("bigContainer").innerHTML=homeDiv;
  id("bigContainer").style.width=(lnxCont.width+20)+"px";
}, false);
window.addEventListener('resize', function()
{
	lnxCont.width=innerWidth>800?innerWidth-240:innerWidth-20;
	lnxCont.columns=detectNColumns();
	id("bigContainer").innerHTML=homeDiv;
	id("bigContainer").style.width=(lnxCont.width+20)+"px";
}, false);
