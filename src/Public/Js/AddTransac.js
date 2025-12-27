

    
    const comptes = [
        {
            id: 1,
            numero: 'FR571889690521',
            nom: 'Hounkpatin Youan',
            type: 'cheque',
            solde: 1000000.00,
            frais: 0.008 
        },
        {
            id: 2,
            numero: 'FR018802782931',
            nom: 'Gerard OKB',
            type: 'epargne',
            solde: 10000000.00,
            bloque: true,
            dateDeblocage: '22/12/2026'
        }
    ];

    //comptes = [];


    let selectedAccount = null;
    let transactionType = 'retrait'; 

    
    const accountSelect = document.getElementById('accountSelect');
    comptes.forEach(compte => {
        const option = document.createElement('option');
        option.value = compte.id;
        option.textContent = `${compte.nom} - ${compte.numero}`;
        accountSelect.appendChild(option);
    });

    
    accountSelect.addEventListener('change', function() {
        const accountId = parseInt(this.value);
        selectedAccount = comptes.find(c => c.id === accountId);
        updateAccountInfo();
        updateSubmitButton();
    });

    
    const depotBtn = document.getElementById('depotBtn');
    const retraitBtn = document.getElementById('retraitBtn');
    const submitBtn = document.getElementById('submitBtn');

    depotBtn.addEventListener('click', function() {
        transactionType = 'depot';
        depotBtn.classList.add('active', 'depot');
        retraitBtn.classList.remove('active', 'retrait');
        submitBtn.classList.remove('retrait');
        submitBtn.classList.add('depot');
        submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Valider la transaction';
        updateAccountInfo();
        updateSubmitButton();
    });

    retraitBtn.addEventListener('click', function() {
        transactionType = 'retrait';
        retraitBtn.classList.add('active', 'retrait');
        depotBtn.classList.remove('active', 'depot');
        submitBtn.classList.remove('depot');
        submitBtn.classList.add('retrait');
        submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Valider la transaction';
        updateAccountInfo();
        updateSubmitButton();
    });

    
    retraitBtn.click();

    
    function updateAccountInfo() {
        const accountInfo = document.getElementById('accountInfo');
        
        if (!selectedAccount) {
            accountInfo.style.display = 'none';
            return;
        }

        accountInfo.style.display = 'block';
        let infoHTML = '';

        
        const soldeFormatted = selectedAccount.solde.toLocaleString('fr-FR', {minimumFractionDigits: 2});
        infoHTML += `<div class="info-box">
            <p class="info-text balance">Solde actuel: <strong>${soldeFormatted} FCFA</strong></p>`;

            
        if (selectedAccount.type === 'cheque') {
            const fraisPercent = (selectedAccount.frais * 100).toFixed(1);
            infoHTML += `<p class="info-text fee">⚠️ Frais de transaction: ${fraisPercent}% du montant</p>`;
        }

        infoHTML += '</div>';

        
        if (selectedAccount.type === 'epargne' && selectedAccount.bloque && transactionType === 'retrait') {
            infoHTML += `<div class="info-box danger">
                <p class="info-text blocked">🔒 Compte bloqué - Retraits non autorisés jusqu'au ${selectedAccount.dateDeblocage}</p>
            </div>`;
        }

        accountInfo.innerHTML = infoHTML;
    }
    

    function updateSubmitButton() {
        const canSubmit = selectedAccount && (!selectedAccount.bloque || transactionType === 'depot' || selectedAccount.type !== 'epargne');
        submitBtn.disabled = !canSubmit;
    }

    

    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const amount = parseFloat(document.getElementById('amount').value);
        const description = document.getElementById('description').value;

        
        if (selectedAccount.type === 'epargne' && selectedAccount.bloque && transactionType === 'retrait') {
            alert('Impossible: Ce compte épargne est bloqué jusqu\'au ' + selectedAccount.dateDeblocage);
            return;
        }

        
        if (transactionType === 'retrait') {
            let totalAmount = amount;
            if (selectedAccount.type === 'cheque') {
                totalAmount += amount * selectedAccount.frais;
            }
            
            if (totalAmount > selectedAccount.solde) {
                alert('Solde insuffisant pour effectuer cette transaction');
                return;
            }
        }

        
        /*console.log({
            compte: selectedAccount,
            type: transactionType,
            montant: amount,
            description: description
        });*/

        alert('Transaction effectuée avec succès!');
        
        //window.location.href = 'index.html';
    });
    