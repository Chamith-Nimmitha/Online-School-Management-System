var classroom_notice_board =  document.getElementById("classroom_notice_board");
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

function add_new_notice(this_id,id){
	document.getElementById(id).classList.remove("d-none");
	document.getElementById(this_id).classList.add("d-none");
}
function show_available_notice(this_id,id){
	document.getElementById(id).classList.remove("d-none");
	document.getElementById(this_id).classList.add("d-none");
}

function update_notice(this_id,id){
	document.getElementById(id).classList.remove("d-none");
	document.getElementById(this_id).classList.add("d-none");
}

function delete_notice(ele,title,msg){
	show_dialog(ele,title,msg);
}