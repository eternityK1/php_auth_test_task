document.addEventListener("DOMContentLoaded", function () {
    function get_user_data(user_id) {
        fetch("/api/get_user_info.php", {
            method: "GET",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            credentials: "same-origin",
        })
            .then(response => response.text())
            .then(data => {
                document.getElementById("content").innerHTML = data;
            })
            .catch((error) => {
                console.error("Error:", error);
            });

    }



    document.getElementById("auth_form")?.addEventListener("submit", function (e) {
        e.preventDefault();
        document.getElementById("form_error").innerHTML = "";
        document.getElementById("submit").disabled = true;
        document.getElementById("submit").classList.add("disable");
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;

        fetch("/api/auth.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            credentials: "same-origin",
            body: `username=${username}&password=${password}`
        })
            .then(response => response.json())
            .then(data => {
                if (data.auth) {
                    get_user_data(data.user_id)
                    document.getElementById("notification").classList.add("show");

                    setTimeout(()=>{
                        document.getElementById("notification")?.classList.remove("show");
                    }, 10000);
                }
                else if (data.error === "limit") {
                    document.getElementById("form_error").innerHTML = "Limit requests";
                }
                else if (data.error === "password") {
                    document.getElementById("form_error").innerHTML = "Incorrect password or login";

                }
            })
            .catch((error) => {
                console.error("Error:", error);
            })
            .finally(() => {
                document.getElementById("submit").disabled = false;
                document.getElementById("submit").classList.remove("disable");
            });
    });


});


function logout() {
    document.cookie = "user_id=; key=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    location.reload();
}