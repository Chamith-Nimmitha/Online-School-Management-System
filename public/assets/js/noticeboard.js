var noticeIndex=1

showNotices(noticeIndex);

function plusNotices(n){
	showNotices(noticeIndex +=n);
}

function currentNotice(n){
	showNotices(noticeIndex=n);
}

function showNotices(n){
	var i;
	var notices=document.getElementsByClassName('notices');
	var dots =document.getElementsByClassName('dot');

	if(n>notices.length){
		noticeIndex=1
	}
	if(n<1){
		noticeIndex=notices.length
	}

	for(i=0;i<notices.length;i++){
		notices[i].style.display = "none";
	}

	for(i=0;i<dots.length;i++){
		dots[i].className=dots[i].className.replace("dotactive","");	
	}

	notices[noticeIndex-1].style.display="block";
	dots[noticeIndex-1].className +=" dotactive";
	
	
}
