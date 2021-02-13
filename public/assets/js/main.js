document.addEventListener("DOMContentLoaded",function(){
	dynamically_set();
	var schoolHeader = document.querySelector(".school-name");
	var charArry = schoolHeader.innerText.split("");

	window.addEventListener("load", function(){
		var loader = document.getElementById("loader");
		loader.classList.add("hide-loader");
	})

	var html = "";
	for( c in charArry ){
		html += "<span>"+charArry[c]+"</span>";
	}
	schoolHeader.innerHTML  = html;
	let char =0;

	let timer = setInterval(onTick, 100);

	function onTick(){
		var span = schoolHeader.getElementsByTagName("span")[char];
		span.classList.add("school-name-fade");
		char++;
		if(char == charArry.length){
			complete();
			return;
		}
	}
	function complete(){
		clearInterval(timer);
		timer = null;
	}

	if(document.getElementById("aside_nav") !=null){
		setUl('aside_nav');
	}
	if(document.getElementById("aside-nav-xm-ul") !=null){
		setUl_xm('aside-nav-xm-ul');
	}
	if(document.getElementById("parent-type") != null){
		var select_element = document.getElementById("parent-type");
		registration_parent_change(select_element);
	}
	if(document.getElementById("already-have-account") !=null){
		already_have_parent_account(document.getElementById("already-have-account"),'parent-details-wrapper','parent-account-field')
	}
	if(document.getElementById('interview-panel')){
		set_interview_date();
	}

	// get goToTop button
	var goToTop = document.getElementById("goToTop");
	// when click the button goto top of the page
	goToTop.addEventListener("click", () => {
		var distance = document.documentElement.scrollTop;
		var per_frame = 100;
		var fps = 10;

		let timer = setInterval(scroll_page, 1000/fps);
		function scroll_page(){
			if(document.documentElement.scrollTop <= 0){
				clearInterval(timer);
				return;
			}
			document.documentElement.scrollTop -= per_frame;
		}
	});
	// check whether page is scroll or not
	setInterval( () => {
		if(document.documentElement.scrollTop > 100){
			goToTop.classList.remove("hide");
		}else{
			goToTop.classList.add("hide");
		}
	},1000)
});

var ul_xm_ids = [];
function setUl_xm(ul_name){
	var ul = document.getElementById(ul_name);
	ul_xm_ids.push(ul);
	var nav_list = ul.getElementsByClassName("aside-xm-li");
	// var nav_list = ul.getElementsByTagName("li");
	for (var j=0; j<nav_list.length; j++){
		nav_list[j].addEventListener("mouseover",change_nav_xm_links);
		nav_list[j].addEventListener("mouseout",change_nav_xm_links_out);
	}
	change_nav_xm_links;
}

function change_nav_xm_links(){
	var nav = this.children[1];
	nav.style.top = this.offsetTop + "px";
	nav.style.left = this.offsetWidth -10+ "px";
	nav.classList.add("collapsed");
	nav.classList.remove("no-collapsed");
}

function change_nav_xm_links_out(){

	this.children[1].classList.add("no-collapsed");
	this.children[1].classList.remove("collapsed");
}

function set_aside_link_selector(ele,target_id){
	target = document.getElementById(target_id);
	target.setAttribute("value",ele.options[ele.selectedIndex].value);
}

function registration_parent_change(select_element){
	var x = document.getElementsByClassName("collapsed")[0];
	x.classList.add('no-collapsed');
	x.classList.remove('collapsed');

	var inputs = x.getElementsByTagName('input');
	// for(var i=0; i<inputs.length;i++){
	// 	if(inputs[i].hasAttribute("required")){
	// 		inputs[i].removeAttribute("required");
	// 		// inputs[i].setAttribute("value","");
	// 	}
	// }
	var type = select_element.value;
	var parent_type = document.getElementById(type);
	parent_type.classList.add("collapsed");
	var inputs = parent_type.getElementsByTagName('input');
	// for(var i=0; i<inputs.length;i++){
	// 	if(!inputs[i].hasAttribute("required")){
	// 		inputs[i].setAttribute("required","required");
	// 	}
	// }

	if(parent_type.classList.contains("no-collapsed")){
		document.getElementById(type).classList.remove("no-collapsed");
	}
}


function already_have_parent_account(checkbox,wrapper_name,acc_input_name){
	var acc_input = document.getElementById(acc_input_name);
	var wrapper = document.getElementById(wrapper_name);

	var inputs = wrapper.getElementsByTagName('input');
	var select = wrapper.getElementsByTagName('select');
	if(checkbox.checked){
		acc_input.classList.add("collapsed");
		acc_input.classList.remove("no-collapsed");
		acc_input.setAttribute("required","required");

		//this not affect to view page
		// if(window.location.href.search("view") < 0){
			for(var i=0; i<inputs.length; i++){
				inputs[i].setAttribute("disabled","disabled");
			}
			select[0].setAttribute("disabled","disabled");
		// }
	}else{
		acc_input.classList.add("no-collapsed");
		acc_input.classList.remove("collapsed");
		acc_input.removeAttribute("required");

		//this not affect to view page
		// if(window.location.href.search("view") < 0){
			for(var i=0; i<inputs.length; i++){
				inputs[i].removeAttribute("disabled");
			}
			select[0].removeAttribute("disabled");
		// }
	}
}

var form_errors = new Array();
// form_errors["birthday"] = true;
// form_errors["contact_number"] = true;

function validate_birthday(element,padding){
	var bday = element.value;
    var regex = /(((19|20)\d\d)-(0[1-9]|1[0-2])-((0|1)[0-9]|2[0-9]|3[0-1]))$/;
    var next_element = element.nextElementSibling;
    if(regex.test(bday)){
    	var parts = bday.split("-");
    	var bday_obj = new Date(bday);
    	var current_date = new Date();
    	if(current_date.getFullYear() - bday_obj.getFullYear() < padding){
    		next_element.style.cssText = "display:inherit !important";
			next_element.innerHTML = "Birthday must be before year " + (current_date.getFullYear() - padding +1);
    	}
    	else{
    		next_element.style.cssText = "display:none !important";
	    	next_element.innerHTML = "";
    	}
    }
}

function validate_contact_number(element){
  	var errors = Array();
	if(isNaN(element.value)){
		errors.push("Contact number must numbers.<br>");
	// }else{
	// 	var regex = /(0(70|71|72|75|76|77|78))+/;
	// 	if(!regex.test(element.value) && element.value.length >2){
 //    		errors.push("Contact number must begin with 070, 071, 072, 075, 076, 077 or 078. <br>");
		}else{
			form_errors.splice('contact_number',1);
			errors = errors.concat(validate_user_input(element,10,10,1));
		// }
	}
	if(errors.length == 0){
		if(element.nextElementSibling != null && element.nextElementSibling.nodeName == "P"){
			var p_ele = element.nextElementSibling;
			p_ele.style.cssText = "display:none !important;";
			p_ele.innerHTML = "";
		}
	}else{
		if(element.nextElementSibling != null && element.nextElementSibling.nodeName == "P"){
			var p_ele = element.nextElementSibling;
			p_ele.style.cssText = "display:inherit !important;";
			p_ele.innerHTML = errors[0];
		}
	}
}

// function check_contact_length_constraint(element,len){
// 	var errors = Array();
// 	if(element.value.length != 0 && element.value.length != len){
// 		errors.push(element.getAttribute("placeholder") + " must be " + len + " characters.<br>");
// 	}
// 	return errors;
// }

//for interview pannel
function interview_add_teacher(element,target){
	var target = document.getElementById(target);
	var num = target.getElementsByTagName("div").length + 1;

	var div = document.createElement('DIV');
	div.setAttribute('id',"teacherid-" + num);
	div.setAttribute("class", "form-group interview-teacher-id");
	var label = document.createElement('LABEL');
	label.innerHTML  = "Teacher ID  (<code title=\"required\"> * </code>)";
	label.setAttribute("for","teacherid-" + num);
	var input = document.createElement("INPUT");
	input.setAttribute("type","text");
	input.setAttribute("placeholder","Teacher ID");
	input.setAttribute("name","teacherid-" + num);
	input.setAttribute("id","teacherid-" + num);
	input.setAttribute("oninput","validate_teacher_id(this,7,7,1)");
	input.addEventListener("input",validate_teacher_id);
	var p = '<p class="bg-red fg-white pl-5 p-2 d-none w-100"></p>';
	var button = `<button type="button" class="mt-2 float-right" onclick="removeElement(
					'teacherid-${num}')" required="required">-remove teacher</button>`;

	div.appendChild(label);
	div.appendChild(input);
	div.insertAdjacentHTML('beforeend',p);
	div.insertAdjacentHTML('beforeend',button);
	target.appendChild(div);
}

function teacher_subject_add(parent_id,add_button){
	var parent = document.getElementById(parent_id);
	var children = parent.children; 
	var count = children.length;

	var html = `<label for="subject-01">Subject-0${count}</label>
					<div class=" d-flex flex-wrap justify-content-between"> 
						<input type="text" name="subject-0${count}-id" id="subject-0${count}-id" class="col-3  d-inline-block" placeholder="Subject ID" oninput="get_subject_data('id',this)">
						<input type="text" name="subject-0${count}-code" id="subject-0${count}-code" class="col-3  d-inline-block" placeholder="Subject Code"  oninput="get_subject_data('code',this)">
						<input type="text" name="subject-0${count}-name" id="subject-0${count}-name" class="col-3  d-inline-block" placeholder="Subject Name" disabled="disabled">
						<input type="hidden" name="old-subject-0${count}-id" id="old-subject-0${count}-id" class="col-3  d-inline-block">
					</div>
					<div class="w-100 justify-content-end d-flex pr-5">
						<button class="btn btn-blue" type="button" onclick="teacher_subject_remove(this)" >- remove subject</button>
					</div>`;
	// parent.innerHTML += html;
	addElement(parent_id,"DIV","","form-group d-flex flex-col border mb-5",html);

}

function teacher_subject_remove(remove_button){
	remove_button.parentElement.parentElement.remove();
	var ids = remove_button.id.split(" ");
	var sub_id=ids[0];
	var tea_id=ids[1];
	if(remove_button.id !=""){
	window.location.replace(base_url+'teacher/subject/list/'+ids[1]);
	}
	var xhr = new XMLHttpRequest();
	xhr.open("GET",base_url+"api/teacher/subject/delete/"+sub_id+"/"+tea_id,true);
	xhr.send();
}

// For interview timetable
document.addEventListener("DOMContentLoaded",function(){
	var interview_timetable = document.getElementById("interview-timetable");
	if(interview_timetable){
		var td = interview_timetable.getElementsByTagName("td");

		for(var i=0; i<td.length; i++){
			td[i].addEventListener("click",interview_timetable_clicked);
		}
	}
});

function interview_timetable_clicked(){
	var input = this.getElementsByTagName('input')[0];
	if(input.value == "0"){
		input.value="1";
		this.classList.add('timetable-select');
		this.classList.remove('timetable-unselect');
	}else{
		input.value="0";
		this.classList.add("timetable-unselect");
		this.classList.remove("timetable-select");
	}
}


function interview_panel_grade(value,target_id,panel_no){

	var target = document.getElementById(target_id);
	if(value == 0){
		target.value = "please select a grade";
		target.style.color = "red";
	}else{
		target.value = "panel-G"+value+"-"+panel_no;
		target.style.color = "black";
	}
}

function set_interview_date(){
	var ele = document.getElementById('interview-panel');
	var target = document.getElementById('interview-date');
	var target2 = document.getElementById("interview-time");
	var options = target.getElementsByTagName("option");
	var day = ele.value;

	if(day == "0")
		target.value = "0";

	for(var i=0; i< options.length; i++){
		if(options[i].classList.contains("show")){
			options[i].classList.remove("show");
			options[i].classList.add("hide");
		}
		if(options[i].getAttribute('op') == day){
			options[i].classList.add("show");
			options[i].classList.remove("hide");
		}
	}
	set_interview_time();
}

function set_interview_time(){
	var panel = document.getElementById('interview-panel');
	var ele = document.getElementById('interview-date');
	var target = document.getElementById("interview-time");
	var options = target.getElementsByTagName("option");
	var day = ele.value.split("#")[1];
	var interview_id = panel.value;
	
	if(day == undefined)
		target.value="0";

	for(var i=0; i< options.length; i++){
		if(options[i].classList.contains("show")){
			options[i].classList.remove("show");
			options[i].classList.add("hide");
		}
		if(options[i].getAttribute('op') == interview_id+"-"+day){
			options[i].classList.add("show");
			options[i].classList.remove("hide");
		}
	}
}

// function upload_profile_photo(id){

// }

function check_input_image(ele){
	var value  = ele.value;
	var submit = document.getElementById("submit");
	if(value == ""){
		var p_ele = ele.nextElementSibling;
		p_ele.style.display = "none";
		ele.parentElement.parentElement.style.border = "none";
		if(submit.hasAttribute("disabled")){
			submit.removeAttribute("disabled");
			submit.style.removeProperty("background");
		}
		return;
	}
	var value = value.substr(value.lastIndexOf("\\")+1,value.length);
	var ext_pos = value.lastIndexOf(".") +1;
	var ext = value.substr(ext_pos,value.length).toLowerCase();

	if(ext == "jpg" || ext == "jpeg" || ext == "png"){
		if(ele.nextElementSibling){
			var p_ele = ele.nextElementSibling;
			ele.parentElement.parentElement.style.border = "2px solid green";
			p_ele.style.cssText += " display:inherit !important;";
			p_ele.style.background = "green";
			p_ele.innerHTML = value;
			if(submit.hasAttribute("disabled")){
				submit.removeAttribute("disabled");
				submit.style.removeProperty("background");
			}
		}
	}else{
		var p_ele = ele.nextElementSibling;
		p_ele.style.cssText += " display:inherit !important;";
		p_ele.style.background = "red";
		p_ele.innerHTML = "Only jpg/jpeg and png files are allowed!";
		ele.parentElement.parentElement.style.border = "2px solid red";
		submit.setAttribute("disabled","disabled");
		submit.style.background = "gray";
	}
}

function validate_user_input(ele,min,max,required=0,err = Array()){
	var errors = err;
	var value = ele.value.trim().length;
	var name = ele.getAttribute("placeholder");
	if(name == null){
		name = "Value";
	}
	if(value == 0 && required ==1 ){
		errors.push("This field is required");
	}
	if(value > max){
		errors.push(name+" must be less than "+max+ " characters");
	}

	if(value < min){
		errors.push(name + " must be "+min+ " characters");
	}

	if(errors.length >0 ){
		if(ele.nextElementSibling != null && ele.nextElementSibling.nodeName == "P"){
			var p_ele = ele.nextElementSibling;
			p_ele.style.cssText = "display:inherit !important;";
			p_ele.innerHTML = errors[0];
			ele.parentElement.style.border = "1px solid red";
			ele.parentElement.style.borderRadius = "5px";
		}else if(ele.nextElementSibling != null && ele.nextElementSibling.nextElementSibling.nodeName == "P"){
			var p_ele = ele.nextElementSibling.nextElementSibling;
			p_ele.style.cssText = "display:inherit !important;";
			p_ele.innerHTML = errors[0];
			ele.parentElement.style.border = "1px solid red";
			ele.parentElement.style.borderRadius = "5px";
		}
	}else{
		if(ele.nextElementSibling != null && ele.nextElementSibling.nodeName == "P"){
			var p_ele = ele.nextElementSibling;
			p_ele.style.cssText = "display:none !important;";
			p_ele.innerHTML = "";
			ele.parentElement.style.border = "none";
		}else if(ele.nextElementSibling != null && ele.nextElementSibling.nextElementSibling.nodeName == "P"){
			var p_ele = ele.nextElementSibling.nextElementSibling;
			p_ele.style.cssText = "display:none !important;";
			p_ele.innerHTML = "";
			ele.parentElement.style.border = "none";

		}
	}
	return errors;
}

function validate_email(ele,min,max,required) {
	var email = ele.value;
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
   	var result = re.test(String(email).toLowerCase());
   	var errors = Array();
   	if(!result){
   		errors.push("Invalid email.");
   	}
	validate_user_input(ele,min,max,required,errors);
}

function update_student_selected_set(checkbox){
	var selected_set = document.getElementById("selected-set");
	var student_id = checkbox.value;
	if(checkbox.checked){
		var element = `<div style="width: 120px; border-radius: 5px;" class="bg-green p-2 m-2 text-center" id="student-${student_id}">
							${student_id}
							<input type="hidden" name="student-${student_id}" value="${student_id}">
						</div>`;
		selected_set.innerHTML += element;
	}else{
		document.getElementById("student-"+student_id).remove();
	}
}
function update_student_removed_set(checkbox){
	var removed_set = document.getElementById("removed-set");
	var student_id = checkbox.value;
	if(!checkbox.checked){
		var element = `<div style="width: 120px; border-radius: 5px;" class="bg-red p-2 m-2 text-center" id="student-${student_id}">
							${student_id}
							<input type="hidden" name="student-${student_id}" value="${student_id}">
						</div>`;
		removed_set.innerHTML += element;
	}else{
		document.getElementById("student-"+student_id).remove();
	}
}

function reset_form(form_id){
	document.getElementById(form_id).reset();
}

function create_subject_code(ele){
	var name = ele.value;
	var medium = document.getElementById('medium').value;
	var grade = document.getElementById('grade').value;
	grade = ("0" + grade).slice(-2); 

	var code = medium.substr(0,1).toUpperCase()+"-";
	code += grade+"-";
	code += name.toUpperCase().substr(0,3);
	document.getElementById('dis_code').value = code;
	document.getElementById('code').value = code;
}

function subject_category(select){
	var div = document.getElementById('div-category');
	if(select.value == "Optional"){
		div.classList.remove('d-none');
	}else{
		div.classList.add('d-none');
	}

}

// classroom attendance comparission
function show_classroom_filter_option_class(ele_id){
	let ele = document.getElementById(ele_id);
	let class_select_div = document.getElementById('classroom_filter_option_class');
	let first_option = class_select_div.querySelector("option");
	let sel = class_select_div.querySelector("select");
	sel.innerHTML = "";
	sel.appendChild(first_option);
	show_classroom_filter_option_date('compare_class');

	if(ele.value == "None" ){
		class_select_div.classList.remove("d-flex");
		class_select_div.classList.add("d-none");
	}else{
		fetch(base_url+"api/attendance/classroom/get/class/"+ele.value,{
			method: "GET"
		}).then( (res)=> {return res.text();})
		.then( (d)=>{
			let data = JSON.parse(d);
			let new_sel = document.createElement("SELECT");
			if(data.success == 1){
				data.data.forEach( (class_data)=>{
					let op = document.createElement("OPTION");
					op.setAttribute("value", class_data.class);
					op.innerText = class_data.class;
					sel.appendChild(op);
				})
			}
		}).catch( (err)=> {
			console.log(err);
		})

		class_select_div.classList.remove("d-none");
		class_select_div.classList.add("d-flex");
	}
}

function show_classroom_filter_option_date(ele_id){
	let date_select_div = document.getElementById('classroom_filter_option_date');
	let full_date = document.getElementById('full_date');
	let ele = document.getElementById(ele_id);
	if(ele.value == "None"){
		date_select_div.classList.remove("d-flex");
		date_select_div.classList.add("d-none");
		full_date.classList.remove("d-none");
		full_date.classList.add("d-flex");	
	}else{
		date_select_div.classList.remove("d-none");
		date_select_div.classList.add("d-flex");	
		full_date.classList.remove("d-flex");
		full_date.classList.add("d-none");
	}
}

if(document.getElementById("subject_student_list")){
	let student_list = document.getElementById("subject_student_list");
	student_list.querySelector("#id_search").addEventListener("input",get_student_for_add_subject);
	student_list.querySelector("#class_search").addEventListener("change",get_student_for_add_subject);
	student_list.querySelector("#select_all").addEventListener("click",select_all);
}

function select_all(){
	let tbody = document.getElementById("tbody");
	tbody.querySelectorAll("input").forEach((chk)=>{
		chk.click();
	})

}

function get_student_for_add_subject(){
	let student_list = document.getElementById("subject_student_list");
	let search_id = student_list.querySelector("#id_search").value;
	let class_id = student_list.querySelector("#class_search").value;
	let teacher_subject_id_hidden = student_list.querySelector("#teacher_subject_id_hidden").value;

	let fd = new FormData();
	fd.append("student_id",search_id);
	fd.append("student_name",search_id);
	fd.append("class_id",class_id);
	fd.append("teacher_subject_id",teacher_subject_id_hidden);

	fetch(base_url+"api/teacher/subject/student/list",{
		method: "POST",
		body: fd
	}).then( (res)=> {return res.json();})
	.then((data)=>{
		if(data.success == 1){
			let tbody = document.getElementById("tbody");
			tbody.innerHTML = "";
			if(data.data.length >0){
				for(i in data.data){
					let student = data.data[i];
					let row = `<tr class="col-12 word-break">
						<td class="col-2 d-flex justify-content-center">${student['id']}</td>
						<td class="col-2 word-break">${student['name_with_initials']}</td>
						<td class="col-2 word-break">${student['email']}</td>
						<td class="col-2  word-break">${student['contact_number']}</td>
						<td class="col-2  word-break d-flex justify-content-center align-items-center"><input type="checkbox" name="assign-${student['id']}" value="${student['id']}" onchange="update_student_selected_set(this)"></td>
						<td class="d-flex align-items-center justify-content-center col-2 text-center word-break"><a class="t-d-none p-1 btn btn-blue" href="set_url("profile/student/${student['id']})">profile</a></td>
						</tr>`;
					tbody.innerHTML += row;
				}
			}else{
				tbody.innerHTML = `<tr class='col-12'>
							<td colspan=6 class='col-12 bg-red'><p class='text-center w-100'>Students Not found...</p></td>
							</tr>`;
			}
		}
	})
	.catch((err)=> {console.log(err)});
}