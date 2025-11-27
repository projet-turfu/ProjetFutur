let baliseZoneProposition = document.getElementById("zoneProposition");
console.log(baliseZoneProposition);


function afficherResultat(score, nbMotsProposes) {
    console.log('Score : ' + score + ' / ' + nbMotsProposes)
}

function choisirPhrasesOuMots() {
    let choix = prompt("mots ou phrases ?")
    while (choix !== "mots" && choix !== "phrases") {
        choix = prompt("mots ou phrases ?")
    }
    return choix
}

function LancerBoucleDeJeu(listePropositions) {
    let score = 0
    for (let i = 0; i < listePropositions.length; i++) {
        let motUtilisateur = prompt('Entrez le mot : ' + listePropositions[i])
        if (motUtilisateur === listePropositions[i]) {
            score++
        }
    }
    return score
}

function lancerJeu() {
    let choix = choisirPhrasesOuMots()
    let score = 0
    let nbMotsProposes = 0

    if (choix === "mots" ) {
        score = LancerBoucleDeJeu(listeMots)
        nbMotsProposes = listeMots.length
    } else {
        score = LancerBoucleDeJeu(listePhrases)
        nbMotsProposes = listePhrases.length
    }

    afficherResultat(score, nbMotsProposes)
}

