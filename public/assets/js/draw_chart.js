
// load charts when DOM finished load
document.addEventListener("DOMContentLoaded",() => {
	if( document.getElementById('dashboard_student_attendance_doughnut') ){
		dashboard_student_attendance_doughnut();
		dashboard_teacher_attendance_doughnut();
		dashboard_classroom_student_attendance_bar();
		dashboard_teacher_attendance_bar();
	}
	
	if( document.getElementById('student_attendance_overview_bar')){
		student_attendance_overview_bar();
	}
	if( document.getElementById('teacher_attendance_overview_bar')){
		teacher_attendance_overview_bar();
	}
	if( document.getElementById('classroom_attendance_comparission_bar')){
		classroom_attendance_comparission_bar();
	}
	if( document.getElementById('subject_grades_pie')){
		subject_grades_pie();
	}
	if( document.getElementById('student_result_overview_bar')){
		student_result_overview_bar();
	}
	if(document.getElementById('subject_average_overview_bar')){
		subject_average_overview_bar();
	}
})

function get_color_array(len,opacity,position = 0){
	var colors = [	
					'rgba(255, 99, 132,'+ opacity +')',
	              	'rgba(54, 162, 235,'+ opacity +')',
	              	'rgba(255, 206, 86,'+ opacity +')',
	              	'rgba(75, 192, 192,'+ opacity +')',
	              	'rgba(153, 102, 255,'+ opacity +')'
	              ];
	var num_of_colors = colors.length;
	var start = position % num_of_colors;
	var bgColors = [];
	for(var i= start; i<len+start; i++){
		bgColors.push(colors[i%num_of_colors]);
	}
	return bgColors;
}

function load_dashboard_attendacne(){
	dashboard_student_attendance_doughnut();	
	dashboard_teacher_attendance_doughnut();	
}

function dashboard_student_attendance_doughnut(){
	var ctx = document.getElementById('dashboard_student_attendance_doughnut').getContext('2d');
	var form = new FormData( document.getElementById('dashboard_attendance_filter') );

	// for loader
	var loader = document.querySelector("#dashboard_student_attendance_doughnut_loader");
	loader.classList.remove('hide-loader');

	fetch(base_url+"api/draw_charts/dashboard/attendance/student",{
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		if( text.indexOf("FALSE") === -1){
			var response = JSON.parse(text);
			var myChart = new Chart(ctx, {
			    type: 'doughnut',
			    data: {
			        labels: ['present','absent'],
			        datasets: [{
			            labels: '# of students',
			            data: [response.present, response.absent],
			            backgroundColor: "white",
			            backgroundColor: [get_color_array(1,0.5,3),get_color_array(1,0.5)],
			            borderColor: [get_color_array(1,0.8,3),get_color_array(1,0.8)],
			            borderWidth: 1,
			            hoverBackgroundColor:[get_color_array(1,1,3),get_color_array(1,1)],
			            hoverboderwidth:3,
			            hoverbodercolor: [get_color_array(1,1,3),get_color_array(1,1)]
			        }]
			    },
			    options: {
			        scales: {
			            display:false
			        },
			        title: {
				        display: true,
				        text: "Student attendance",
				        fontSize : 20
				    },
			    }
			});
		}
		
		loader.classList.add('hide-loader');
		
	})	
}

function dashboard_teacher_attendance_doughnut(){
	var ctx = document.getElementById('dashboard_teacher_attendance_doughnut').getContext('2d');
	var form = new FormData( document.getElementById('dashboard_attendance_filter') );
	// for loader
	var loader = document.querySelector("#dashboard_teacher_attendance_doughnut_loader");
	loader.classList.remove('hide-loader');

	fetch(base_url+"api/draw_charts/dashboard/attendance/teacher",{
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		if( text.indexOf("FALSE") === -1){
			var response = JSON.parse(text);
			var myChart = new Chart(ctx, {
			    type: 'doughnut',
			    data: {
			        labels: ['present','absent'],
			        datasets: [{
			            labels: '# of students',
			            data: [response.present, response.absent],
			            backgroundColor: "white",
			            backgroundColor: [get_color_array(1,0.5,3),get_color_array(1,0.5)],
			            borderColor: [get_color_array(1,0.8,3),get_color_array(1,0.8)],
			            borderWidth: 1,
			            hoverBackgroundColor:[get_color_array(1,1,3),get_color_array(1,1)],
			            hoverboderwidth:3,
			            hoverbodercolor: [get_color_array(1,1,3),get_color_array(1,1)]
			        }]
			    },
			    options: {
			        scales: {
			            display:false
			        },
			        title: {
				        display: true,
				        text: "Student attendance",
				        fontSize : 20
				    },
			    }
			});
		}
		
		loader.classList.add('hide-loader');
		
	})
}

function dashboard_classroom_student_attendance_bar(){

	fetch( base_url+ "api/draw_charts/attendance/student/week",{
		method: "GET",
	}).then( res => {
		return res.json();
	}).then( data=> {
		if(data.success==1){
			let attendance = data.data;
			let present_data = [];
			let absent_data = [];
			let labels = ['mon','tue','wed','thu','fri'];
			for (i in attendance) {
				present_data.push( attendance[i].present);
				absent_data.push( attendance[i].absent);
				labels[i] = labels[i]+`(${attendance[i].day})`;
			}
			var ctx = document.getElementById('dashboard_classroom_student_attendance_bar').getContext('2d');
			var myChart = new Chart(ctx, {
			    type: 'bar',
			    data: {
			        labels: labels,
			        datasets: [{
			            label: '# of Student Present: ',
			            data: present_data,
			          	backgroundColor: get_color_array(5,0.5),
			            borderColor: get_color_array(5,0.8),
			            borderWidth: 1,
			            hoverBackgroundColor:get_color_array(5,1),
			            hoverboderwidth:3,
			            hoverbodercolor: get_color_array(5,1)
			        },
			        {
			            label: '# of Student Absent: ',
			            data: absent_data,
			          	backgroundColor: get_color_array(5,0.5),
			            borderColor: get_color_array(5,0.8),
			            borderWidth: 1,
			            hoverBackgroundColor:get_color_array(5,1),
			            hoverboderwidth:3,
			            hoverbodercolor: get_color_array(5,1)
			        }]
			    },
			    options: {
			        scales: {
			        	xAxes:[{
			        		stacked: true,
			        	}],
			            yAxes: [{
			            	stacked: true,
			            	ticks: {
			            		beginAtZero : true,
			            		precision: 0,
			            	}
			            }]
			        },
			        legend: {
			        	display : false
			        },
			        title: {
				        display: true,
				        text: "Week Attendance of Students",
				        fontSize : 20
				    },
			    }
			});	
		}
	}).catch( err=> {
		console.log(err);
	})

	
}

function dashboard_teacher_attendance_bar(){

	fetch( base_url+ "api/draw_charts/attendance/teacher/week",{
		method: "GET",
	}).then( res => {
		return res.json();
	}).then( data=> {
		if(data.success==1){
			let attendance = data.data;
			let present_data = [];
			let absent_data = [];
			let labels = ['mon','tue','wed','thu','fri'];
			for (i in attendance) {
				present_data.push( attendance[i].present);
				absent_data.push( attendance[i].absent);
				labels[i] = labels[i]+`(${attendance[i].day})`;
			}
			var ctx = document.getElementById('dashboard_teacher_attendance_bar').getContext('2d');
			var myChart = new Chart(ctx, {
			    type: 'bar',
			    data: {
			        labels: labels,
			        datasets: [{
			            label: '# of Teacher Present: ',
			            data: present_data,
			          	backgroundColor: get_color_array(5,0.5),
			            borderColor: get_color_array(5,0.8),
			            borderWidth: 1,
			            hoverBackgroundColor:get_color_array(5,1),
			            hoverboderwidth:3,
			            hoverbodercolor: get_color_array(5,1)
			        },
			        {
			            label: '# of Teacher Absent: ',
			            data: absent_data,
			          	backgroundColor: get_color_array(5,0.5),
			            borderColor: get_color_array(5,0.8),
			            borderWidth: 1,
			            hoverBackgroundColor:get_color_array(5,1),
			            hoverboderwidth:3,
			            hoverbodercolor: get_color_array(5,1)
			        }]
			    },
			    options: {
			        scales: {
			        	xAxes:[{
			        		stacked: true,
			        	}],
			            yAxes: [{
			            	stacked: true,
			            	ticks: {
			            		beginAtZero : true,
			            		precision: 0,
			            	}
			            }]
			        },
			        legend: {
			        	display : false
			        },
			        title: {
				        display: true,
				        text: "Week Attendance of Teachers",
				        fontSize : 20
				    },
			    }
			});	
		}
	}).catch( err=> {
		console.log(err);
	})
}

var subject_grades_pie_chart = undefined;
function subject_grades_pie(){
	var form = new FormData( document.getElementById('dashboard_marks_filter') );
	var classroom_id = document.getElementById('marks_classroom_id').value;

	fetch(base_url+"api/draw_charts/dashboard/marks/student/"+classroom_id,{
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		if( text.indexOf("FALSE") === -1){
			var response = JSON.parse(text);

			var canvas = document.getElementById('subject_grades_pie')
			var ctx = canvas.getContext('2d');
			ctx.clearRect(0, 0, canvas.width, canvas.height);
			if(subject_grades_pie_chart != undefined){
				subject_grades_pie_chart.destroy();
			}

			var myChart = new Chart(ctx, {
			    type: 'pie',
			    data: {
			        labels: ['75-100 (A) ','65-74 (B) ','50-64 (C) ','35-49 (S) ','0-34 (F) '],
			        datasets: [{
			            label: '# of students',
			            data: [response.A,response.B,response.C,response.S,response.F],
			          	backgroundColor: get_color_array(5,0.5),
			            borderColor: get_color_array(5,0.8),
			            borderWidth: 1,
			            hoverBackgroundColor:get_color_array(5,1),
			            hoverboderwidth:3,
			            hoverbodercolor: get_color_array(5,1)
			        }]
			    },
			    options: {
			        scales: {
			            display : false
			        },
			        legend: {
			        	display : true
			        },
			        title: {
				        display: true,
				        text: "Subject Result Overview",
				        fontSize : 20
				    },
			    }
			});
			subject_grades_pie_chart = myChart;
}
})
}

function student_result_overview_bar(){

var classroom_id = document.getElementById('marks_classroom_id').value;
var grade = document.getElementById('marks_classroom_grade').value;
	fetch(base_url+"api/draw_charts/dashboard/marks/barchart/"+classroom_id+"/"+grade,{
		//method : 'post',
		//body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
	var ctx = document.getElementById('student_result_overview_bar').getContext('2d');
	var response = JSON.parse(text)
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: response.label,
	        datasets: [
	        	{
	            	label: '1st Term ',
	            	data : response.first_term_data,
	            	backgroundColor : get_color_array(1,0.5,0)[0],
	            	hoverBackgroundColor : get_color_array(1,1,0)[0]
	            },
	            {
	            	label: '2nd Term ',
	            	data : response.second_term_data,
	            	backgroundColor : get_color_array(1,0.5,1)[0],
	            	hoverBackgroundColor : get_color_array(1,1,1)[0]
	            },
	            {
	            	label: '3rd Term',
	            	data : response.third_term_data,
	            	backgroundColor : get_color_array(1,0.5,2)[0],
	            	hoverBackgroundColor : get_color_array(1,1,2)[0]
	            }
	        ]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	            	ticks: {
	            		beginAtZero : true,
	            		precision: 0,
	            	}
	            }]
	        },
	        legend: {
	        	display : true
	        },
	        title: {
		        display: true,
		        text: "Number of Passed Students (above 40 marks)",
		        fontSize : 20
		    },
	    }
	});
})
}

function subject_average_overview_bar(){

var classroom_id = document.getElementById('marks_classroom_id').value;
var grade = document.getElementById('marks_classroom_grade').value;
	fetch(base_url+"api/draw_charts/dashboard/marks/subject-avg/"+classroom_id+"/"+grade,{
		//method : 'post',
		//body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
	var ctx = document.getElementById('subject_average_overview_bar').getContext('2d');
	var response = JSON.parse(text)
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: response.label,
	        datasets: [
	        	{
	            	label: '1st Term ',
	            	data : response.first_term_data,
	            	backgroundColor : get_color_array(1,0.5,0)[0],
	            	hoverBackgroundColor : get_color_array(1,1,0)[0]
	            },
	            {
	            	label: '2nd Term ',
	            	data : response.second_term_data,
	            	backgroundColor : get_color_array(1,0.5,1)[0],
	            	hoverBackgroundColor : get_color_array(1,1,1)[0]
	            },
	            {
	            	label: '3rd Term',
	            	data : response.third_term_data,
	            	backgroundColor : get_color_array(1,0.5,2)[0],
	            	hoverBackgroundColor : get_color_array(1,1,2)[0]
	            }
	        ]
	    },
	    options: {
	        scales: {
	            yAxes: [{
	            	ticks: {
	            		beginAtZero : true,
	            	}
	            }]
	        },
	        legend: {
	        	display : true
	        },
	        title: {
		        display: true,
		        text: "Subject Average",
		        fontSize : 20
		    },
	    }
	});
})
}

// before redraw destroy the existing charts, otherwise charts are overlaped
var student_attendance_overview_bar_chart = undefined;

// for view individual student attendance
function student_attendance_overview_bar(){

	var form = new FormData(document.getElementById('student_attendance_overview'));

	// for loader
	var loader = document.querySelector("#attendance_bar .loader");
	loader.classList.remove('hide-loader');


	fetch( base_url+'api/draw_charts/attendance/student',{
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		var response = JSON.parse(text)
		var canvas = document.getElementById('student_attendance_overview_bar')
		var ctx = canvas.getContext('2d');
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		if(student_attendance_overview_bar_chart != undefined){
			student_attendance_overview_bar_chart.destroy();
		}
		var myChart = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: response.labels,
		        datasets: [
		        	{
		            	label: 'Present ',
		            	data : response.data.present,
		            	backgroundColor : get_color_array(1,0.5,0)[0],
		            	hoverBackgroundColor : get_color_array(1,1,0)[0]
		            },
		            {
		            	label: 'Absent ',
		            	data : response.data.absent,
		            	backgroundColor : get_color_array(1,0.5,1)[0],
		            	hoverBackgroundColor : get_color_array(1,1,1)[0]
		            },
		            {
		            	label: 'Classroom Average ',
		            	data : response.data.present_presentage,
		            	backgroundColor : get_color_array(1,0.5,2)[0],
		            	hoverBackgroundColor : get_color_array(1,1,2)[0]
		            }
		        ]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		            	ticks: {
		            		beginAtZero : true,
		            	}
		            }]
		        },
		        legend: {
		        	display : true
		        },
		        title: {
			        display: true,
			        text: "Student Attendance overview",
			        fontSize : 20
			    },
		    }
		});
		student_attendance_overview_bar_chart = myChart;
		loader.classList.add('hide-loader');
	});	
}


// before redraw destroy the existing charts, otherwise charts are overlaped
var teacher_attendance_overview_bar_chart = undefined;
// for view individual student attendance
function teacher_attendance_overview_bar(){

	var form = new FormData(document.getElementById('teacher_attendance_overview'));

	// for loader
	var loader = document.querySelector("#attendance_bar .loader");
	loader.classList.remove('hide-loader');


	fetch( base_url+'api/draw_charts/attendance/teacher',{
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		var response = JSON.parse(text)
		var canvas = document.getElementById('teacher_attendance_overview_bar')
		var ctx = canvas.getContext('2d');
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		if(teacher_attendance_overview_bar_chart != undefined){
			teacher_attendance_overview_bar_chart.destroy();
		}
		var myChart = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: response.labels,
		        datasets: [
		        	{
		            	label: 'Present ',
		            	data : response.data.present,
		            	backgroundColor : get_color_array(1,0.5,0)[0],
		            	hoverBackgroundColor : get_color_array(1,1,0)[0]
		            },
		            {
		            	label: 'Absent ',
		            	data : response.data.absent,
		            	backgroundColor : get_color_array(1,0.5,1)[0],
		            	hoverBackgroundColor : get_color_array(1,1,1)[0]
		            }
		        ]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		            	ticks: {
		            		beginAtZero : true,
		            	}
		            }]
		        },
		        legend: {
		        	display : true
		        },
		        title: {
			        display: true,
			        text: "Teacher Attendance overview",
			        fontSize : 20
			    },
		    }
		});
		teacher_attendance_overview_bar_chart = myChart;
		loader.classList.add('hide-loader');
	});	
}

var student_attendance_overview_bar_chart = undefined;
// view classroom overral attendance
function classroom_attendance_comparission_bar(){
	var form = new FormData(document.getElementById('classroom_attendance_comparission'));
	let form_array = Array.from(form);
	// for loader
	var loader = document.querySelector("#classroom_attendance_bar");
	loader.classList.remove('hide-loader');


	fetch( base_url+'api/draw_charts/attendance/classroom/comparission',{
		method : 'post',
		body : form
	}).then( (res) => {
		return res.text();
	}).then( (text) => {
		var response = JSON.parse(text)
		var canvas = document.getElementById('classroom_attendance_comparission_bar')
		var ctx = canvas.getContext('2d');
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		if(student_attendance_overview_bar_chart != undefined){
			student_attendance_overview_bar_chart.destroy();
		}
		if(response.success==1){
			let present_data = [];
			let absent_data = [];
	        let flag = false;
	        let title = "";
	        let data = JSON.parse(JSON.stringify(response.data));
	        if(response.type == "section"){
	        	flag = true;
	        	title = `Grade ${form_array[0][1]} ( ${form_array[2][1]} )`;
		        for( i in data){
		        	present_data.push(data[i].present);
		        	absent_data.push(data[i].absent);
		        }
	        }else if(response.type == "school"){
	        	flag = false;
	        	title = `School Attendance ( ${form_array[2][1]} )`;
	        	present_data.push(data.present[0]);
	        	absent_data.push(data.absent[0]);
	        }else if(response.type == "classroom"){
	        	flag = true;
	        	title = `Classroom Attendance ( ${form_array[0][1]}-${form_array[1][1]} )`;
	        	present_data = data.present;
	        	absent_data =data.absent;
	        }

			var myChart = new Chart(ctx, {
			    type: 'bar',
			    data: {
			        labels: response.labels,
			        datasets: [
			        	{
			            	label: 'Present ',
			            	data : present_data,
			            	backgroundColor : get_color_array(1,0.5,0)[0],
			            	hoverBackgroundColor : get_color_array(1,1,0)[0]
			            },
			            {
			            	label: 'Absent ',
			            	data : absent_data,
			            	backgroundColor : get_color_array(1,0.5,1)[0],
			            	hoverBackgroundColor : get_color_array(1,1,1)[0]
			            },
			        ]
			    },
			    options: {
			        scales: {
			        	xAxes: [{
			        		stacked: flag,
			        	}],
			            yAxes: [{
			        		ticks:{
			        			beginAtZero:true,
			        		},
			            	stacked: flag,
			            }]
			        },
			        legend: {
			        	display : true
			        },
			        title: {
				        display: true,
				        text: title,
				        fontSize : 20
				    },
			    }
			});
		}
		student_attendance_overview_bar_chart = myChart;
		loader.classList.add('hide-loader');
	});	
}