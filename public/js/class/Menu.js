class Menu {
  menu() {
    const icons = document.querySelector(".icons");
    const menuBurger = document.querySelector(".menuBurger");

    icons.onclick = () => {
      menuBurger.classList.toggle("active");
    };

    // Pour supprimer la classe "active" quand la fenêtre est redimensionnée
    window.addEventListener("resize", (e) => {
      menuBurger.classList.remove("active");
    });
  }
}

export default Menu;
