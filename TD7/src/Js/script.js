//--------Affichages-------------

function afficheAdherents(tableau) {
	tableau = JSON.parse(tableau.responseText);
	let div = document.getElementById('listeAdherents');
	for(let n of tableau){
		let p = document.createElement("p");
		p.nomAdherent = n.nomAdherent;
		p.idAdherent = n.idAdherent;
		p.style.cursor = "pointer";
		p.nbemprunts = n["count(e.idAdherent)"];
		if( n["count(e.idAdherent)"]>0){
		p.innerText = n.idAdherent + "-" + n.nomAdherent + "(" +n["count(e.idAdherent)"]+ " emprunts)";
		p.nbemprunts = n["count(e.idAdherent)"];
		}
		else{
			p.innerText = n.idAdherent + "-" + n.nomAdherent;
		}
		div.appendChild(p);
		if(parseInt(p.nbemprunts)>0){p.addEventListener("click",function(event){
			requeteEmprunts(p.idAdherent,p.nomAdherent,p.nbemprunts);
		})}
	}
}

function affichelisteemprunt(id,nom,nbemprunts,tableau){
	string = "";
	string += nom + " à " + nbemprunts + " emprunts en ce moment :\n";
	tableau = JSON.parse(tableau.responseText);
	for(let n of tableau){
		string += "-" + n.titreLivre + "\n";
	}
	alert(string);

}
//Savoir si on comfirme ou non le retour d'un livre
function callbackConfirm(tableau){
	tableau = JSON.parse(tableau.responseText);
	string = "Ce livre à été prété à " + tableau[0].nomAdherent + "\n Retourner ce livre?";
	r = confirm(string);
	if(r){
		RendreLivre(tableau[0].idLivre);
	}
}

function videAdherent(){
	let div = document.getElementById("listeAdherents");
	while (div.firstChild){
		div.removeChild(div.firstChild)
	}
}

function afficheLivresDispo(tableau) {
	tableau = JSON.parse(tableau.responseText);
	let div = document.getElementById('listeLivresDisponibles');
	for(let n of tableau){
		let p = document.createElement("p");
		p.idLivre = n.idLivre;
		p.titreLivre = n.titreLivre;
		p.innerText = n.idLivre + "-" + n.titreLivre;
		p.style.cursor = "pointer";
		div.appendChild(p);

		p.addEventListener("click",function(event){
			let reponse = prompt("Pret de l'ojet : " + event.target.titreLivre + "\n A qui voulez vous preter ce livre?");
			if(reponse != null){
				LouerLivre(event.target.idLivre,reponse);
			}

		})
	}
}
function videLivresDispo(){
	let div = document.getElementById("listeLivresDisponibles");
	while (div.firstChild){
		div.removeChild(div.firstChild)
	}
}
function afficheLivresPris(tableau) {
	tableau = JSON.parse(tableau.responseText);
	let div = document.getElementById('listeLivresEmpruntes');
	for(let n of tableau){
		let p = document.createElement("p");
		p.idLivre = n.idLivre;
		p.style.cursor = "pointer";
		p.titreLivre = n.titreLivre;
		p.innerText = n.idLivre + "-" + n.titreLivre;
		div.appendChild(p);
		p.addEventListener("click",function(event){
			confirmRendre(p.idLivre);
		})
	}
}
function videLivresPris(){
	let div = document.getElementById("listeLivresEmpruntes");
	while (div.firstChild){
		div.removeChild(div.firstChild)
	}
}
function afficherTout(){
	requeteAdherents();
	requeteLivresDispo();
	requeteLivresPris();
}
function viderTout(){
	videAdherent();
	videLivresPris();
	videLivresDispo();
}

function refresh(){
	viderTout();
	afficherTout();
}
//---------------Requetes xml---------
function requeteAdherents() {
	let url = "php/adherent.php";
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		afficheAdherents(requete);
	});
	requete.send(null);
}
function requeteLivresDispo() {
	let url = "php/livresDispo.php";
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		afficheLivresDispo(requete);
	});
	requete.send(null);
}
function requeteLivresPris() {
	let url = "php/livresPris.php";
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		afficheLivresPris(requete);
	});
	requete.send(null);
}
function requeteEmprunts(id,nom,nbemprunts) {
	let url = "php/getEmprunts.php?id=" + id;
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		affichelisteemprunt(id,nom,nbemprunts,requete);
	});
	requete.send(null);
}
function confirmRendre(id) {
	let url = "php/getEmprunteur.php?id=" + id;
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		callbackConfirm(requete);
	});
	requete.send(null);
}

function RendreLivre(id) {
	let url = "php/rendreLivre.php?id=" + id;
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		refresh();
	});
	requete.send(null);
}
function LouerLivre(idLivre,idAdherent) {
	let url = "php/emprunterLivre.php?idLivre=" + idLivre + "&idAdherent=" + idAdherent;
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		refresh();
	});
	requete.send(null);
}

//-------------Autre--------------
afficherTout();
//Ajout de l'ecouteur d'évenement de ajouterAdhérent
document.getElementById('ajouterAdherent').addEventListener('click',function(event){
	let url = "php/createSomething.php?type=adherent&nom=" + document.getElementById('nomAdherent').value;
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		refresh();
	});
	requete.send(null);
})

//Ajout de l'ecouteur d'évenement de ajouterLivre
document.getElementById('ajouterLivre').addEventListener('click',function(event){
	let url = "php/createSomething.php?type=livre&nom=" + document.getElementById('titreLivre').value;
	let requete = new XMLHttpRequest();
	requete.open("GET", url, true);
	requete.addEventListener("load", function () {
		viderTout();
		afficherTout();
	});
	requete.send(null);
})


