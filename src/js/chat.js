	var contact_poll_id=null;
	
	$(document).ready(function(){
		contact_poll_id = setInterval("contact_poll()",1000);
	});


	var timeout_id=0;
	var back =getCookie("back");
	switch (back){
		case 0:
			document.body.style.backgroundImage = "url('favicon.ico')";
			console.log("0");
			break;
		case 2:

			break;
		case 1:

			break;
		case 3:

			break;
	}
	function exit_search() {
		contact_poll();
		if(contact_poll_id == null )
			contact_poll_id = setInterval(contact_poll, 1000);
		document.getElementById("search").value = "";
	}
	
	function search() {
		var key = document.getElementById("search").value;
		
		if(key == "" && contact_poll_id != null) {
			exit_search();
			return;
		}
		
		clearInterval(contact_poll_id);
		contact_poll_id = null;
		
		var datatosend = 'key='+key;
		
		$.ajax({
			url: 'src/search.php',
			type: 'POST',
			data: datatosend,
			async: true,
			datatype: 'json',
			success: function(data) {
				console.log(data);
				var parse_data = JSON.parse(data);
				var contacts_html = "";
				if(parse_data[0] != "" ) {
					for( i=0;i<parse_data.length;i++ ) {
						contacts_html += "<li class='person' onclick='oldmsg("+parse_data[i].user_id+",\""+parse_data[i].username+"\""+")'>";
						contacts_html+="<img src=\"/src/assets/bx-user.svg\" alt=\"\" />";
						if( parse_data[i].is_active == 0 )
							contacts_html += "<div class='pelement1' style='background:blue;'></div>";
						else
							contacts_html += "<div class='pelement1' style='background:green;'></div>";
						contacts_html+="<span class=\"name\">"+ parse_data[i].username+"\n<br><br></span>";
							"                </li>";
									}
					$("#contacts").empty();
					$("#contacts").append(contacts_html);
				}
				else {
					exit_search();
				}
			}
		});
	}
	var name2="";
	function oldmsg( receiver_id ,name="") {
		if(contact_poll_id == null ){
			exit_search();
		}
		document.getElementById('send_button').setAttribute('onclick','sendmsg('+receiver_id+')');
		if(name!=""){
			name2=name;
		}
		datatosend = 'rid='+receiver_id;
		$.ajax({
			url: 'src/oldmsg.php',
			type: 'POST',
			data: datatosend,
			async: true,
			datatype: 'json',
			success: function(data) {

				var myElement = document.getElementById("msg");
				var parse_data = JSON.parse(data);
				var box3_html = "";
				var msg="  <div class=\"top\"><span>To: <span class=\"name\">"+name2+"</span></span></div><div class=\"conversation-start\"><span></span></div>";
				for( i=2;i<parse_data.length;i++ ) {
					if( parse_data[i].sender_id == receiver_id )
						msg += "<div class=\"bubble you\">"+parse_data[i].msg+"</div>";
					if( parse_data[i].sender_id == parse_data[1].user_id)
						msg += "<div class=\"bubble me\">"+parse_data[i].msg+"</div>";
				}
				if(myElement){
					var dat = myElement.value;
				}else {
					var dat = "";
				}

				msg +="<div class=\"write\"><input type=\"text\" value='"+dat+"' id='msg' /><a onclick=\"sendmsg("+receiver_id+");\" class=\"write-link send\"id=\"send_button\" style='float: right;'></a></div>";

				$("#pers_cont").empty();
				$("#pers_cont").append(msg);



			},
		});
		
		//newmsg(receiver_id);
		if( timeout_id ) {
			clearInterval(timeout_id);
		}
		timeout_id = setInterval("oldmsg("+receiver_id+")",5000);
	}
	


	function sendmsg(receiver_id) {
		var message = $("#msg").val();
		console.log(message);
		if( message == "" )
			return;
			
		datatosend = 'msg='+message+'&rid='+receiver_id;
		$.ajax({
			url:'src/sendmsg.php',
			type:'POST',
			data:datatosend,
			async:true,
			success:function(data) {
				//document.getElementById("yourmsg").innerHTML=data[0];
			},
		});
		$("#msg").val("");
	}
	
	function contact_poll() {
		$.ajax({
			url: 'src/contact_poll.php',
			type: 'POST',
			datatype: 'json',
			success: function(data) {
				var parse_data = JSON.parse(data);
				var contacts_html = "";
				if( parse_data[0] != "" ) {
					for( i=0;i<parse_data.length;i++ ) {
						contacts_html += "<li class='person' onclick='oldmsg("+parse_data[i].user_id+",\""+parse_data[i].username+"\""+")'>";
						contacts_html+="<img src=\"/src/assets/bx-user.svg\" alt=\"\" />";
						if( parse_data[i].is_active == 0 )
							contacts_html += "<div class='pelement1' style='background:blue;'></div>";
						else
							contacts_html += "<div class='pelement1' style='background:green;'></div>";
						contacts_html+="<span class=\"name\">"+ parse_data[i].username+"\n<br><br></span>";
						"                </li>";
					}
					$("#contacts").empty();
					$("#contacts").append(contacts_html);
				}
			},
			complete:function(data) {
				//setTimeout(contact_poll,5000);
			}
		});
	}

	function setCookie(cname, cvalue, exdays) {
		const d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		let expires = "expires="+ d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}
	function getCookie(cname) {
		let name = cname + "=";
		let decodedCookie = decodeURIComponent(document.cookie);
		let ca = decodedCookie.split(';');
		for(let i = 0; i <ca.length; i++) {
			let c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}
	function settings() {
		var msg ="<br><br><center><h1>Settings</h1><br><br><br></center><h2>Alias manager:<br> <input type='text' id='alias' placeholder='type alias'> <button class=\"button-3\" onclick=\"alias();\" role=\"button\">Set</button> <button class=\"button-3\" style='background: #1e70bf' onclick=\"rngalias();\" role=\"button\">Random</button> <button class=\"button-3\" style='background: black' onclick=\"clearalias();\" role=\"button\">ClearAlias</button><span id='status'></span>";

		msg+="<select id=\"imagepicker\">\n" +
			"    <option value=\"image1\" data-img-src=\"/src/assets/pic1.jpg\">Image 1</option>\n" +
			"    <option value=\"image2\" data-img-src=\"src/assets/pic2.jpg\">Image 2</option>\n" +
			"    <option value=\"image3\" data-img-src=\"back.jpg\">Image 3</option>\n" +
			"    <option value=\"image4\" data-img-src=\"back.jpg\">Image 4</option>\n" +
			"</select><br><br>Profile Pic upload:  &nbsp;&nbsp;&nbsp; <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">" +
			"" +
			"" +
			" <button class=\"button-3\" onclick=\"delete_acc();\" style='position: absolute;top:90%; left: 45%;background: red;' role=\"button\">DELETE ACCOUNT</button>";
		$("#pers_cont").empty();
		$("#pers_cont").append(msg);
		var imagepicker = new BoxImagePicker('#imagepicker', {
			onSelect: function(index, value) {
				if(index==1){
					document.body.style.backgroundImage = "url('/src/assets/pic2.jpg')";
				}
				if(index==0){
					document.body.style.backgroundImage = "url('/src/assets/pic1.jpg')";
				}
				datatosend = 'prof=' + index;
				$.ajax({
					url: 'src/setback.php',
					type: 'POST',
					data: datatosend,
					async: true,
					datatype: 'json',
					success: function (data) {
						$("#status").empty();
						if(data=="error"){
							$("#status").append("Error");
						}else {
							$("#status").append("Succes");
						}
					},
				});

			},
		});

	}
	function clearalias(){
		$.ajax({
			url: 'src/clear.php',
			type: 'POST',
			async: true,
			datatype: 'json',
			success: function (data) {

			},
		});
	}
	function delete_acc(){
		datatosend = 'alias=' + name;
		$.ajax({
			url: 'src/delete_account.php',
			type: 'POST',
			data: datatosend,
			async: true,
			datatype: 'json',
			success: function (data) {
				$("#status").empty();
				if(data=="error"){
					$("#status").append("Error");
				}else {
					$("#status").append("Succes");
				}
			},
		});
	}
	function makeid(length) {
		var result           = '';
		var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		var charactersLength = characters.length;
		for ( var i = 0; i < length; i++ ) {
			result += characters.charAt(Math.floor(Math.random() *
				charactersLength));
		}
		return result;
	}
	function rngalias(){
		var alias = makeid(14);
		datatosend = 'alias=' + alias;
		$.ajax({
			url: 'src/alias.php',
			type: 'POST',
			data: datatosend,
			async: true,
			datatype: 'json',
			success: function (data) {
				$("#status").empty();
				if(data=="error"){
					$("#status").append("Error");
				}else {
					$("#status").append("Succes "+alias+" ");
				}
			},
		});
	}
	function alias() {
		name=document.getElementById("alias").value;
		datatosend = 'alias=' + name;
		$.ajax({
			url: 'src/alias.php',
			type: 'POST',
			data: datatosend,
			async: true,
			datatype: 'json',
			success: function (data) {
				$("#status").empty();
				if(data=="error"){
					$("#status").append("Error");
				}else {
					$("#status").append("Succes");
				}
			},
		});
	}
	function fix(){

		document.getElementById("top").style.height  = "175px";
	}