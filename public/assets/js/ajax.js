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
	xhr.open("POST",base_url+"api/admission/parent/validation",true);
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.onload = function(){
		if( this.status == 200){
			var response = xhr.responseText;
			console.log(response);
			if(response.indexOf("false") !== -1){
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
					ele.parentElement.style.border = "1px solid green";
				}
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
	if(validate_user_input(ele,7,7,1).length == 0){
		var data = {parent_id:id};
		xhr.send(JSON.stringify(data));
	}
}

function admission_search(page=null,per_page=null){
	e = window.event;
	e.preventDefault();
	var value = document.getElementById("admission-search").value;
	var type = document.getElementById("admission-state").value;
	var xhr = new XMLHttpRequest();
	var tbody =document.getElementById('tbody');
	xhr.open("POST",base_url+"api/admission/search",true);
	xhr.setRequestHeader("Content-Type", "application/json");
	var func = "admission_search";
	var route = "admission/list";

	// for loader
	var loader = document.querySelector("#admission_list_useful>.loader");
	loader.classList.remove('hide-loader');
	xhr.addEventListener("readystatechange", ()=>{
		if(xhr.readyState !== 4){
			loader.classList.remove('hide-loader');
		}else{
			loader.classList.add('hide-loader');
		}
	})// end of loader


	xhr.onload = function(){
		var respond = xhr.responseText;
		if(this.status == 200){
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST",base_url+"api/pagination",true);
			xhr2.setRequestHeader("Content-Type", "application/json");
			xhr2.onload = function(){
				if(this.status == 200){
					var respond_p = xhr2.responseText;
					var pagination =document.getElementById('pagination');
					var row_count = document.getElementById('row_count');
					var pagination_data =document.getElementById('pagination_data');
					row_count.textContent = count;
					pagination_data.innerHTML = respond_p;
				}
			}
			var count = respond.count;
			if(page == null){
				var data2 = {route:route, count:count,func:func};
			}else{
				var data2 = {route:route,count:count,page:page,per_page:per_page,func:func};
			}
			xhr2.send( JSON.stringify(data2) );
		}else{
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;			
		}
	}

	if(page == null){
		var data = {type:type,id:value};
	}else{
		var data = {type:type,id:value,page:page,per_page:per_page};
	}
	xhr.send( JSON.stringify(data) );
}

function admission_search_unuseful(page=null,per_page=null){
	e = window.event;
	e.preventDefault();
	var value = document.getElementById("u-admission-search").value;
	var type = document.getElementById("u-admission-state").value;
	var xhr = new XMLHttpRequest();
	var tbody =document.getElementById('u-tbody');
	xhr.open("POST",base_url+"api/admission/u_search",true);
	xhr.setRequestHeader("Content-Type", "application/json");
	var func = "admission_search_unuseful";
	var route = "admission/list";

	// for loader
	var loader = document.querySelector("#admission_list_unuseful>.loader");
	loader.classList.remove('hide-loader');
	xhr.addEventListener("readystatechange", ()=>{
		if(xhr.readyState !== 4){
			loader.classList.remove('hide-loader');
		}else{
			loader.classList.add('hide-loader');
		}
	})// end of loader


	xhr.onload = function(){
		var respond = xhr.responseText;
		if(this.status == 200){
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST",base_url+"api/pagination",true);
			xhr2.setRequestHeader("Content-Type", "application/json");
			xhr2.onload = function(){
				if(this.status == 200){
					var respond_p = xhr2.responseText;
					var pagination =document.getElementById('u_pagination');
					var row_count = document.getElementById('u_row_count');
					var pagination_data =document.getElementById('u_pagination_data');
					row_count.textContent = count;
					pagination_data.innerHTML = respond_p;
				}
			}
			var count = respond.count;
			if(page == null){
				var data2 = {route:route, count:count,func:func};
			}else{
				var data2 = {route:route,count:count,page:page,per_page:per_page,func:func};
			}
			xhr2.send( JSON.stringify(data2) );
		}else{
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;			
		}
	}

	if(page == null){
		var data = {type:type,id:value};
	}else{
		var data = {type:type,id:value,page:page,per_page:per_page};
	}
	xhr.send( JSON.stringify(data) );
}


// // call admission_search in pagination
// function admission_search_pagination(button){
// 	var page = button.dataset.page;
// 	var per_page = button.dataset.perPage;
// }

function get_subject_data(field,input){
	var input_value = input.value;
	var inputs = input.parentNode.getElementsByTagName("input");
	var xhr = new XMLHttpRequest();
	//var resquest = base_url+"include/getdata/get_subject_info.php?"+field+"="+input_value;
	xhr.open("GET",base_url+"api/teacher/subject/"+input_value,true);
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
	var data = {id:value,code:nameVal};
	xhr.send();
}


//  search student with pagination
function student_search(page=null,per_page=null){
	window.event.preventDefault();
	var target_div = document.getElementById("student-list-table");
	var idVal =document.getElementById("student-id").value;
	var nameVal =idVal
	var gradeVal = document.getElementById("grade").value;;
	var classVal = document.getElementById("class").value;;
	var route = "student/list";
	var func = "student_search";
	if(idVal.length == 0){
		var idVal = "";
	}
	if(nameVal.length == 0){
		var nameVal = "";
	}

	var xhr = new XMLHttpRequest();
	xhr.open("POST", base_url+`api/student/search`, true);
	xhr.setRequestHeader("Content-Type", "application/json");

	// for loader
	var loader = document.querySelector(".loader");
	loader.classList.remove('hide-loader');
	xhr.addEventListener("readystatechange", ()=>{
		if(xhr.readyState !== 4){
			loader.classList.remove('hide-loader');
		}else{
			loader.classList.add('hide-loader');
		}
	})// end of loader
	
	xhr.onload = function(){
		if(this.status == 200){
			var response = this.responseText; 
			response = JSON.parse(response);
			target_div.innerHTML = response['rows'];

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST",base_url+"api/pagination",true);
			xhr2.setRequestHeader("Content-Type", "application/json");
			xhr2.onload = function(){
				if(this.status == 200){
					var respond_p = xhr2.responseText;
					var pagination =document.getElementById('pagination');
					var row_count = document.getElementById('row_count');
					var pagination_data =document.getElementById('pagination_data');
					row_count.textContent = count;
					pagination_data.innerHTML = respond_p;
				}
			}
			var count = response.count;
			if(page == null){
				var data2 = {route:route, count:count, func:func};
			}else{
				var data2 = {route:route,count:count,page:page,per_page:per_page,func:func};
			}
			xhr2.send( JSON.stringify(data2) );
		}
	}
	if(page == null){
		var data = {id:idVal,name:nameVal,grade:gradeVal,class:classVal};
	}else{
		var data = {id:idVal,name:nameVal,grade:gradeVal,class:classVal,page:page,per_page:per_page};
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

// for classroom list page
function classroom_search(page=null, per_page=null){
	e = window.event;
	e.preventDefault();
	var id = document.getElementById("classroom-id").value;
	var grade = document.getElementById("grade").value;
	var classroom = document.getElementById("class").value;
	var xhr = new XMLHttpRequest();
	var tbody =document.getElementById('tbody');
	xhr.open("POST",base_url+"api/classroom/search",true);
	xhr.setRequestHeader("Content-Type", "application/json");
	var func = "classroom_search";
	var route = "classroom/list";

	// for loader
	var loader = document.querySelector(".loader");
	loader.classList.remove('hide-loader');
	xhr.addEventListener("readystatechange", ()=>{
		if(xhr.readyState !== 4){
			loader.classList.remove('hide-loader');
		}else{
			loader.classList.add('hide-loader');
		}
	})// end of loader


	xhr.onload = function(){
		var respond = xhr.responseText;
		if(this.status == 200){
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST",base_url+"api/pagination",true);
			xhr2.setRequestHeader("Content-Type", "application/json");
			xhr2.onload = function(){
				if(this.status == 200){
					var respond_p = xhr2.responseText;
					var pagination =document.getElementById('pagination');
					var row_count = document.getElementById('row_count');
					var pagination_data =document.getElementById('pagination_data');
					row_count.textContent = count;
					pagination_data.innerHTML = respond_p;
				}
			}
			var count = respond.count;
			if(page == null){
				var data2 = {route:route, count:count,func:func};
			}else{
				var data2 = {route:route,count:count,page:page,per_page:per_page,func:func};
			}
			xhr2.send( JSON.stringify(data2) );
		}else{
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;			
		}
	}

	if(page == null){
		var data = {id:id,grade:grade,classroom:classroom};
	}else{
		var data = {id:id,grade:grade,classroom:classroom,page:page,per_page:per_page};
	}
	xhr.send( JSON.stringify(data) );
}

// for attendance page
function attendance_classroom_search(page=null, per_page=null){
	e = window.event;
	e.preventDefault();
	var id = document.getElementById("classroom-id").value;
	var grade = document.getElementById("grade").value;
	var classroom = document.getElementById("class").value;
	var xhr = new XMLHttpRequest();
	var tbody =document.getElementById('tbody');
	xhr.open("POST",base_url+"api/attendance/classroom/search",true);
	xhr.setRequestHeader("Content-Type", "application/json");
	var func = "attendance_classroom_search";
	var route = "classroom/list";

	// for loader
	var loader = document.querySelector(".loader");
	loader.classList.remove('hide-loader');
	xhr.addEventListener("readystatechange", ()=>{
		if(xhr.readyState !== 4){
			loader.classList.remove('hide-loader');
		}else{
			loader.classList.add('hide-loader');
		}
	})// end of loader


	xhr.onload = function(){
		var respond = xhr.responseText;
		if(this.status == 200){
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST",base_url+"api/pagination",true);
			xhr2.setRequestHeader("Content-Type", "application/json");
			xhr2.onload = function(){
				if(this.status == 200){
					var respond_p = xhr2.responseText;
					var pagination =document.getElementById('pagination');
					var row_count = document.getElementById('row_count');
					var pagination_data =document.getElementById('pagination_data');
					row_count.textContent = count;
					pagination_data.innerHTML = respond_p;
				}
			}
			var count = respond.count;
			if(page == null){
				var data2 = {route:route, count:count,func:func};
			}else{
				var data2 = {route:route,count:count,page:page,per_page:per_page,func:func};
			}
			xhr2.send( JSON.stringify(data2) );
		}else{
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;			
		}
	}

	if(page == null){
		var data = {id:id,grade:grade,classroom:classroom};
	}else{
		var data = {id:id,grade:grade,classroom:classroom,page:page,per_page:per_page};
	}
	xhr.send( JSON.stringify(data) );
}

function subject_search(page=null, per_page=null){
	e = window.event;
	e.preventDefault();
	var id = document.getElementById("subject-id").value;
	var grade = document.getElementById("grade").value;
	var medium = document.getElementById("medium").value;
	var xhr = new XMLHttpRequest();
	var tbody =document.getElementById('tbody');
	xhr.open("POST",base_url+"api/subject/search",true);
	xhr.setRequestHeader("Content-Type", "application/json");
	var func = "subject_search";
	var route = "subject/list";

	// for loader
	var loader = document.querySelector(".loader");
	loader.classList.remove('hide-loader');
	xhr.addEventListener("readystatechange", ()=>{
		if(xhr.readyState !== 4){
			loader.classList.remove('hide-loader');
		}else{
			loader.classList.add('hide-loader');
		}
	})// end of loader


	xhr.onload = function(){
		var respond = xhr.responseText;
		if(this.status == 200){
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST",base_url+"api/pagination",true);
			xhr2.setRequestHeader("Content-Type", "application/json");
			xhr2.onload = function(){
				if(this.status == 200){
					var respond_p = xhr2.responseText;
					var pagination =document.getElementById('pagination');
					var row_count = document.getElementById('row_count');
					var pagination_data =document.getElementById('pagination_data');
					row_count.textContent = count;
					pagination_data.innerHTML = respond_p;
				}
			}
			var count = respond.count;
			if(page == null){
				var data2 = {route:route, count:count,func:func};
			}else{
				var data2 = {route:route,count:count,page:page,per_page:per_page,func:func};
			}
			xhr2.send( JSON.stringify(data2) );
		}else{
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;			
		}
	}

	if(page == null){
		var data = {id:id,grade:grade,medium:medium};
	}else{
		var data = {id:id,grade:grade,medium:medium,page:page,per_page:per_page};
	}
	xhr.send( JSON.stringify(data) );
}

function parent_search(page=null, per_page=null){
	e = window.event;
	e.preventDefault();
	var id = document.getElementById("parent-id").value;
	var occupation = document.getElementById("occupation").value;
	var xhr = new XMLHttpRequest();
	var tbody =document.getElementById('tbody');
	xhr.open("POST",base_url+"api/parent/search",true);
	xhr.setRequestHeader("Content-Type", "application/json");
	var func = "parent_search";
	var route = "parent/list";

	// for loader
	var loader = document.querySelector(".loader");
	loader.classList.remove('hide-loader');
	xhr.addEventListener("readystatechange", ()=>{
		if(xhr.readyState !== 4){
			loader.classList.remove('hide-loader');
		}else{
			loader.classList.add('hide-loader');
		}
	})// end of loader

	xhr.onload = function(){
		var respond = xhr.responseText;
		if(this.status == 200){
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST",base_url+"api/pagination",true);
			xhr2.setRequestHeader("Content-Type", "application/json");
			xhr2.onload = function(){
				if(this.status == 200){
					var respond_p = xhr2.responseText;
					var pagination =document.getElementById('pagination');
					var row_count = document.getElementById('row_count');
					var pagination_data =document.getElementById('pagination_data');
					row_count.textContent = count;
					pagination_data.innerHTML = respond_p;
				}
			}
			var count = respond.count;
			if(page == null){
				var data2 = {route:route, count:count,func:func};
			}else{
				var data2 = {route:route,count:count,page:page,per_page:per_page,func:func};
			}
			xhr2.send( JSON.stringify(data2) );
		}else{
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.body;			
		}
	}

	if(page == null){
		var data = {id:id,occupation:occupation};
	}else{
		var data = {id:id,occupation:occupation,page:page,per_page:per_page};
	}
	xhr.send( JSON.stringify(data) );
}

function teacher_search(page=null,per_page=null){
	var value = document.getElementById("teacher-id").value;
	var nameVal =value;
	var xhr = new XMLHttpRequest();
	var tbody =document.getElementById("tbody");
	xhr.open("POST",base_url+"api/teacher/search",true);
	xhr.setRequestHeader("Content-Type", "application/json");
	var func = "teacher_search";
	var route = "teacher/list";
	if(value.length == 0){
		var value = "";
	}
	if(nameVal.length == 0){
		var nameVal = "";
	}
	// for loader
	var loader = document.querySelector(".loader");
	loader.classList.remove('hide-loader');
	xhr.addEventListener("readystatechange", ()=>{
		if(xhr.readyState !== 4){
			loader.classList.remove('hide-loader');
		}else{
			loader.classList.add('hide-loader');
		}
	})// end of loader


	xhr.onload = function(){
		var respond = this.responseText;
		if(this.status == 200){
			respond = JSON.parse(respond);
			tbody.innerHTML = respond['rows'];

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST",base_url+"api/pagination",true);
			xhr2.setRequestHeader("Content-Type", "application/json");
			xhr2.onload = function(){
				if(this.status == 200){
					var respond_p = xhr2.responseText;
					var pagination =document.getElementById('pagination');
					var row_count = document.getElementById('row_count');
					var pagination_data =document.getElementById('pagination_data');
					row_count.textContent = count;
					pagination_data.innerHTML = respond_p;
				}
			}
			var count = respond.count;
			if(page == null){
				var data2 = {route:route, count:count,func:func};
			}else{
				var data2 = {route:route,count:count,page:page,per_page:per_page,func:func};
			}
			xhr2.send( JSON.stringify(data2) );
		}else{
			respond = JSON.parse(respond);
			tbody.innerHTML = respond.rows;			
		}
	}

	if(page == null){
		var data = {id:value,name:nameVal};
	}else{
		var data = {id:value,name:nameVal,page:page,per_page:per_page};
	}
	xhr.send( JSON.stringify(data) );
}


function teacher_search_pagination(button){
	var page = button.dataset.page;
	var per_page = button.dataset.perPage;
}

// classroom attendance search
function classroom_attendance_search(){
	window.event.preventDefault();
	var form = new FormData(document.getElementById("attendance_filter"));

	fetch(base_url+"api/attendance/classroom/student/search", {
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		document.getElementById('tbody').innerHTML = text;
		var date = document.getElementById('date').value;
		if(date.length != 0 ){
			document.getElementById('attendance_date').innerHTML = date;
		}else{
			document.getElementById('attendance_date').innerHTML = new Date().toISOString().slice(0, 10);
		}
		document.getElementById('date_hidden').value = date
	}).catch( ( error) => {
		console.error(error)
	})
}

// mark clasroom attendance
function mark_classroom_attendance(){
	window.event.preventDefault();
	var form = new FormData(document.getElementById("mark_attendance"));
	var notification = document.getElementById("attendance_notification");
	notification.classList.remove("d-none");
	notification.querySelector("p").innerHTML = "Updating. Please wait...";

	fetch(base_url+"api/attendance/classroom/mark", {
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		console.log(text)
		if( text.indexOf('TRUE') !== -1){
			notification.querySelector("p").innerHTML = "Attendance marked successfully.";
		}else{;
			notification.querySelector("p").innerHTML = text;
		}
	}).catch( ( error) => {
		console.error(error)
	})
}

// filter attendance by year,month,week for specific student
function student_attendance_filter(){
	window.event.preventDefault();
	var form = new FormData(document.getElementById("student_attendance_filter"));
	var tbody = document.getElementById("tbody");

	// for loader
	var loader = document.querySelector("#attendance_table .loader");
	loader.classList.remove('hide-loader');

	fetch(base_url+"api/attendance/student/filter",{
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		tbody.innerHTML = "";
		if( text.indexOf("FALSE") !== -1 || text.length === 0){
			tbody.innerHTML = `<tr><td colspan=8 class='text-center bg-red'>Attendance not found...</td></tr>`
		}else{
			var result_set = JSON.parse(text);
			for (var i in result_set ){
				row = "<tr>";
				row += `<td>${parseInt(i)+1}</td>`;
				row += `<td>${result_set[i]['date']}</td>`;
				row += `<td>`;
				if( result_set[i]['attendance'] == 1){
					row += `Present`;
				}else{
					row += `Absent`;
				}
				row += `</td>`;
				row += `<td>${result_set[i]['note']}</td>`;
				row += "</tr>";

				tbody.innerHTML += row;
			}
		}
		loader.classList.add('hide-loader');
	})
}

// mark teacher attendance
function mark_teacher_attendance(){
	window.event.preventDefault();
	var form = new FormData(document.getElementById("mark_teacher_attendance"));
	var notification = document.getElementById("attendance_notification");
	notification.classList.remove("d-none");
	notification.querySelector("p").innerHTML = "Updating. Please wait...";
	fetch(base_url+"api/attendance/teacher/mark", {
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		console.log(text)
		if( text.indexOf('TRUE') !== -1){
			notification.querySelector("p").innerHTML = "Attendance marked successfully.";
		}else{;
			notification.querySelector("p").innerHTML = text;
		}
	}).catch( ( error) => {
		console.error(error)
	})
}

// teacher attendance search
function teacher_attendance_search(){
	window.event.preventDefault();
	var form = new FormData(document.getElementById("attendance_filter"));

	fetch(base_url+"api/attendance/teacher/search", {
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		document.getElementById('tbody').innerHTML = "";
		if( text.indexOf('FALSE') === -1){
			var response = JSON.parse(text);
			for(let i in response) {
				var body = `<tr>
						<td>${parseInt(i)+1}</td>
						<td>${response[i]['id']}</td>
						<td>${response[i]['date']}</td>
						<td>${response[i]['name_with_initials']}</td>
						<td class='d-flex flex-col'>
	                        <label for='present-${response[i]['id']}'>
	                            <input type='radio' id='present-${response[i]['id']}' name='attendance-${response[i]['id']}' value='1'`
                            if(response[i]['attendance'] == 1){
                            	body += "checked='checked'";
                            }
                    body += `> Present
	                        </label>
	                        <label for='absent-${response[i]['id']}'>
	                            <input type='radio' id='absent-${response[i]['id']}' name='attendance-${response[i]['id']}' value='0'`;
                            if(response[i]['attendance'] == 0){
                            	body += "checked='checked'";
                            }
                    body += `> Absent
	                        </label>
	                    </td>
						<td><input type='text' name='note-${response[i]['id']}' value='${response[i]['note']}'></td>
	            		<td> <a href='`+base_url+`teacher/attendance/${response[i]['id']}' class='btn btn-blue'>View Report</a></td>
					</tr>`;
				document.getElementById('tbody').innerHTML += body;
			}
		}else{
			document.getElementById('tbody').innerHTML += `<tr><td colspan=8 class='text-center bg-red'>Attendance not found...</td></tr>`;
		}
		var date = document.getElementById('date').value;
		document.getElementById('attendance_date').innerHTML = date;
		// document.getElementById('date_hidden').value = date
	}).catch( ( error) => {
		console.error(error)
	})
}

// filter attendance by year,month,week for specific teacher
function teacher_attendance_filter(){
	window.event.preventDefault();
	var form = new FormData(document.getElementById("teacher_attendance_filter"));
	var tbody = document.getElementById("tbody");

	// for loader
	var loader = document.querySelector("#attendance_table .loader");
	loader.classList.remove('hide-loader');

	fetch(base_url+"api/attendance/teacher/filter",{
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		tbody.innerHTML = "";
		if( text.indexOf("FALSE") !== -1 || text.length === 0){
			tbody.innerHTML = `<tr><td colspan=4 class='text-center bg-red'>Attendance not found...</td></tr>`
		}else{
			var result_set = JSON.parse(text);
			for (var i in result_set ){
				row = "<tr>";
				row += `<td>${parseInt(i)+1}</td>`;
				row += `<td>${result_set[i]['date']}</td>`;
				row += `<td>`;
				if( result_set[i]['attendance'] == 1){
					row += `Present`;
				}else{
					row += `Absent`;
				}
				row += `</td>`;
				row += `<td>${result_set[i]['note']}</td>`;
				row += "</tr>";

				tbody.innerHTML += row;
			}
		}
		loader.classList.add('hide-loader');
	})
}