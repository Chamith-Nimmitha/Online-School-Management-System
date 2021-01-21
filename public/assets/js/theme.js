
document.addEventListener("DOMContentLoaded", function(){
	var link = document.getElementById("user-theme");
	var local_theme = localStorage.getItem('sms_theme');
	var selected_dot = document.querySelector(`#${local_theme}-dot >div`);

	var theme_dots = document.querySelectorAll("#theme-dots-wrapper > div >div");
	if(theme_dots){
		theme_dots.forEach((dot)=>{
			dot.addEventListener("click",(e)=>{
				theme = e.target.dataset.theme;
				setTheme(theme,e.target);
			});
		});
	}

	if(local_theme != null){
		setTheme(local_theme,selected_dot);
	}else{
		setTheme('dark',selected_dot);
	}


	function setTheme(theme,ele){
		if(ele){
			theme_dots.forEach((dot)=>{
				dot.classList.remove("selected_theme_dot");
			});
			ele.classList.add("selected_theme_dot");
		}
		if(theme == "default"){
			link.href = base_url+"public/assets/css/themes/default.css";
		}else if(theme == "blue"){
			link.href = base_url+"public/assets/css/themes/blue.css";
		}else if(theme == "green"){
			link.href = base_url+"public/assets/css/themes/green.css";
		}else if(theme == "dark"){
			link.href = base_url+"public/assets/css/themes/dark.css";
		}
		localStorage.setItem('sms_theme',theme);
	}
});
