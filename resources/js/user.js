function register(firstname, lastname, email, password, repeatedpassword) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("message").innerHTML = "<p class='text-success'>Your Registration worked go to login:</p>";

        } else if (this.readyState == 4 && this.status == 400) {
            document.getElementById("message").innerHTML = "<p class='text-danger'>Your Registration failed</p>";
        } else if (this.readyState == 4 && this.status == 422) {
            document.getElementById("message").innerHTML = "<p class='text-danger'>" + this.responseText + "</p>";
        } else if (this.readyState !== 4) {
            document.getElementById("message").innerHTML = "<div class='spinner-grow text-primary' role='status'><span class='sr-only'>Loading...</span></div>";
        }
    };


    xhttp.open("POST", "/lb_02/backend/user/createUser.php", true);
    xhttp.send(JSON.stringify({
        firstname: firstname,
        lastname: lastname,
        email: email,
        password: password,
        repeatedpassword: repeatedpassword
    }));
}


function login(email, password, hashed) {
    //Ajax call
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            localStorage.setItem("user", this.responseText);
            location.href = "/lb_02/dashboard/index.html";
        } else if (this.readyState == 4 && this.status == 500) {
            document.getElementById("messagelogin").innerHTML = "<p class='text-danger'>Your Login failed</p>";
        } else if (this.readyState == 4 && this.status == 422) {
            document.getElementById("messagelogin").innerHTML = "<p class='text-danger'>" + this.responseText + "</p>";
        } else if (this.readyState == 4 && this.status == 502) {
            document.getElementById("messagelogin").innerHTML = "<p class='text-danger'>" + this.responseText + "</p>";
        } else if (this.readyState !== 4) {
            document.getElementById("messagelogin").innerHTML = "<div class='spinner-grow text-primary' role='status'><span class='sr-only'>Loading...</span></div>";
        }

    }
    xhttp.open("POST", "/lb_02/backend/user/checkLogin.php", true);

    xhttp.send(JSON.stringify({
        email: email,
        password: password,
        hashed: hashed
    }));
}

function setname(name) {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            location.reload();


        } else if (this.readyState == 4 && this.status == 500) {
            document.getElementById("messagename").innerHTML = "<p class='text-danger'>Oops... Something went wrong</p>";
        } else if (this.readyState == 4 && this.status == 422) {
            document.getElementById("messagename").innerHTML = "<p class='text-danger'>" + this.responseText + "</p>";
        } else if (this.readyState == 4 && this.status == 502) {
            document.getElementById("messagename").innerHTML = "<p class='text-danger'>" + this.responseText + "</p>";
        } else if (this.readyState !== 4) {
            document.getElementById("messagename").innerHTML = "<div class='spinner-grow text-primary' role='status'><span class='sr-only'>Loading...</span></div>";
        }

    }
    xhttp.open("POST", "/lb_02/backend/user/setName.php", true);

    xhttp.send(JSON.stringify({
        name: name
    }));
}

function getnames(trash) {


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            let names = JSON.parse(this.responseText);
            console.table(names);

            if (!names) {
                document.getElementById("error").innerHTML = "<p class='text-danger h3 text-center'>no names stored in database</p>";


            } else {


                document.getElementById("shownames").innerHTML = "";

                names.forEach(names => {
                    document.getElementById("shownames").innerHTML += " <tr><td> " + names.nameid + "</td><td> " + names.name + "</td></tr>";
                });
            }

        } else if (this.readyState == 4 && this.status == 500) {
            document.getElementById("shownames").innerHTML = "<p class='text-danger'>Oops... Something went wrong</p>";
        } else if (this.readyState == 4 && this.status == 422) {
            document.getElementById("shownames").innerHTML = "<p class='text-danger'>" + this.responseText + "</p>";
        } else if (this.readyState == 4 && this.status == 502) {
            document.getElementById("shownames").innerHTML = "<p class='text-danger'>" + this.responseText + "</p>";
        } else if (this.readyState !== 4) {
            document.getElementById("shownames").innerHTML = "<div class='spinner-grow text-primary' role='status'><span class='sr-only'>Loading...</span></div>";
        }

    }
    xhttp.open("POST", "/lb_02/backend/user/getnames.php", true);

    xhttp.send(JSON.stringify({
        trash: trash
    }));
}











function deleteuser(email, password) {

    var temp = JSON.parse(localStorage.getItem('user'));

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
            localStorage.removeItem('user');
            document.getElementById("deletemessage").innerHTML = "<p class='text-success'>Successfully deleted your account</p>";
            location.href = "/lb_02/index.html"
        } else if (this.readyState == 4 && this.status == 501) {
            document.getElementById("deletemessage").innerHTML = "<p class='text-danger'>Oops... Something went wrong</p>"
        } else if (this.readyState == 4 && this.status == 502) {
            document.getElementById("deletemessage").innerHTML = "<p class='text-danger'>Oops... Something went wrong</p>"
        } else if (this.readyState == 4 && this.status == 503) {
            document.getElementById("deletemessage").innerHTML = "<p class='text-danger'>Oops... Something went wrong</p>"
        } else if (this.readyState == 4 && this.status == 422) {
            document.getElementById("deletemessage").innerHTML = "<p class='text-danger'>" + this.responseText + "</p>";
        } else if (this.readyState !== 4) {
            document.getElementById("deletemessage").innerHTML = "<div class='spinner-grow text-primary' role='status'><span class='sr-only'>Loading...</span></div>";
        }
    };

    xhttp.open('POST', '/lb_02/backend/user/deleteuser.php', true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhttp.send(
        JSON.stringify({
            userid: temp.userid,
            cemail: temp.email,
            cpassword: temp.password,
            email: email,
            password: password
        })
    )
}



function changenamecheck(changefirstname, changelastname) {

    var temp = JSON.parse(localStorage.getItem('user'));

    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
            localStorage.removeItem('user');
            localStorage.setItem("user", this.responseText);
            document.getElementById("changeusermessage").innerHTML = "<p class='text-success'>Successfully changed your name</p>";
        } else if (this.readyState == 4 && this.status == 501) {
            document.getElementById("changeusermessage").innerHTML = "<p class='text-danger'>Oops... Something went wrong</p>"
        } else if (this.readyState == 4 && this.status == 502) {
            document.getElementById("changeusermessage").innerHTML = "<p class='text-danger'>Oops... Something went wrong</p>"
        } else if (this.readyState == 4 && this.status == 503) {
            document.getElementById("changeusermessage").innerHTML = "<p class='text-danger'>Oops... Something went wrong</p>"
        } else if (this.readyState == 4 && this.status == 422) {
            document.getElementById("changeusermessage").innerHTML = "<p class='text-danger'>" + this.responseText + "</p>";
        } else if (this.readyState !== 4) {
            document.getElementById("changeusermessage").innerHTML = "<div class='spinner-grow text-primary' role='status'><span class='sr-only'>Loading...</span></div>";
        }
    };

    xhttp.open('POST', '/lb_02/backend/user/changeuser.php', true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhttp.send(
        JSON.stringify({
            firstname: changefirstname,
            lastname: changelastname,
            cfirstname: temp.firstname,
            clastname: temp.lastname,
            cuserid: temp.userid,
            cemail: temp.email,
            cpassword: temp.password
        })
    )
}






function checkedifloggedin() {
    if (localStorage.getItem('user') == null || localStorage.user == undefined) {
        location.href = "../index.html";
    }

    if (!localStorage.getItem('user')) {
        location.href = "/lb_02/index.html";

    }

}



function logout() {
    localStorage.removeItem("user");
    location.href = "/lb_02/";
}

function openusersettings() {
    location.href = "/lb_02/dashboard/main/include/pages/user_settings.php";
}


function openindex() {
    location.href = "/lb_02/dashboard/index.html";
}