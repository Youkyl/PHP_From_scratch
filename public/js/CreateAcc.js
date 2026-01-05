

    const typeCompte = document.getElementById("typeCompte");
    const alerteCheque = document.getElementById("alerteCheque");
    const blocageEpargne = document.getElementById("blocageEpargne");

    typeCompte.addEventListener("change", () => {
        alerteCheque.classList.add("d-none");
        blocageEpargne.classList.add("d-none");

        if (typeCompte.value === "cheque") {
            alerteCheque.classList.remove("d-none");
        }

        if (typeCompte.value === "epargne") {
            blocageEpargne.classList.remove("d-none");
        }
    });
    