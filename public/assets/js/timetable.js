var timetable = document.getElementById("classroom_timetable");
var subjects_tbl = document.getElementById("subject_table");
var subjects = {"G":{},"OP":{},"OT":{}};
var timetable_selects;

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
subjects_tbl.querySelectorAll("select").forEach((sel)=>{
	sel.addEventListener("change",constraint_checker);
})

// check the period limit
function calc_free_periods(){
	if(timetable){
		timetable_selects.forEach( (select)=> {
			let =val = select.value;
			if(val != "FREE" && val != undefined){
				let ext = val.split("--");
				if(subjects[ext[0]].hasOwnProperty(ext[1])){
					subjects[ext[0]][ext[1]].no_of_periods = subjects[ext[0]][ext[1]].no_of_periods-1;
					subjects[ext[0]][ext[1]].periods.push(select.getAttribute('name'));
					if(subjects[ext[0]][ext[1]].no_of_periods < 0){
						timetable_selects.forEach((sel)=>{
							if(sel.value == val){
								sel.style.cssText = "border:2px solid red; background: #EE9090;"
							}
						});
					}else{
						timetable_selects.forEach((sel)=>{
							if(sel.value == val){
								sel.style.cssText = "border:none;"
							}
						});
					}
				}
			}
		});
	}	
}

// ajax call and check teacher conflits
function check_teacher_in_database(teacher_id,day_p,subject_id){
	var form = new FormData();
	form.append("teacher_id", teacher_id);
	form.append("day", day_p[0]);
	form.append("period", day_p[1]);
	form.append("subject_id", subject_id);

		console.log(day_p)
	fetch(base_url+"api/timetable/teacher/conflit",{
		method: "POST",
		body: form
	}).then((res)=>{return res.text();})
	.then( (data)=>{
		data = JSON.parse(data);
		if(data.result !="TRUE"){
			document.getElementById(day_p[0]+"-"+day_p[1]).style.cssText = "border:2px solid darkgreen; background:lightgreen;"
		}
	})
	.catch((err)=> {console.log(err);});
}

// check teacher available for that periods
function check_teacher_availbility(tar){
	let teachers = subjects_tbl.querySelectorAll("select");
	teachers.forEach((teacher)=>{
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
	let tar = e.target;
	if(tar.value == "FREE"){
	}
	tar.style.cssText = "border:none;";
	set_subjects(); // reset subjects
	calc_free_periods(); // calculate free available periods
	check_teacher_availbility(tar);
}

