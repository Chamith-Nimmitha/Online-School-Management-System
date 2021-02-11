var classroom_id = document.getElementById("classroom_id");
var classroom_grade = document.getElementById("classroom_grade");
var classroom_class = document.getElementById("classroom_class");
var timetable = document.getElementById("classroom_timetable");
var subjects_tbl = document.getElementById("subject_table");
var timetable_submit = document.getElementById("timetable_submit");
var teacher_submit = document.getElementById("submit");
var subjects = {"G":{},"OP":{},"OT":{}};
var timetable_selects;
var error_flag = 0;


// disable submit when error occured
function disable_submit(){
	if(error_flag !== 0){
		timetable_submit.setAttribute("disabled","disabled");
		timetable_submit.classList.add("btn-gray");
		timetable_submit.classList.remove("btn-blue");
		teacher_submit.setAttribute("disabled","disabled");
		teacher_submit.classList.add("btn-gray");
		teacher_submit.classList.remove("btn-blue");
	}else{
		timetable_submit.removeAttribute("disabled");
		timetable_submit.classList.remove("btn-gray");
		timetable_submit.classList.add("btn-blue");
		teacher_submit.removeAttribute("disabled");
		teacher_submit.classList.remove("btn-gray");
		teacher_submit.classList.add("btn-blue");
	}
}

// set subject array, It contains subject,teacher,periods info
function set_subjects(){
	if(subjects_tbl){
		let inputs = subjects_tbl.querySelectorAll("input");
		inputs.forEach((sub)=>{
			let ext = sub.value.split("--");
			if(ext[0] == "G"){
				subjects["G"][ext[1]] = {no_of_periods:parseInt(ext[2]), periods:[]};
			}else if(ext[0] == "OP"){
				subjects["OP"][ext[1]] = {no_of_periods:parseInt(ext[2]), periods:[]};
			}else if(ext[0] == "OT"){
				subjects["OT"][ext[1]] = {no_of_periods:parseInt(ext[2]), periods:[]};
			}
		})
	}
}

set_subjects();

// add change event to timetable select inputs
if(timetable){
	timetable_selects = timetable.querySelectorAll("select");
	timetable_selects.forEach( (select)=> {
		select.addEventListener("change", constraint_checker);
	});
	calc_free_periods();
}

// when change subject teacher
if(subjects_tbl){
	subjects_tbl.querySelectorAll("select").forEach((sel)=>{
		sel.addEventListener("change",constraint_checker);
	})
}

// check the period limit
function calc_free_periods(){
	if(timetable){
		timetable_selects.forEach( (select)=> {
			let =val = select.value;
			select.removeAttribute("disabled");
			if(val != "FREE" && val != undefined){
				let ext = val.split("--");
				if(subjects[ext[0]].hasOwnProperty(ext[1])){
					subjects[ext[0]][ext[1]].no_of_periods = subjects[ext[0]][ext[1]].no_of_periods-1;
					subjects[ext[0]][ext[1]].periods.push(select.getAttribute('name'));
					if(subjects[ext[0]][ext[1]].no_of_periods < 0){
						timetable_selects.forEach((sel)=>{
							if(sel.value == val){
								error_flag+=1;
								sel.classList.add("subject-select");

							}
						});
					}else{
						timetable_selects.forEach((sel)=>{
							if(sel.value == val){
								sel.classList.remove("subject-select");
								sel.classList.remove("teacher-conflit");
							}
						});
					}
				}
			}
		});
	}
	disable_submit();	
}

//scroll smootly to teacher select element
function scroll_to_teacher(ele){
	let amount = ele.getBoundingClientRect().top-100;
	console.log(amount)
	let per_frame = 300;
	let fps = 10;
	let timer = setInterval(()=>{
		if(amount <=0){
			clearInterval(timer);
		}
		window.scrollBy(0,per_frame);
		amount -= per_frame;
	},1000/fps);

}

// ajax call and check teacher conflits
function check_teacher_in_database(teacher_id,day_p,subject_id){
	var form = new FormData();
	form.append("teacher_id", teacher_id);
	form.append("classroom_id", classroom_id);
	form.append("day", day_p[0]);
	form.append("period", day_p[1]);
	form.append("subject_id", subject_id);
	let task = classroom_grade.value+"-"+classroom_class.value+"-"+subject_id;
	form.append("task", task);
	fetch(base_url+"api/timetable/teacher/conflit",{
		method: "POST",
		body: form
	}).then((res)=>{return res.text();})
	.then( (data)=>{
		console.log(data);
		data = JSON.parse(data);
		if(data.result !="TRUE"){
			timetable_submit.setAttribute("disabled","disabled");
			timetable_submit.classList.add("btn-gray");
			timetable_submit.classList.remove("btn-blue");
			teacher_submit.setAttribute("disabled","disabled");
			teacher_submit.classList.add("btn-gray");
			teacher_submit.classList.remove("btn-blue");
			document.getElementById(day_p[0]+"-"+day_p[1]).classList.add("teacher-conflit");
			let sub_ele = subjects_tbl.querySelector("#subject-teacher-"+subject_id);
			sub_ele.classList.add("teacher-select");
			scroll_to_teacher(sub_ele);
			timetable_selects.forEach((s)=>{
				if(s.name!=day_p[0]+"-"+day_p[1]){
					s.setAttribute("disabled", "disabled");
				}
			});
		}
	})
	.catch((err)=> {console.log(err);});
}

// check teacher available for that periods
function check_teacher_availbility(tar){
	let teachers = subjects_tbl.querySelectorAll("select");
	teachers.forEach((teacher)=>{
		teacher.classList.remove("teacher-select");
		if(teacher.value != "None"){
			let ext = teacher.getAttribute("name").split("-");
			if(subjects["G"].hasOwnProperty(ext[2])){
				let teacher_id = teacher.value;
				let periods = subjects["G"][ext[2]].periods;
				periods.forEach((period)=>{
					day_p = period.split("-");
					check_teacher_in_database(teacher_id,day_p,ext[2]);
				});
			}
		}
	});
}

// call the check functions
function constraint_checker(e){
	error_flag = 0;
	let tar = e.target;
	if(tar.value == "FREE"){
	}
	tar.classList.remove("subject-select");
	tar.classList.remove("teacher-conflit");
	set_subjects(); // reset subjects
	calc_free_periods(); // calculate free available periods
	check_teacher_availbility(tar);
	disable_submit();
}


// IN CLASSROOM SUBJECTS

function assign_new_subject(classroom_subject_wrapper){
	let all_selects = classroom_subject_wrapper.querySelectorAll("select");
	let dummy_select = all_selects[0].cloneNode(true);

	let actual_selects = Array.from(all_selects).slice(1);

	let options = Array.from(dummy_select.querySelectorAll("option"));
	let new_op = options.filter((op)=> {
		let res = true;
		actual_selects.forEach((as)=>{
			if(op.getAttribute("value") != "None" && as.value != "None" && (as.value == op.getAttribute("value"))){
				console.log(as.value, op.getAttribute("value"));
				res = false;
			}
			if(op.getAttribute("value") == "None"){
				op.setAttribute("selected", "selected");
			}
		})
		return res;
	})
	return new_op;
}

if(document.getElementById("general-subject-wrapper")){
	change_option("general-subject-wrapper");
	change_option("optional-subject-wrapper");
	change_option("other-subject-wrapper");
}


// call when change the classroom subject
function change_option(id){
	var classroom_subject_wrapper = document.querySelector("#"+id);
	let all_selects = classroom_subject_wrapper.querySelectorAll("select");
	let actual_selects = Array.from(all_selects).slice(1);


	actual_selects.forEach( (as) =>{
		let dummy_select = all_selects[0].cloneNode(true);
		let options = Array.from(dummy_select.querySelectorAll("option"));
		let new_op = options.filter( (op) =>{
			let flag = true;
			actual_selects.forEach((a) => {
				if( as.value != op.getAttribute("value") && op.getAttribute("value") != "None" && op.getAttribute("value") ==  a.value){
					flag = false;
				}else if( as.value == op.getAttribute("value")){
					op.setAttribute("selected","selected" );
				}
				
			});
			return flag;
		});
		as.innerHTML = "";
		let new_sel = document.createElement("SELECT");

		new_op.forEach( (op) => {
			new_sel.appendChild(op);
		})
		as.innerHTML = new_sel.innerHTML;
	})

}


// classroom General subjects
var no_of_general_subjects = document.querySelectorAll("#general-subject-wrapper > div").length;
var classroom_subject_button = document.querySelector("#general-subject-buttons");
if(classroom_subject_button){
	classroom_subject_button.querySelector("#add_general_subject").addEventListener("click",add_general_subject);
	classroom_subject_button.querySelector("#remove_general_subject").addEventListener("click",remove_general_subject);
}

function add_general_subject(){
	var classroom_subject_wrapper = document.querySelector("#general-subject-wrapper");
	no_of_general_subjects+=1;
	
	let new_op = assign_new_subject(classroom_subject_wrapper);
	
	let div = document.createElement("DIV");
	let label = document.createElement("LABEL");
	let select = document.createElement("SELECT");
	let input = document.createElement("INPUT");
	let p = document.createElement("P");
	div.setAttribute("class","d-flex col-12 align-items-center p-2 mb-3");
	label.setAttribute("class","col-2");
	label.setAttribute("for",`subject-general-${no_of_general_subjects}`);
	label.innerText = `Subject ${no_of_general_subjects}`;
	select.setAttribute("class","col-6 mr-2");
	select.setAttribute("name",`subject-general-${no_of_general_subjects}`);
	select.setAttribute("id",`subject-general-${no_of_general_subjects}`);
	select.setAttribute("onchange","change_option('general-subject-wrapper')");
	let new_sel = document.createElement("SELECT");
	new_op.forEach((d)=>{
		new_sel.appendChild(d)
	});
	select.innerHTML = new_sel.innerHTML;
	input.setAttribute("class","col-3");
	input.setAttribute("type","text");
	input.setAttribute("name",`periods-general-${no_of_general_subjects}`);
	input.setAttribute("id",`periods-general-${no_of_general_subjects}`);
	input.setAttribute("placeholder","No of Periods");
	input.setAttribute("oninput","validate_user_input(this,0,20,1)");
	p.setAttribute("class","bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center");
	div.appendChild(label);
	div.appendChild(select);
	div.appendChild(input);
	div.appendChild(p);
	classroom_subject_wrapper.appendChild(div);
}

function remove_general_subject(){
	var classroom_subject_wrapper = document.querySelector("#general-subject-wrapper");
	if(no_of_general_subjects > 1){
		no_of_general_subjects-=1;
		classroom_subject_wrapper.lastElementChild.remove();
	}else{
		classroom_subject_wrapper.lastElementChild.getElementsByTagName("select")[0].value="";
		classroom_subject_wrapper.lastElementChild.getElementsByTagName("input")[0].value="";
	}
	change_option("general-subject-wrapper");
}

// classroom optional subjects
var no_of_optional_subjects = document.querySelectorAll("#optional-subject-wrapper > div").length;
var classroom_subject_button = document.querySelector("#optional-subject-buttons");
if(classroom_subject_button){
	classroom_subject_button.querySelector("#add_optional_subject").addEventListener("click",add_optional_subject);
	classroom_subject_button.querySelector("#remove_optional_subject").addEventListener("click",remove_optional_subject);
}

function add_optional_subject(){
	var classroom_subject_wrapper = document.querySelector("#optional-subject-wrapper");
	no_of_optional_subjects+=1;
	let new_op = assign_new_subject(classroom_subject_wrapper);

	let div = document.createElement("DIV");
	let label = document.createElement("LABEL");
	let select = document.createElement("SELECT");
	let input = document.createElement("INPUT");
	let p = document.createElement("P");
	div.setAttribute("class","d-flex col-12 align-items-center p-2 mb-3");
	label.setAttribute("class","col-2");
	label.setAttribute("for",`subject-optional-${no_of_optional_subjects}`);
	label.innerText = `Subject ${no_of_optional_subjects}`;
	select.setAttribute("class","col-6 mr-2");
	select.setAttribute("name",`subject-optional-${no_of_optional_subjects}`);
	select.setAttribute("id",`subject-optional-${no_of_optional_subjects}`);
	select.setAttribute("onchange","change_option('optional-subject-wrapper')");
	let new_sel = document.createElement("SELECT");
	new_op.forEach((d)=>{
		new_sel.appendChild(d)
	});
	select.innerHTML = new_sel.innerHTML;
	input.setAttribute("class","col-3");
	input.setAttribute("type","text");
	input.setAttribute("name",`periods-optional-${no_of_optional_subjects}`);
	input.setAttribute("id",`periods-optional-${no_of_optional_subjects}`);
	input.setAttribute("placeholder","No of Periods");
	input.setAttribute("oninput","validate_user_input(this,0,20,1)");
	p.setAttribute("class","bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center");
	div.appendChild(label);
	div.appendChild(select);
	div.appendChild(input);
	div.appendChild(p);
	classroom_subject_wrapper.appendChild(div);
}

function remove_optional_subject(){
	var classroom_subject_wrapper = document.querySelector("#optional-subject-wrapper");
	if(no_of_optional_subjects > 1){
		no_of_optional_subjects-=1;
		classroom_subject_wrapper.lastElementChild.remove();
	}else{
		classroom_subject_wrapper.lastElementChild.getElementsByTagName("select")[0].value="";
		classroom_subject_wrapper.lastElementChild.getElementsByTagName("input")[0].value="";
	}
	change_option("optional-subject-wrapper");
}

// classroom other subjects
var no_of_other_subjects = document.querySelectorAll("#other-subject-wrapper > div").length;
var classroom_subject_button = document.querySelector("#other-subject-buttons");
if(classroom_subject_button){
	classroom_subject_button.querySelector("#add_other_subject").addEventListener("click",add_other_subject);
	classroom_subject_button.querySelector("#remove_other_subject").addEventListener("click",remove_other_subject);
}

function add_other_subject(){
	var classroom_subject_wrapper = document.querySelector("#other-subject-wrapper");
	no_of_other_subjects+=1;
	let new_op = assign_new_subject(classroom_subject_wrapper);
	let div = document.createElement("DIV");
	let label = document.createElement("LABEL");
	let select = document.createElement("SELECT");
	let input = document.createElement("INPUT");
	let p = document.createElement("P");
	div.setAttribute("class","d-flex col-12 align-items-center p-2 mb-3");
	label.setAttribute("class","col-2");
	label.setAttribute("for",`subject-other-${no_of_other_subjects}`);
	label.innerText = `Subject ${no_of_other_subjects}`;
	select.setAttribute("class","col-6 mr-2");
	select.setAttribute("name",`subject-other-${no_of_other_subjects}`);
	select.setAttribute("id",`subject-other-${no_of_other_subjects}`);
	select.setAttribute("onchange","change_option('other-subject-wrapper')");
	let new_sel = document.createElement("SELECT");

	new_op.forEach((d)=>{
		new_sel.appendChild(d)
	});
	select.innerHTML = new_sel.innerHTML;

	input.setAttribute("class","col-3");
	input.setAttribute("type","text");
	input.setAttribute("name",`periods-other-${no_of_other_subjects}`);
	input.setAttribute("id",`periods-other-${no_of_other_subjects}`);
	input.setAttribute("placeholder","No of Periods");
	input.setAttribute("oninput","validate_user_input(this,0,20,1)");
	p.setAttribute("class","bg-red fg-white pl-5 p-1 mt-2 d-none w-100 text-center");
	div.appendChild(label);
	div.appendChild(select);
	div.appendChild(input);
	div.appendChild(p);
	classroom_subject_wrapper.appendChild(div);
}

function remove_other_subject(){
	var classroom_subject_wrapper = document.querySelector("#other-subject-wrapper");
	if(no_of_other_subjects > 1){
		no_of_other_subjects-=1;
		classroom_subject_wrapper.lastElementChild.remove();
	}else{
		classroom_subject_wrapper.lastElementChild.getElementsByTagName("select")[0].value="";
		classroom_subject_wrapper.lastElementChild.getElementsByTagName("input")[0].value="";
	}
	change_option("other-subject-wrapper");
}

if(document.getElementById("timetable_form")){
	document.getElementById("timetable_form").addEventListener("submit",update_timetable);
	document.getElementById("subject_form").addEventListener("submit",update_timetable);
}

// update timetable and subject data using ajax
function update_timetable(e){
	e.preventDefault();
	let timetable_form = document.getElementById("timetable_form");
	let subject_form = document.getElementById("subject_form");
	let ajax_subs = {"G":{},"OP":{},"OT":{}};
	let ajax_time = [];

	timetable_form.querySelectorAll("select").forEach((sel)=>{
		let ext = sel.getAttribute("name").split("-");
		ajax_time.push(JSON.stringify({day:ext[0],period:ext[1],task:sel.value}));
	})

	if(subjects_tbl){
		let trs = subjects_tbl.querySelectorAll("tr");
		trs = Array.from(trs).slice(1);
		trs.forEach((tr)=>{
			let input = tr.querySelector("input");
			let select = tr.querySelector("select");
			let ext = input.value.split("--");
			if(ext[0] == "G"){
				ajax_subs[ext[0]][ext[1]] = {teacher_id:select.value, periods:[]};
			}else if(ext[0]=="OP" || ext[0]=="OT"){
				ajax_subs[ext[0]][ext[1]] = {teacher_id:"None", periods:[]};
			}
		})
	}

	timetable_selects.forEach( (select)=> {
		let val = select.value;
		if(val != "FREE" && val != undefined){
			let ext = val.split("--");
			if(ajax_subs[ext[0]].hasOwnProperty(ext[1])){
				let exp = select.getAttribute('name').split("-");
				ajax_subs[ext[0]][ext[1]].periods.push({day:exp[0],period:exp[1],task:select.value});
			}
		}
	});

	let data = {
		classroom_id:classroom_id.value,
		timetable: ajax_time,
		subjects : ajax_subs
	}

	window.scrollTo(0,0);

	fetch(base_url+"api/classroom/timetable/update",{
		headers: {
	      'Accept': 'application/json',
	      'Content-Type': 'application/json'
	    },
		method:"POST",
		body:JSON.stringify(data),
	}).then( (res)=> { return res.json()})
	.then( (data)=>{
		if(parseInt(data.success) == 1){
			let ajax_update_state = document.getElementById("ajax_update_state");
			ajax_update_state.classList.remove("bg-red");
			ajax_update_state.classList.add("bg-green");
			ajax_update_state.classList.remove("d-none");
			ajax_update_state.innerHTML = "Update Successful.";
		}else{
			ajax_update_state.classList.remove("d-none");
			ajax_update_state.classList.remove("bg-green");
			ajax_update_state.classList.add("bg-red");
			ajax_update_state.innerHTML = "Update Failed.";
		}
	}).catch((err)=>{
		console.log(err);
	});

}