# Online-School-Management-System 

Please do these steps after clone project:
  1) Change project name as you wish. Example: 'myProject'
  2) Please change /app/config/config.php file according to your project name.
      Change: 
              define('BASE_URL','http://localhost/sms/');
	            define('BASEPATH',$_SERVER["DOCUMENT_ROOT"].DS."sms/");
              
      To: 
              define('BASE_URL','http://localhost/<your project name>/');
	            define('BASEPATH',$_SERVER["DOCUMENT_ROOT"].DS."<your project name>/");
              
            Example:
              define('BASE_URL','http://localhost/myProject/');
	            define('BASEPATH',$_SERVER["DOCUMENT_ROOT"].DS."myProject/");

  3) Download DB file from here. https://drive.google.com/file/d/1LEGSJ2stlcGSCG8ML2T6VahexBBQSw36/view?usp=sharing
    
  4) Create a mysql DB named 'sms-final'
    
  5) Import downloaded sql file to created database.

 Congratulations!!! Now you can use full featured online school management system.
