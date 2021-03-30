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
		notices[i].classList.remove('d-block');
		notices[i].classList.add('d-none');
	}

	for(i=0;i<dots.length;i++){
		dots[i].className=dots[i].className.replace("dotactive","");	
	}

	notices[noticeIndex-1].classList.remove("d-none");
	notices[noticeIndex-1].classList.add("d-block");
	dots[noticeIndex-1].className +=" dotactive";
	
	
}

function add_new_school_notice_form(this_id,id){
	let add_form = document.getElementById(id);
	add_form.classList.remove("d-none");
	document.getElementById(this_id).classList.add("d-none");
}

// add a new notice to db
function add_new_school_notice(form){
	window.event.preventDefault();
	let fd = new FormData(form);
	let form_state = form.querySelector("#form_state");
	form_state.innerText = "Proccesing...";

	fetch(base_url+"api/school/notice/add",{
		method:"POST",
		body: fd
	}).then( (res)=> {return res.text()} )
	.then( (data)=>{
		console.log(data);
		data = JSON.parse(data);
		if(data.success == 1){
			form_state.classList.remove("bg-red");
			form_state.classList.add("bg-green");
			form_state.innerText = "Notice Added.";
		}else{
			form_state.classList.add("bg-red");
			form_state.classList.add("bg-green");
			form_state.innerText = "Add Notice Failed.";
		}
	})
	.catch( (err)=>{
		console.log(err);
	});
}

function update_school_notice_form(this_id,id){
	let update_form = document.getElementById(id)
	let notice_id = document.querySelector(".notices.d-block").dataset.notice;
	update_form.querySelector("form").dataset.notice= notice_id;
	update_form.querySelector("a").href = base_url+"school/notice/delete/"+notice_id;

	fetch(`${base_url}api/school/notice/${notice_id}`,{
		method:"GET",
	}).then( (res)=>{ return res.json();})
	.then( (json_data)=>{
		if(json_data.success == 1){
			let data = json_data.data;
			update_form.classList.remove("d-none");
			document.getElementById(this_id).classList.add("d-none");
			update_form.querySelector("#text").value = data.text;
			update_form.querySelector("#reference").value = data.reference;
			update_form.querySelector("#img").value = data.image;
		}
	}).catch((err)=>{
		console.err(err);
	})
}

function update_school_notice(form){
	window.event.preventDefault();
	let fd = new FormData(form);
	let notice_id = form.dataset.notice;
	let form_state = form.querySelector("#form_state");
	form_state.innerText = "Proccesing...";

	fetch(base_url+"api/school/notice/update/"+notice_id,{
		method:"POST",
		body: fd
	}).then( (res)=> {return res.json()} )
	.then( (data)=>{
		if(data.success == 1){
			form_state.classList.add("bg-green");
			form_state.innerText = "Update Successful";
		}else{
			form_state.classList.add("bg-red");
			form_state.innerText = data.error;
		}
	})
	.catch( (err)=>{
		console.log(err);
	});	
}