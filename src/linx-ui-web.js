var linxTheme='modern-sky';
var load;
var numDial=0;
var dialEnabled,s2,x1,x2,num;
var mouseM=new Array();
var s = new Array();
var c = new Array();
var ma = new Array();
var mi = new Array();
var dV = new Array();
var se = new Array();
var element,cX,cY,x2,y2,x3,y3,x4,y4;
var fst=1;
var numElements=0;
var moveEnabled=0;
var numTabs=0;
var linx = {
about:function()
{
	var a={
		autor:"Claudio Mariano Carrazana",
		email:"mariano@poweredbylinux.es",
		version:"2.1"
		}
	return a;	
	},
container:function(container, margin, columns, orientation,cWidth)
{
	
	setTimeout(function(){
	var c = id(container);
	if(c.children[0].getAttribute("skip")=="true"){console.log();return 0;}
	var cHeight, nElements, limit;
	var cY=margin;var cX=margin;
	if(cWidth==null)cWidth = (c.offsetWidth/columns)-margin;
	else cWidth=(cWidth/columns)-margin;
	cHeight = (c.offsetHeight/columns)-margin;
	nElements = c.children.length;
	for(var i=0;i<nElements;i++)
	{

		c.children[i].style.position="absolute";
		if(orientation=='portrait'){c.children[i].style.height="auto";if(c.children[i].style.width=="")c.children[i].style.width=cWidth+"px";cY+=c.children[i].offsetHeight+margin;limit=cY/columns}
		else if(orientation=='landscape'){c.children[i].style.width="auto";c.children[i].style.height=cHeight+"px";cX+=c.children[i].offsetWidth+margin;limit=cX/columns}
	}
	if(orientation=='portrait')cY=margin;
	else cX=margin;
	var n=0;
	while(n<nElements)
	{
		var colspan=c.children[n].getAttribute("colspan")==null?1:c.children[n].getAttribute("colspan");
		if (colspan=="columns") colspan=columns;else colspan=parseInt(colspan);
		if(c.children[n+1]!=null && c.children[n+1].space==null && colspan>1){
			c.children[n].style.width=((cWidth*colspan)+(margin*(colspan-1)))+"px";
		for (var i = colspan; i > 1; i--) {
			var childGuest = document.createElement("div");
			childGuest.space=true;
			childGuest.innerHTML="<div style='z-index:0;height:"+c.children[n].offsetHeight+"px'></div>";
			insertAfter(childGuest,c.children[n]);
			nElements++;
		}}
		for(var i=0;i<columns;i++){

		if(orientation=='portrait'){
			cX=margin*(i+1)+cWidth*i;
			cY=n<columns?margin:margin+c.children[n-columns].offsetHeight+c.children[n-columns].offsetTop;
			}
		else if(orientation=='landscape'){
			cY+=cHeight+margin;
			cX=margin;
			}
		c.children[n].style.top=cY+"px";
		c.children[n].style.left=cX+"px";
		n++;
		if(n==nElements)break;
		}
	}
	for(var e=0;e<id(container).children.length;e++)
	{
		setAnimation(id(container).children[e],"show",(e*200)+"ms","0ms");
		id(container).children[e].style.opacity=1;
	}
	},100);

},
dial:function(dial,defaultValue,minValue,maxValue,sensitivity,container)
{
		s[numDial]=id(dial);
		s[numDial].className="dial1-"+linxTheme;
		s[numDial].insertAdjacentHTML( 'afterbegin',"<div class=\"dial2-"+linxTheme+"\" style=\"width:100%;height:100%\"></div>");
		ma[numDial]=maxValue;
		mi[numDial]=minValue;
		dV[numDial]=defaultValue;
		se[numDial]=sensitivity;
		c[numDial]=270/(ma[numDial]-mi[numDial]);
		s[numDial].style['-webkit-transform'] = 'rotate(' + ((dV[numDial]-mi[numDial])*c[numDial]) + 'deg)';
		s[numDial].style['-moz-transform'] = 'rotate(' + ((dV[numDial]-mi[numDial])*c[numDial]) + 'deg)';
		s[numDial].style['transform'] = 'rotate(' + ((dV[numDial]-mi[numDial])*c[numDial]) + 'deg)';
		s[numDial].onmousedown = function(evt){x1=evt.clientX;dialEnabled=1;s2=id(this.id)}
		s[numDial].addEventListener('touchstart', function(evt){x1=evt.changedTouches[0].clientX;dialEnabled=1;s2=id(this.id)} ,false);
		id(container).onmouseup = function(){dialEnabled=0;s2=null}
		id(container).addEventListener('touchend', function(){dialEnabled=0;s2=null},false);
		var move = function(evt){
			for(var i=0;i<numDial;i++){
				if(s[i]==s2){num=i}
				}
			var x3;
			if(dV[num]<mi[num]){dV[num]=mi[num];dialEnabled=0;
				x3=(dV[num]-mi[num])*c[num];
				s2.style['-webkit-transform'] = 'rotate(' + x3 + 'deg)';
				s2.style['-moz-transform'] = 'rotate(' + x3 + 'deg)';
				s2.style['transform'] = 'rotate(' + x3 + 'deg)';
				this.value=dV[num];}
			if(dV[num]>ma[num]){dV[num]=ma[num];dialEnabled=0;
				x3=(dV[num]-mi[num])*c[num];
				s2.style['-webkit-transform'] = 'rotate(' + x3 + 'deg)';
				s2.style['-moz-transform'] = 'rotate(' + x3 + 'deg)';
				s2.style['transform'] = 'rotate(' + x3 + 'deg)';
				this.value=dV[num];}
			if(dialEnabled==1 && dV[num]>=mi[num] && dV[num]<=ma[num]){
				x2=(evt.clientX-x1)/se[num];
				x3=(dV[num]-mi[num])*c[num];
				s2.style['-webkit-transform'] = 'rotate(' + (x3+x2) + 'deg)';
				s2.style['-moz-transform'] = 'rotate(' + (x3+x2) + 'deg)';
				s2.style['transform'] = 'rotate(' + (x3+x2) + 'deg)';
				dV[num]+=x2;
				this.value=dV[num];}
				}
			var movetouch = function(evt){
			for(var i=0;i<numDial;i++){
				if(s[i]==s2){num=i}
				}
			var x3;
			if(dV[num]<mi[num]){dV[num]=mi[num];dialEnabled=0;
				x3=(dV[num]-mi[num])*c[num];
				s2.style['-webkit-transform'] = 'rotate(' + x3 + 'deg)';
				s2.style['-moz-transform'] = 'rotate(' + x3 + 'deg)';
				s2.style['transform'] = 'rotate(' + x3 + 'deg)';
				this.value=dV[num];}
			if(dV[num]>ma[num]){dV[num]=ma[num];dialEnabled=0;
				x3=(dV[num]-mi[num])*c[num];
				s2.style['-webkit-transform'] = 'rotate(' + x3 + 'deg)';
				s2.style['-moz-transform'] = 'rotate(' + x3 + 'deg)';
				s2.style['transform'] = 'rotate(' + x3 + 'deg)';
				this.value=dV[num];}
			if(dialEnabled==1 && dV[num]>=mi[num] && dV[num]<=ma[num]){
				x2=(evt.changedTouches[0].clientX-x1)/se[num];
				x3=(dV[num]-mi[num])*c[num];
				s2.style['-webkit-transform'] = 'rotate(' + (x3+x2) + 'deg)';
				s2.style['-moz-transform'] = 'rotate(' + (x3+x2) + 'deg)';
				s2.style['transform'] = 'rotate(' + (x3+x2) + 'deg)';
				dV[num]+=x2;
				this.value=dV[num];}
				}
			id(container).onmousemove = move;
			id(container).addEventListener('touchmove',movetouch ,false);
			numDial++;
},
loadScreen:function(loading,loaded,timeDelay,innerSize,cColor,bColor,textColor)
{
	id(loading).style.display="block";
	id(loaded).style.display="none";
	var l = id(loading);
	l.style.background=bColor;
	if(l.style.background=='black'||l.style.background=='rgb(0, 0, 0)'){l.style.color="red"}
	l.className="loading-screen";
	var bb="background: -moz-radial-gradient(center, ellipse cover,  "+bColor+" 0%, "+bColor+" 50%, rgba(255,255,255,1) 53%, rgba(146,146,146,1) 58%, rgba(102,102,102,0) 60%, rgba(80,80,80,0) 61%, rgba(80,80,80,0) 100%);background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%,"+bColor+"), color-stop(50%,"+bColor+"), color-stop(53%,"+bColor+"), color-stop(58%,rgba(146,146,146,1)), color-stop(60%,rgba(102,102,102,0)), color-stop(61%,rgba(80,80,80,0)), color-stop(100%,rgba(80,80,80,0)));background: -webkit-radial-gradient(center, ellipse cover,  "+bColor+" 0%,"+bColor+" 50%,"+bColor+" 53%,rgba(146,146,146,1) 58%,rgba(102,102,102,0) 60%,rgba(80,80,80,0) 61%,rgba(80,80,80,0) 100%);background: -o-radial-gradient(center, ellipse cover,  "+bColor+" 0%,"+bColor+" 50%,"+bColor+" 53%,rgba(146,146,146,1) 58%,rgba(102,102,102,0) 60%,rgba(80,80,80,0) 61%,rgba(80,80,80,0) 100%);background: -ms-radial-gradient(center, ellipse cover,  "+bColor+" 0%,"+bColor+" 50%,"+bColor+" 53%,rgba(146,146,146,1) 58%,rgba(102,102,102,0) 60%,rgba(80,80,80,0) 61%,rgba(80,80,80,0) 100%);background: radial-gradient(ellipse at center,  "+bColor+" 0%,"+bColor+" 50%,"+bColor+" 53%,rgba(146,146,146,1) 58%,rgba(102,102,102,0) 60%,rgba(80,80,80,0) 61%,rgba(80,80,80,0) 100%)"
	var animation = "animation:loading "+timeDelay+"s linear;-webkit-animation:loading "+timeDelay+"s linear;-moz-animation:loading "+timeDelay+"s linear";
	var powered = "<p><a href=\"http://linx-ui.com.ar\" target=\"_blank\" style=\"color:"+textColor+";text-decoration:none\">Powered by Linx-UI</a></p>"
	var inner= "<div class=\"inner2-lScreen\" style=\""+bb+"\"></div>";
	l.innerHTML="<div class=\"outer-lScreen\" style=\""+animation+";width:"+innerSize+"px;height:"+innerSize+"px;background:"+cColor+"\"><div class=\"inner-lScreen\">"+inner+"</div></div>"+powered;
	setTimeout(function(){
	id(loading).style.display="none";
	id(loaded).style.display="block"},(timeDelay*1000));
},
loadScreen2:function(element,background)
{
	element.innerHTML="";
	element.style.backgroundColor=background;
	var inH=(element.offsetHeight*0.25);
	for(var i=0;i<5;i++){
		element.innerHTML+="<div class=\"loadScreen2-inner\"></div>";
		element.children[i].style.zIndex=5-i;
		element.children[i].style.height=inH+"px";
		element.children[i].style.width=inH+"px";
		element.children[i].style.top=(element.offsetHeight/3)-(inH/2)+"px";
		element.children[i].style.left=(element.offsetWidth/2)-(element.children[i].offsetWidth/2)+"px";
		}	
	element.children[0].style.backgroundColor="blue";
	element.children[1].style.backgroundColor="red";
	element.children[2].style.backgroundColor="magenta";
	element.children[3].style.backgroundColor="green";
	element.children[4].style.backgroundColor="yellow";
	transform(element.children[1],20,inH*0.8,0,0.9);
	transform(element.children[2],-20,-inH*0.8,0,0.9);
	transform(element.children[3],30,inH*1.5,0,0.8);
	transform(element.children[4],-30,-inH*1.5,0,0.8);
	loadTimer=window.setInterval(function(){linx.loadScreen2Anim()},300);
	},
loadScreen2Anim:function()
{
	for(var i=0;i<tag("loadscreen2").length;i++)
	{
		for(var e=0;e<tag("loadscreen2")[i].children.length;e++)
		{
			var afterColor;
			var beforeColor=tag("loadscreen2")[i].children[e].style.backgroundColor;
			if(beforeColor=="blue"){afterColor="magenta"}
			else if(beforeColor=="magenta"){afterColor="yellow"}
			else if(beforeColor=="yellow"){afterColor="green"}
			else if(beforeColor=="green"){afterColor="red"}
			else if(beforeColor=="red"){afterColor="blue"}
			tag("loadscreen2")[i].children[e].style.backgroundColor=afterColor;
			}		
		}
	},
fixedBar:function(barId,barLocation,barSize)
{
	var b = id(barId);	
	if(barLocation=='top'){b.className = "top-" + linxTheme;b.style.height=barSize+"px"}
	if(barLocation=='bottom'){b.className = "bottom-" + linxTheme;b.style.height=barSize+"px"}
	if(barLocation=='left'){b.className = "left-" + linxTheme;b.style.width=barSize+"px"}
	if(barLocation=='right'){b.className = "right-" + linxTheme;b.style.width=barSize+"px"}
},
autoZoom:function(zoomObj,container,fitTo)
{
	var z = id(zoomObj);
	z.className="zoomObject";
	var con = id(container);
	if(fitTo=='width')
	{
	var bodyW=con.offsetWidth/z.offsetWidth;
	z.style['-webkit-transform'] = 'scale(' + bodyW + ')';
	z.style['-moz-transform'] = 'scale(' + bodyW + ')';
	z.style['transform'] = 'scale(' + bodyW + ')';	
		}
	if(fitTo=='height')
	{
	var bodyH=con.offsetHeight/z.offsetHeight;
	z.style['-webkit-transform'] = 'scale(' + bodyH + ')';
	z.style['-moz-transform'] = 'scale(' + bodyH + ')';
	z.style['transform'] = 'scale(' + bodyH + ')';
		}
},
moveElement:function(idElement)
{
	id(idElement).style.position="absolute";
	id(idElement).style.top=id(idElement).getBoundingClientRect().top+"px";
 id(idElement).style.left=id(idElement).getBoundingClientRect().left+"px";
var ontouch=function(evt) {
		cX = evt.changedTouches[0].pageX;
		cY = evt.changedTouches[0].pageY;
		x4=this.getBoundingClientRect().left-(this.offsetWidth/2);
   y4=this.getBoundingClientRect().top-(this.offsetHeight/2);
		moveEnabled=1;
		element=this;
		};
var ondown=function(e){
    cX = e.pageX;
    cY = e.pageY;
    x4=this.getBoundingClientRect().left-(this.offsetWidth/2);
    y4=this.getBoundingClientRect().top-(this.offsetHeight/2);
    moveEnabled=1;
    element=this;
	};
	id(idElement).onmousedown = ondown;
	id(idElement).addEventListener('touchstart',ontouch ,false);
	if(fst==1){
	document.onmouseup = function(e){
    moveEnabled=0;
	}
	document.onmousemove = function(e){
		if(moveEnabled==1){
    x2 = e.clientX;
    y2 = e.clientY;
    x3=x2-cX+x4;
    y3=y2-cY+y4;
    element.style.top=y3+"px";
    element.style.left=x3+"px";
    }
	}
	document.addEventListener('touchend', function(evt){
		moveEnabled=0;
		},false);
	document.addEventListener('touchmove', function(evt){
		if(moveEnabled==1){
    x2 = evt.changedTouches[0].clientX;
    y2 = evt.changedTouches[0].clientY;
    x3=cX-x2+x4;
    y3=cY-y2+y4;
    element.style.top=y3+"px";
    element.style.left=x3+"px";
    }
		},false);}
	fst=0;
	},
autoLoad:function()
{
	if(document.body!=null){window.clearInterval(loadAll)}
	numTabs=0;
	for(var i=0;i<tag("tabgroup").length;i++){linx.tabGroup(tag("tabgroup")[i])}
	for(var i=0;i<tag("loadscreen2").length;i++){linx.loadScreen2(tag("loadscreen2")[i],tag("loadscreen2")[i].getAttribute("background"))}
	for(var i=0;i<tag("imggallery").length;i++){imgGallery(tag("imggallery")[i])}
},
tabGroup:function(element)
{
	element.className="tabgroup-"+linxTheme;
	element.indexTab=numTabs;
	numTabs++;
	var f=element.children.length;
	for(var i=f-1;i>=0;i--)
	{if(element.children[i].tagName!="TAB"){element.children[i].remove();f--}}
	for(var i=0;i<f;i++)
	{
		var t = element.children[i].getAttribute('tabTitle');
		var show = element.indexTab + ",'" + t + "'";
		element.innerHTML+='<tabselect class=\"tabselect-'+linxTheme+'\" onclick=\"linx.showTab(' + show + ')\">'+t+'</tabselect>';
	}
	showTab(element.indexTab,element.children[0].getAttribute('tabTitle'))
},
showTab:function(index,title)
{
	var el=tag("tabgroup")[index];
	var f=el.children.length/2;
	for(var i=0;i<f;i++)
	{
		var t = el.children[i].getAttribute('tabTitle');
		if(t==title){el.children[i].style.display="block"}
		else{el.children[i].style.display="none"}
	}
},
theme:function(theme){linxTheme=theme;numDial=0;numTabs=0}
}
//Functions n2
function bgColor(element,color)
{
	if(color==null){return id(element).style.backgroundColor}
	else{id(element).style.backgroundColor=color}
}
function setAnimation(el,nameAnim,time,delay){
	el.style.animationName=nameAnim;
	el.style.animationDuration=time;
	el.style.animationDelay=delay;
	el.style.webkitAnimationName=nameAnim;
	el.style.webkitAnimationDuration=time;
	el.style.webkitAnimationDelay=delay;
}
function rotate(element,deg){transform(element,deg,0,0,1)}
function translate(element,x,y){transform(element,0,x,y,1)}
function scale(element,scale){transform(element,0,0,0,scale)}
function transform(element,deg,x,y,scale)
{
	if(deg==null){deg=0}
	if(x==null){x=0}
	if(y==null){y=0}
	if(scale==null){scale=1}
	var v='rotate(' + deg + 'deg) translate(' + x + 'px,' + y + 'px) scale(' + scale + ')';
	element.style['-ms-transform'] = v;
	element.style['-o-transform'] = v;
	element.style['-webkit-transform'] = v;
	element.style['-moz-transform'] = v;
	element.style['transform'] = v;
}
function id(element){return document.getElementById(element)}
function tag(element){return document.getElementsByTagName(element)}
function className(element){return document.getElementsByClassName(element)}
Element.prototype.remove = function(){this.parentElement.removeChild(this)}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = 0, len = this.length; i < len; i++){
        if(this[i] && this[i].parentElement){this[i].parentElement.removeChild(this[i])}
    }
}
var loadAll;
var autoLoad=true;
function tryLoad(){
	if(autoLoad==true)
	{
	loadAll=window.setInterval(function(){linx.autoLoad()},500);
	}
}
tryLoad();
function imgGallery(element)
{
	var iW,iH;
	element.innerHTML="<img src=\"\" />"+element.innerHTML;
	element.children[0].src=element.children[1].src;
	var changeImgGall=function(){this.parentNode.children[0].src=this.src};
	for(var i=0;i<element.children.length;i++)
	{
		if(i==0){iW=element.children[i].offsetWidth;iH=tag("imggallery")[0].children[i].offsetWidth;}
		element.children[i].style.zIndex=17-i;
		if(i==1){transform(element.children[1],0,-(iW/2.1),-(iH/2.1),0.2)}
		if(i==2){transform(element.children[2],0,-(iW/4),-(iH/1.65),0.2)}
		if(i==3){transform(element.children[3],0,0,-(iH/1.5),0.2)}
		if(i==4){transform(element.children[4],0,(iW/4),-(iH/1.65),0.2)}
		if(i==5){transform(element.children[5],0,(iW/2.1),-(iH/2.1),0.2)}
		if(i==6){transform(element.children[6],0,(iW/1.65),-(iH/4),0.2)}
		if(i==7){transform(element.children[7],0,(iW/1.5),0,0.2)}
		if(i==8){transform(element.children[8],0,(iW/1.65),(iH/4),0.2)}
		if(i==9){transform(element.children[9],0,(iW/2.1),(iH/2.1),0.2)}
		if(i==10){transform(element.children[10],0,(iW/4),(iH/1.65),0.2)}
		if(i==11){transform(element.children[11],0,0,(iH/1.5),0.2)}		
		if(i==12){transform(element.children[12],0,-(iW/4),(iH/1.65),0.2)}
		if(i==13){transform(element.children[13],0,-(iW/2.1),(iH/2.1),0.2)}
		if(i==14){transform(element.children[14],0,-(iW/1.65),(iH/4),0.2)}
		if(i==15){transform(element.children[15],0,-(iH/1.5),0,0.2)}
		if(i==16){transform(element.children[16],0,-(iW/1.65),-(iH/4),0.2)}
		if(i>0){element.children[i].onclick=changeImgGall;}
		}
	}
(function() {
  var autoLink,
    __slice = [].slice;

  autoLink = function() {
    var k, linkAttributes, option, options, pattern, v;
    options = 1 <= arguments.length ? __slice.call(arguments, 0) : [];

    pattern = /(^|[\s\n]|<br\/?>)((?:https?|ftp):\/\/[\-A-Z0-9+\u0026\u2019@#\/%?=()~_|!:,.;]*[\-A-Z0-9+\u0026@#\/%=~()_|])/gi;
    if (!(options.length > 0)) {
      return this.replace(pattern, "$1<a target='_blank' href='$2'>$2</a>");
    }
    option = options[0];
    linkAttributes = ((function() {
      var _results;
      _results = [];
      for (k in option) {
        v = option[k];
        if (k !== 'callback') {
          _results.push(" " + k + "='" + v + "'");
        }
      }
      return _results;
    })()).join('');
    return this.replace(pattern, function(match, space, url) {
      var link;
      link = (typeof option.callback === "function" ? option.callback(url) : void 0) || ("<a href='" + url + "'" + linkAttributes + ">" + url + "</a>");
      return "" + space + link;
    });
  };

  String.prototype['autoLink'] = autoLink;

}).call(this);
var urlParams,urlPage;
(window.onpopstate = function () {
    var match,
        pl     = /\+/g,  // Regex for replacing addition symbol with a space
        search = /([^&=]+)=?([^&]*)/g,
        decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
        query  = window.location.search.substring(1);

    urlParams = {};
    while (match = search.exec(query))
       urlParams[decode(match[1])] = decode(match[2]);
   var re = /\?(.*)/;
   urlPage=urlParams["s"];
})();
function insertAfter(newNode, referenceNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}