var isChat=true;
window.addEventListener('load', function()
{
  if(isLogin){
	createChat("global");
	window.setInterval(getMessages,10000);
	getMessages();
	moment.locale("es");
  }
}, false);