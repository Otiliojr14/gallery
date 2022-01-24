import { userInput, passwordInput, formLogin } from "./selectors.js";

window.onload = () => {
  formLogin.addEventListener("submit", validateLogin);
};

function validateLogin(e) {
  e.preventDefault();

  if (userInput.value === "" || passwordInput.value === "") {
    swal({
      type: "error",
      title: "Error!",
      text: "Empty fields",
    });
  } else {
    const user = userInput.value;
    const password = passwordInput.value;

    const data = new FormData();
    data.append("user", user);
    data.append("password", password);

    // AJAX

    const xhr = new XMLHttpRequest();

    xhr.open("POST", "./models/model-login.php", true);

    xhr.onload = function () {
      if (this.status === 200) {
        var response = JSON.parse(xhr.responseText);

        if (response.response === "correct") {
          swal({
            type: "success",
            title: "Sucessful login",
            text: "Press OK to go to the dashboard",
          }).then((result) => {
            if (result.value) {
              window.location.href = "index.php";
            }
          });
        } else {
          swal({
            type: "error",
            title: "Error!",
            text: "Your password or user are incorrect",
          });
        }
      }
    };

    xhr.send(data);
  }
}
