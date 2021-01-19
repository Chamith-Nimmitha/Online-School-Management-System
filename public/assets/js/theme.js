
var link = document.getElementById("user-theme");
var local_theme = localStorage.getItem('sms_theme');

if(local_theme != null){
	setTheme(local_theme);
}else{
	setTheme('dark');
}

document.querySelectorAll("#theme-dots-wrapper > div >div").forEach((dot)=>{
	dot.addEventListener("click",(e)=>{
			theme = e.target.dataset.theme;
			setTheme(theme);
	});
});

function setTheme(theme){
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