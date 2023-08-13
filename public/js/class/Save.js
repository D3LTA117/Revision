class Save {
  save() {
    const email = document.querySelector("#email");
    const newEmail = document.querySelector("#newEmail");
    const password = document.querySelector("#password");
    const newPassword = document.querySelector("#newPassword");
    const password_confirme = document.querySelector("#password_confirme");
    const newSubmit = document.querySelector("#newSubmit");
    const submit = document.querySelector("#submit");

    if (email) {
      email.addEventListener("keyup", (e) => {
        sessionStorage.setItem("email", e.target.value);
      });

      newEmail.addEventListener("keyup", (e) => {
        sessionStorage.setItem("newEmail", e.target.value);
      });

      password.addEventListener("keyup", (e) => {
        sessionStorage.setItem("password", e.target.value);
      });

      newPassword.addEventListener("keyup", (e) => {
        sessionStorage.setItem("newPassword", e.target.value);
      });

      password_confirme.addEventListener("keyup", (e) => {
        sessionStorage.setItem("password_confirme", e.target.value);
      });

      newSubmit.addEventListener("submit", this.getSave());
      submit.addEventListener("submit", this.getSave());
    } else {
      sessionStorage.clear();
    }
  }

  getSave() {
    email.value = sessionStorage.getItem("email");
    newEmail.value = sessionStorage.getItem("newEmail");
    password.value = sessionStorage.getItem("password");
    newPassword.value = sessionStorage.getItem("newPassword");
    password_confirme.value = sessionStorage.getItem("password_confirme");
  }
}

export default Save;
