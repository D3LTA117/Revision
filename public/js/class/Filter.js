class Filter {
  filter() {
    const searchBar = document.querySelector("#searchBar");

    if (searchBar) {
      const tableRows = document.querySelectorAll("#cards tr.listCards");

      searchBar.addEventListener("keyup", (e) => {
        tableRows.forEach((row) => {
          let foundMatch = false;

          const columns = row.querySelectorAll("td:not(.supprimer)"); // Exclure la colonne avec la classe "supprimer"

          columns.forEach((column) => {
            const columnText = column.textContent.toLowerCase();
            let filter = e.target.value.toLowerCase();

            if (columnText.includes(filter)) {
              foundMatch = true;
            }
          });

          if (foundMatch) {
            row.style.display = "";
          } else {
            row.style.display = "none";
          }
        });
      });
    }
  }
}

export default Filter;
