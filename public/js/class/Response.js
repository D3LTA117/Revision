class Response {
  response() {
    const response = document.querySelector(".response");
    const hidden = document.querySelector(".hidden");

    if (response) {
      response.onclick = () => {
        response.style.display = "none";
        hidden.style.display = "flex";
      };
    }
  }
}

export default Response;
