postman links :-
http://localhost/myprojects/codeigniter/index.php/api/auth/token

http://localhost/myprojects/codeigniter/index.php/api/auth/login - post
body :- {
	"username":"admin",
	"password":"123456"
}

http://localhost/myprojects/codeigniter/index.php/api/auth/get_me_data - post
header :- {
	content-type : application/json,
	Authorization : eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImFkbWluIn0.NMQ24Kye8d0HUF_gEjxubPQwocM1q_WhZTUjm2IGIEs
}
