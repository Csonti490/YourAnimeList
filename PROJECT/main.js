/* ---------- Regisztráció és Bejelentkezés - Jelszavak mutatása ---------- */
function Mutasd() {
    const pass1 = document.getElementById("password_textbox");
    const pass2 = document.getElementById("password2_textbox");
    const mutat = document.getElementById("pw_checkbox");
    if(mutat.checked==true){
        pass1.setAttribute("type","text");
        pass2.setAttribute("type","text");
    }
    else {
        pass1.setAttribute("type","password");
        pass2.setAttribute("type","password");
    }
}
/* ---------- Kijelentkezés - Kép és szöveg cserélő ---------- */
function KepCsere(ertek) {
    var kep = document.getElementById("felugro_kep");
    var szoveg = document.getElementById("felugro_szoveg");
    if(ertek == 1){
      kep.src = "img/aqua_cry.png";
      szoveg.innerText = "Maradj még egy kicsit :(";
    } 
    else if(ertek == 2){
      kep.src = "img/aqua_yes.png";
      szoveg.innerText = "Köszi, hogy még maradsz :D";
    }
    else {
      kep.src = "img/aqua_angry.png";
      szoveg.innerText = "Biztos, hogy kilépsz?";
    }
}

/* ---------- Módosítás - Értékelés mutatása csillagokkal ---------- */ 
var egesz_cs = `<i class="fa-solid fa-star"></i>`;
var fel_cs = `<i class="fa-solid fa-star-half-stroke"></i>`;
var ures_cs = `<i class="fa-regular fa-star"></i>`;
var ertek2 = document.getElementById("ertek");
var mezo = document.getElementById("csillagok");

function Csillagom(){
  mezo.innerHTML = "";
  var db = 0;
  for(let i = 0; i < ertek.value; i++){
    mezo.innerHTML += egesz_cs;
    db++;
  }
  for(let j = db; j < 10; j++){
    mezo.innerHTML += ures_cs;
  }
}

/* ---------- Hibás kép cseréje ---------- */
function KepHiba(hibas){
  hibas.src = "img/YAL_profilepicture.png";
}

/* ---------- Profil módosítása ---------- */
function ProfilModosit(ertek){
  // 1 -> módosító felület, 0 -> alap felület
  var doboz1 = document.getElementById("profil_alap");
  var doboz2 = document.getElementById("profil_modosit");
  var cim = document.getElementById("cim");
  if(ertek == 1){
    cim.innerText = "Profil információk módosítása";
    doboz1.classList.add("d-none");
    doboz2.classList.remove("d-none");
  } else if (ertek == 0){
    cim.innerText = "Profil információk";
    doboz1.classList.remove("d-none");
    doboz2.classList.add("d-none");
  }
}

/* ---------- Süti ---------- */
function Magic(){
  document.getElementById("yalc").style.display = "none";
  document.cookie="yalcookie=true;max-age=86400;path=/";
}

/* ---------- Képmentés ideiglenesen ---------- */
function Kepmentes(data) {
  var adat = data == "megsem"?"":data;
  document.getElementById('kepid').value = adat;
}

/* ---------- Alaphelyzet ---------- */
function KepValaszt(malid){
  var eredmeny = document.getElementById("eredmeny");
  var jelzes = document.getElementById("visszajelzes");
  eredmeny.value = malid!="megse"?malid:"";
  jelzes.innerHTML = malid!="megse"?"Sikeres képkiválasztás.":"Jelenleg nincsen kiválasztva kép.";
}
