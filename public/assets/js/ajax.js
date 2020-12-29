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

