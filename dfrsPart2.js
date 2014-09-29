// Drag, Float or Resize dfrsPart2 (25-11-2004)
// by Vic Phillips http://www.vicsJavaScripts.org.uk

// Functional Code

// Do NOT Change
var dfrsFOld=0;
var dfrsMseX=null;
var dfrsMseY=null;
var dfrsMd='';
var dfrsP=0;
var dfrsObjAry=new Array();
var dfrsFloatAry=new Array();

function dfrsInitialise(){
 if (navigator.userAgent.toLowerCase().indexOf('opera')>-1){ return; }
 dfrsEl=document.getElementsByTagName('*');
 for (dfrs0=0;dfrs0<dfrsEl.length;dfrs0++){
  if (dfrsEl[dfrs0].getAttribute('dfrsdrag')||dfrsEl[dfrs0].getAttribute('dfrsresize')){
   dfrsy=dfrsTop(dfrsEl[dfrs0]);dfrsx=dfrsLeft(dfrsEl[dfrs0])
   dfrsEl[dfrs0].style.position='absolute';
   dfrsEl[dfrs0].style.left=dfrsx+'px';
   dfrsEl[dfrs0].style.top=dfrsy+'px';
   dfrsEl[dfrs0].style.zIndex=dfrsZIndex;
   dfrsEl[dfrs0].onmousedown=function(event) { dfrsMseDown(event,this);}
   dfrsObjAry[dfrsObjAry.length]=dfrsEl[dfrs0];
   if (dfrsEl[dfrs0].getAttribute('dfrsdrag')){dfrsEl[dfrs0].dfrsdrag='yes'; }
   if (dfrsEl[dfrs0].getAttribute('dfrsresize')){dfrsEl[dfrs0].dfrsresize='yes'; }
  }
  if (dfrsEl[dfrs0].getAttribute('dfrsfloat')){
   dfrsFloatAry[dfrsFloatAry.length]=dfrsEl[dfrs0];
   dfrsEl[dfrs0].style.zIndex=dfrsZIndex+1;
   dfrsEl[dfrs0].dfrsfloat='yes';
  }
 }
 if (dfrsFloatAry.length>0){ setInterval('dfrsFloatDo()',100); }
}

function dfrsMseDown(event,obj) {
 document.onmousemove=function(event) {dfrsDoIt(event);}
 document.onmouseup=function(event) {dfrsMseUp(event);}
 dfrsMd='';
 dfrsObj=obj;
 dfrsMse(event);
 dfrsPadding(dfrsObj);
 for (i=0;i<dfrsObjAry.length;i++){ dfrsObjAry[i].style.zIndex=dfrsZIndex; }
 dfrsObj.style.zIndex=dfrsZIndex+1;
 dfrsObjW=dfrsWidth(dfrsObj); dfrsObjL=dfrsLeft(dfrsObj); dfrsObjH=dfrsHeight(dfrsObj); dfrsObjT=dfrsTop(dfrsObj);
 if (dfrsObj.dfrsresize&&dfrsLeft(dfrsObj)+dfrsWidth(dfrsObj)-dfrsEdge<dfrsMseX)     { dfrsMd='R'; }
 else if (dfrsObj.dfrsresize&&dfrsMseX<dfrsLeft(dfrsObj)+dfrsEdge)                   { dfrsMd='L'; }
 else if (dfrsObj.dfrsresize&&dfrsTop(dfrsObj)+dfrsHeight(dfrsObj)-dfrsEdge<dfrsMseY){ dfrsMd='B'; }
 else if (dfrsObj.dfrsresize&&dfrsMseY<dfrsTop(dfrsObj)+dfrsEdge)                    { dfrsMd='T'; }
 else if (dfrsObj.dfrsdrag){ dfrsDragX=dfrsMseX-dfrsObj.offsetLeft; dfrsDragY=dfrsMseY-dfrsObj.offsetTop; dfrsMd='D'; }
}

function dfrsRSRight(dfrs){
 if (parseInt(dfrsObj.style.width)<dfrsEdge*2){ dfrsObj.style.width=(dfrsEdge*2+5)+'px'; dfrsMd=''; return; }
 dfrsObj.style.width=(dfrs-dfrsLeft(dfrsObj)-dfrsP)+'px';
}

function dfrsRSBottom(dfrs){
 if (parseInt(dfrsObj.style.height)<dfrsEdge*2){ dfrsObj.style.height=(dfrsEdge*2+5)+'px'; dfrsMd=''; return; }
 dfrsObj.style.height=(dfrs-dfrsTop(dfrsObj)-dfrsP)+'px';
}

function dfrsRSLeft(dfrs){
 if (parseInt(dfrsObj.style.width)<dfrsEdge*2){ dfrsObj.style.width=(dfrsEdge*2+5)+'px'; dfrsMd=''; return; }
 dfrsObj.style.width=(dfrsObjW+(dfrsObjL-dfrs-dfrsP))+'px';
 dfrsObj.style.left=(dfrs)+'px';
}

function dfrsRSTop(dfrs){
 if (parseInt(dfrsObj.style.height)<dfrsEdge*2){ dfrsObj.style.height=(dfrsEdge*2+5)+'px'; dfrsMd=''; return; }
 dfrsObj.style.height=(dfrsObjH+(dfrsObjT-dfrs-dfrsP))+'px';
 dfrsObj.style.top=(dfrs)+'px';
}

function dfrsDoIt(event) {
 if (dfrsMd==''){ return; }
 dfrsMse(event);
 if(dfrsMseY==null) dfrsMseY=event.clientY;
 if(dfrsMd=='R') { dfrsRSRight(dfrsMseX); }
 if(dfrsMd=='L') { dfrsRSLeft(dfrsMseX); }
 if(dfrsMd=='B') { dfrsRSBottom(dfrsMseY); }
 if(dfrsMd=='T') { dfrsRSTop(dfrsMseY); }
 if(dfrsMd=='D') { dfrsObj.style.left=(dfrsMseX-dfrsDragX)+'px'; dfrsObj.style.top=(dfrsMseY-dfrsDragY)+'px'; }
}

function dfrsMse(event){
 if(!event) var event=window.event;
 if (document.all){ dfrsMseX=event.clientX; dfrsMseY=event.clientY+dfrsSTop(); }
 else {dfrsMseX=event.pageX; dfrsMseY=event.pageY; }
}

function dfrsMseUp(event) {
 document.onmousemove=null; dfrsMd=''; dfrsDragX=-1;  dfrsDragY=-1; dfrsObj.style.zIndex=dfrsZIndex;
}

function dfrsFloatDo(){
 if (dfrsFOld!=dfrsSTop()){
  for (dfrs0=0;dfrs0<dfrsFloatAry.length;dfrs0++){
   if (dfrsFloatAry[dfrs0].dfrsfloat=='yes'){
    dfrsFloatAry[dfrs0].style.top=(dfrsTop(dfrsFloatAry[dfrs0])+dfrsSTop()-dfrsFOld)+'px';
   }
  }
  dfrsFOld=dfrsSTop();
 }
}

// Utilities
function dfrsLeft(dfrs){
 siObjLeft=dfrs.offsetLeft;
 while(dfrs.offsetParent!=null){
  siObjParent=dfrs.offsetParent;
  siObjLeft+=siObjParent.offsetLeft;
  dfrs=siObjParent;
 }
 return siObjLeft;
}

function dfrsTop(dfrs){
 siObjTop=dfrs.offsetTop;
 while(dfrs.offsetParent!=null){
  siObjParent=dfrs.offsetParent;
  siObjTop+=siObjParent.offsetTop;
  dfrs=siObjParent;
 }
 return siObjTop;
}

function dfrsPadding(dfrs){
 dfrsP=0;
 if (!document.all){
  dfrsP=dfrs.style.padding.split('px')[0]*2;
 }
}

function dfrsWidth(dfrs) {
 if (dfrs.offsetWidth){ return dfrs.offsetWidth; }
 return (null);
}

function dfrsHeight(dfrs) {
 if (dfrs.offsetHeight){ return dfrs.offsetHeight; }
 return (null);
}

function dfrsSTop() {
 if (window.pageYOffset!= null){
  return window.pageYOffset;
 }
 if (document.body.scrollWidth!= null){
  if (document.body.scrollTop){
   return document.body.scrollTop;
  }
  return document.documentElement.scrollTop;
 }
 return (null);
}


