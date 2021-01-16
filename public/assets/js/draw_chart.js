
// load charts when DOM finished load
document.addEventListener("DOMContentLoaded",() => {
	if( document.getElementById('dashboard_student_attendance_doughnut') ){
		dashboard_student_attendance_doughnut();
		dashboard_teacher_attendance_doughnut();
		dashboard_classroom_student_attendance_bar();
		dashboard_teacher_attendance_bar();
		subject_grades_pie();
		student_result_overview_bar();
	}
	if( document.getElementById('student_attendance_overview_bar')){
		student_attendance_overview_bar();
	}
	if( document.getElementById('teacher_attendance_overview_bar')){
		teacher_attendance_overview_bar();
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
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.5)',
			                'rgba(54, 162, 235, 0.5)',
			            ],
			            borderColor: [
			                'rgba(255, 99, 132, 0.8)',
			                'rgba(54, 162, 235, 0.8)',
			            ],
			            borderWidth: 1,
			            hoverBackgroundColor:[
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			            ],
			            hoverboderwidth:3,
			            hoverbodercolor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			            ]
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
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.5)',
			                'rgba(54, 162, 235, 0.5)',
			            ],
			            borderColor: [
			                'rgba(255, 99, 132, 0.8)',
			                'rgba(54, 162, 235, 0.8)',
			            ],
			            borderWidth: 1,
			            hoverBackgroundColor:[
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			            ],
			            hoverboderwidth:3,
			            hoverbodercolor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			            ]
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
	var ctx = document.getElementById('dashboard_classroom_student_attendance_bar').getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: ['mon','tue','wed','thu','fri'],
	        datasets: [{
	            label: '# of students',
	            data: [25,42,32,12,54],
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
	            yAxes: [{
	            	ticks: {
	            		beginAtZero : true,
	            	}
	            }]
	        },
	        legend: {
	        	display : false
	        },
	        title: {
		        display: true,
		        text: "Attendance of students",
		        fontSize : 20
		    },
	    }
	});
}

function dashboard_teacher_attendance_bar(){
	var ctx = document.getElementById('dashboard_teacher_attendance_bar').getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: ['mon','tue','wed','thu','fri'],
	        datasets: [{
	            label: '# of teachers',
	            data: [25,42,32,12,54],
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
	            yAxes: [{
	            	ticks: {
	            		beginAtZero : true,
	            	}
	            }]
	        },
	        legend: {
	        	display : false
	        },
	        title: {
		        display: true,
		        text: "Attendance of teachers",
		        fontSize : 20
		    },
	    }
	});
}

function subject_grades_pie(){
	var ctx = document.getElementById('subject_grades_pie').getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'pie',
	    data: {
	        labels: ['75-100 (A) ','65-74 (B) ','50-64 (C) ','35-49 (S) ','0-34 (F) '],
	        datasets: [{
	            label: '# of students',
	            data: [25,42,32,12,54],
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
		        text: "Subject result overview",
		        fontSize : 20
		    },
	    }
	});
}

function student_result_overview_bar(){
	var ctx = document.getElementById('student_result_overview_bar').getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'bar',
	    data: {
	        labels: ['Sinhala','Buddhism','History','Maths','Science','English'],
	        datasets: [
	        	{
	            	label: '1st ',
	            	data : [12,13,14,15,16,17],
	            	backgroundColor : get_color_array(1,0.5,0)[0],
	            	hoverBackgroundColor : get_color_array(1,1,0)[0]
	            },
	            {
	            	label: '2nd ',
	            	data : [12,13,14,15,16,17],
	            	backgroundColor : get_color_array(1,0.5,1)[0],
	            	hoverBackgroundColor : get_color_array(1,1,1)[0]
	            },
	            {
	            	label: '3rd ',
	            	data : [12,13,14,15,16,17],
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
		        text: "Subject result overview",
		        fontSize : 20
		    },
	    }
	});
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
