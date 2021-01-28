var timetable = document.getElementById("classroom_timetable");
var subjects_tbl = document.getElementById("subject_table");
var subjects = {};
var timetable_selects;

function set_subjects(){
	if(subjects_tbl){
		let inputs = subjects_tbl.querySelectorAll("input");
		inputs.forEach((sub)=>{
			let ext = sub.value.split("--");
			subjects[ext[0]] = parseInt(ext[1]);
		})
		// console.log(subjects);
	}
}

set_subjects();

if(timetable){
	timetable_selects = timetable.querySelectorAll("select");
	timetable_selects.forEach( (select)=> {
		select.addEventListener("change", constraint_checker);
		let val = select.value;
		if(val != "FREE" && subjects[val] != undefined){
			subjects[val] = subjects[val]-1;
		}
	});
	console.log(subjects);
}

// check the period limit
function calc_free_periods(){
	if(timetable){
		timetable_selects = timetable.querySelectorAll("select");
		timetable_selects.forEach( (select)=> {
			let val = select.value;
			if(val != "FREE" && subjects[val] != undefined){
				subjects[val] = subjects[val]-1;
				if(subjects[val] < 0){
					timetable_selects.forEach((sel)=>{
						if(sel.value == val){
							sel.style.cssText = "border:2px solid red;"
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
		});
		console.log(subjects);
	}	
}

// call the check functions
function constraint_checker(e){
	let tar = e.target;
	tar.style.cssText = "border:none;";
	set_subjects(); // reset subjects
	calc_free_periods(); // calculate free available periods
	
	// console.log(subjects);
}

