var classroom_notice_board =  document.getElementById("classroom_notice_board");
var notice_classroom_id =  document.getElementById("notice_classroom_id");
var notices;
var indicators;
var pre_btn;
var next_btn;
var cycle_notice;
var cycle_time = 5000;

if(classroom_notice_board){
	notices = classroom_notice_board.querySelectorAll("notice");
	indicators = classroom_notice_board.querySelectorAll("#indicators button");
	indicators.forEach( (ind) =>{
		ind.addEventListener("click", select_notice);
	});
	pre_btn = classroom_notice_board.querySelector("#pre_btn").addEventListener("click", pre_notice);
	next_btn = classroom_notice_board.querySelector("#next_btn").addEventListener("click", next_notice);

	notices = classroom_notice_board.querySelectorAll(".notice");
	cycle_notice = setInterval(next_notice,cycle_time);
	classroom_notice_board.addEventListener("mouseenter", ()=>{
		clearInterval(cycle_notice);
	});
	classroom_notice_board.addEventListener("mouseleave", ()=>{
		cycle_notice = setInterval(next_notice,cycle_time);
	});
}

function show_notice(index){
	notices.forEach( (notice) =>{
		if(notice.dataset.index == index){
			notice.classList.remove("d-none");
			notice.classList.add("d-block");
		}else{
			notice.classList.add("d-none");
			notice.classList.remove("d-block");
		}
	});

	indicators.forEach( (ind)=>{
		if(ind.dataset.index != index){
			ind.classList.remove("notice_active");
		}else{
			ind.classList.add("notice_active");
		}
	});
}

function select_notice(e){
	console.log("Clicked");
	let target = e.target;
	let selected_index = target.dataset.index;
	show_notice(selected_index);
}

function next_notice(){
	let active_index = parseInt(classroom_notice_board.querySelector(".notice_active").dataset.index);
	let len = notices.length;
	let show_index = (active_index + 1)%len;
	show_notice(show_index);

}
function pre_notice(e){
	let active_index = parseInt(classroom_notice_board.querySelector(".notice_active").dataset.index);
	let len = notices.length;
	let show_index = (active_index+len-1)%len;
	show_notice(show_index);
}

function add_new_form(this_id,id){
	let add_form = document.getElementById(id)
	add_form.classList.remove("d-none");
	document.getElementById(this_id).classList.add("d-none");
	add_form.querySelector("form").dataset.classroom= notice_classroom_id.value;
}
function show_available_notice(this_id,id){
	document.getElementById(id).classList.remove("d-none");
	document.getElementById(this_id).classList.add("d-none");
}

function update_form(this_id,id){
	let update_form = document.getElementById(id)
	update_form.querySelector("form").dataset.classroom= notice_classroom_id.value;
	let notice_id = document.querySelector(".notice.d-block").dataset.notice;
	update_form.querySelector("form").dataset.notice= notice_id;
	update_form.querySelector("a").href = base_url+"classroom/notice/delete/"+notice_id;

	fetch(`${base_url}api/classroom/notice/${notice_id}`,{
		method:"GET",
	}).then( (res)=>{ return res.json();})
	.then( (json_data)=>{
		if(json_data.success == 1){
			let data = json_data.data;
			update_form.classList.remove("d-none");
			document.getElementById(this_id).classList.add("d-none");
			update_form.querySelector("#title").value = data.title;
			update_form.querySelector("#description").value = data.description;
			update_form.querySelector("#expire_date").value = data.expire;
			update_form.querySelector("#img").value = data.image;
		}
	}).catch((err)=>{
		
	})

}

// add a new notice to db
function add_new_notice(form){
	window.event.preventDefault();
	let fd = new FormData(form);
	fd.append("classroom_id",form.dataset.classroom);

	fetch(base_url+"api/classroom/notice/add",{
		method:"POST",
		body: fd
	}).then( (res)=> {return res.text()} )
	.then( (data)=>{
		console.log(data);
	})
	.catch( (err)=>{
		console.log(err);
	});
}

function update_notice(form){
	window.event.preventDefault();
	let fd = new FormData(form);
	fd.append("classroom_id",form.dataset.classroom);
	let notice_id = form.dataset.notice;
	let form_state = form.querySelector("#form_state");
	form_state.innerText = "Proccesing...";

	fetch(base_url+"api/classroom/notice/update/"+notice_id,{
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

function delete_notice(ele,title,msg){
	show_dialog(ele,title,msg);
}
