/* ---------- Felgörgető gomb a lista oldalon ---------- */
let felgomb = document.getElementById("fel_gomb");

window.onscroll = function () {
  Gorgetes();
};

function Gorgetes() {
  if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
  ) {
    felgomb.style.display = "block";
  } else {
    felgomb.style.display = "none";
  }
}

felgomb.addEventListener("click", IranyFelfele);

function IranyFelfele() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}