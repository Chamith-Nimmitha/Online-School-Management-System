
document.addEventListener("DOMContentLoaded",() => {
	dashboard_student_attendance();
	dashboard_teacher_attendance();
})

function dashboard_student_attendance(){
	var ctx = document.getElementById('dashboard_student_attendance').getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'doughnut',
	    data: {
	        labels: ['present','absent'],
	        datasets: [{
	            label: '# of teachers',
	            data: [906, 105],
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
	        }
	    }
	});
}

function dashboard_teacher_attendance(){
	var ctx = document.getElementById('dashboard_teacher_attendance').getContext('2d');
	var myChart = new Chart(ctx, {
	    type: 'doughnut',
	    data: {
	        labels: ['present','absent'],
	        datasets: [{
	            label: '# of teachers',
	            data: [90, 10],
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
	        }
	    }
	});
}