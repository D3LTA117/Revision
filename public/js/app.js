"use strict";

import Menu from "./class/Menu.js";
import Filter from "./class/Filter.js";
import Response from "./class/Response.js";
import Save from "./class/Save.js";

window.addEventListener("DOMContentLoaded", () => {
  let menu = new Menu();
  menu.menu();

  let filter = new Filter();
  filter.filter();

  let response = new Response();
  response.response();

  let save = new Save();
  save.save();
});
