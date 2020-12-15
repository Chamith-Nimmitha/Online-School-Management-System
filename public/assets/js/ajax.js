var parent_id_field = document.getElementById("parent-account-id");
if(parent_id_field){
	parent_id_field.addEventListener("input",validate_parent_id);
}
var divs = document.getElementsByClassName("interview-teacher-id");
for( var i=0; i < divs.length; i++ ){
		divs[i].getElementsByTagName('input')[0].addEventListener("input",validate_teacher_id);
}

function validate_teacher_id(){
	var id = this.value;
	var ele = this;
	var xhr = new XMLHttpRequest();
	xhr.open("GET","../php/getdata/get_teacher_info.php?id="+id,true);

	xhr.onload = function(){
		errors = validate_user_input(ele,7,7,1);
		if(errors.length == 0 ){
			var response = xhr.responseText;
			console.log(response);
			if(response.search("invalid") != -1){
				if(ele.nextElementSibling != null && ele.nextElementSibling.nodeName == "P"){
					var p_ele = ele.nextElementSibling;
					p_ele.style.cssText = "display:inherit !important;";
					if(p_ele.innerHTML.length == 0){
						p_ele.innerHTML += "Invalid id.";
					}
					ele.parentElement.style.border = "1px solid red";
					ele.parentElement.style.borderRadius = "5px";
				}
			}else{
				if(ele.nextElementSibling != null && ele.nextElementSibling.nodeName == "P"){
					var p_ele = ele.nextElementSibling;
					p_ele.style.cssText = "display:none !important;";
					p_ele.innerHTML = "";
					ele.parentElement.style.border = "none";
				}
			}
		}
	}
	xhr.send();
}

function validate_parent_id(){
	var id = this.value;
	var ele = this;
	var xhr = new XMLHttpRequest();
	xhr.open("GET","../php/validation/parent_id_validation.php?id="+id,true);
	xhr.onload = function(){
		var response = xhr.responseText;
		if(validate_user_input(ele,7,7,1).length == 0){
			if(response != "ok"){
				if(ele.nextElementSibling != null && ele.nextElementSibling.nodeName == "P"){
					var p_ele = ele.nextElementSibling;
					p_ele.style.cssText = "display:inherit !important;";
					if(p_ele.innerHTML.length == 0){
						p_ele.innerHTML += "Invalid id.";
					}
					ele.parentElement.style.border = "1px solid red";
					ele.parentElement.style.borderRadius = "5px";
				}
			}else{
				if(ele.nextElementSibling != null && ele.nextElementSibling.nodeName == "P"){
					var p_ele = ele.nextElementSibling;
					p_ele.style.cssText = "display:none !important;";
					p_ele.innerHTML = "";
					ele.parentElement.style.border = "none";
				}
			}
		}
	}
	xhr.send();
}

function admission_search(input){
	var value = input.value;
	var type = document.getElementById("admission-state").value;
	var xhr = new XMLHttpRequest();
	xhr.open("POST",base_url+"api/admission/search",true);
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.onload = function(){
		if(this.status == 200){
			var respond = xhr.responseText;
			document.getElementById('tbody').innerHTML = respond;
		}
	}
	xhr.onerror = function(){
		console.log(xhr.error);
	}
	var data = {type:type,value:value};
	xhr.send( JSON.stringify(data) );
}

function get_subject_data(field,input){
	var input_value = input.value;
	var inputs = input.parentNode.getElementsByTagName("input");
	var xhr = new XMLHttpRequest();
	var resquest = base_url+"include/getdata/get_subject_info.php?"+field+"="+input_value;
	xhr.open("GET",resquest,true);
	xhr.onload = function(){
		if(this.status == 200){
			var response = xhr.responseText;
			if(response.search("error") != -1){
				inputs[0].value = "";
				inputs[1].value = "";
				inputs[2].value = "";
				input.value = input_value;
			}else{
				response = JSON.parse(response);
				inputs[0].value = response['id'];
				inputs[1].value = response['code'];
				inputs[2].value = response['name'];
			}
		}
	}

	xhr.onerror = function(){
		console.log("error");
	}
	xhr.send();
}

function get_teacher_data(field,input){
	var value = input.value;
	var xhr = new XMLHttpRequest();
	var inputs = input.parentNode.parentNode.getElementsByTagName("input");
	xhr.open("GET","../php/getdata/get_teacher_info.php?"+field+"="+value,true);
	xhr.onload = function(){
		if(this.status == 200){
			var response = this.responseText;
			if(response.search("invalid") == -1){
				response = JSON.parse(response);
				inputs[0].value = response["id"];
				inputs[1].value = response["name_with_initials"];
			}else{
				inputs[0].value = "";
				inputs[1].value = "";

				input.value = value;
			}
		}
	}
	xhr.send();
}


// without pagination
function get_student_data2(target_id,id="",name="",grade="",className=""){
	var target_div = document.getElementById(target_id);
	var idVal ="";
	var nameVal ="";
	var gradeVal ="";
	var classVal ="";
	if(id !== ""){
		var idVal = document.getElementById(id).value;
	}
	if(name !== ""){
		var nameVal = document.getElementById(name).value;
	}
	if(grade !== ""){
		var gradeVal = document.getElementById(grade).value;
		if(gradeVal === "all"){
			gradeVal = "";
		}
	}
	if(className !== ""){
		var classVal = document.getElementById(className).value;
		if(classVal === "all"){
			classVal ="";
		}
	}

	var xhr = new XMLHttpRequest();
	xhr.open("POST", base_url+`api/student/search`, true);
	xhr.setRequestHeader("Content-Type", "application/json");
	var data = {id:idVal,name:nameVal,grade:gradeVal,class:classVal};
	xhr.onload = function(){
		if(this.status == 200){
			var response = this.responseText; 
			if(response.search("FALSE") == -1){
				response = JSON.parse(response);
				target_div.innerHTML = "";
				for ( var i=0; i < response.length; i++){
					var row = `<tr>
					 <td>${response[i]['id']}</td>
					 <td>${response[i]['name_with_initials']}</td>
					 <td class="text-center">${response[i]['grade']}</td>
					 <td class="text-center">${response[i]['class']}</td>
					 <td>${response[i]['contact_number']}</td>
					 <td>${response[i]['is_deleted']}</td>
					 <td class='text-center'><a href='admin_student_timetable_view.php?student_id=${response[i]['id']}' class='btn btn-blue t-d-none p-1'>timetable</a></td>
					 <td class='text-center'><a href='admin_student_profile.php?student-id=${response[i]['id']}' class='btn btn-blue t-d-none p-1'>profile</a></td>
					 <td class='text-center'><a href='student_marks_report.php?student-id=${response[i]['id']}' class='btn btn-blue t-d-none p-1'>profile</a></td>
					 <td class='text-center'><a href='student_list.php?delete=${response[i]['id']}' class='btn btn-lightred t-d-none p-1'>delete</a></td></tr>`;
					target_div.innerHTML += row ;
				}
			}else{
				target_div.innerHTML = `
							<tr'>
								<td colspan=10 class='bg-red'><p class='text-center w-100'>Students Not found...</p></td>
							</tr>`;
			}
		}
	}
	xhr.send( JSON.stringify(data));
}

// get classrooms grades according to section category
function get_classroom_grades(category_ele,target_id){
	var grade_sel = document.getElementById(target_id);
	var category = category_ele.value;

	var xhr = new XMLHttpRequest();
	xhr.open("GET",base_url+"api/classroom/grade/"+category,true);

	xhr.onload = function(){
		if( this.status == 200 ){
			var response = xhr.responseText;
			if( response.search("FALSE") === -1 ){
				grades = JSON.parse(response);
				grade_sel.innerHTML = `<option value="">select</option>`;
				for( var i in grades ){
					var option = `<option value="${grades[i]['id']}">${grades[i]['grade']}</option>`;
					grade_sel.innerHTML += option;
				}
			}
		}
	}
	xhr.send();
}

