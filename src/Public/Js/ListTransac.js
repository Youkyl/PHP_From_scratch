    const comptes = [
        {
            id: 1,
            numero: 'FR571889690521',
            nom: 'Hounkpatin Youan',
            type: 'cheque',
            solde: 984880.00,
            transactions: [
                {
                    id: 1,
                    type: 'retrait',
                    montant: 15000.00,
                    frais: 120.00,
                    description: 'Retrait de 15000.00 FCFA',
                    date: '22/12/2025 18:00'
                }
            ]
        },
        {
            id: 2,
            numero: 'FR018802782931',
            nom: 'Gerard OKB',
            type: 'epargne',
            solde: 10000000.00,
            transactions: []
        }
    ];

    
    // comptes = [];

    let selectedAccount = null;

    
        const container = document.getElementById('contentContainer');
        const emptyState = document.getElementById('emptyState');

        if (comptes.length === 0) {
            
            emptyState.style.display = 'block';
        } else {
            
            emptyState.style.display = 'none';

            
            let html = `
                <div class="mb-3">
                    <label class="form-label">Sélectionner un compte</label>
                    <select class="form-select" id="accountSelect">
                        <option value="">Choisir un compte...</option>
            `;

            comptes.forEach(compte => {
                html += `<option value="${compte.id}">${compte.nom} - ${compte.numero}</option>`;
            });

            html += `
                    </select>
                </div>
                <div id="transactionsContent"></div>
            `;

            container.innerHTML = html;

            
            document.getElementById('accountSelect').addEventListener('change', function() {
                const accountId = parseInt(this.value);
                selectedAccount = comptes.find(c => c.id === accountId);
                renderTransactions();
            });
        }
    

    function renderTransactions() {
        const transactionsContent = document.getElementById('transactionsContent');

        if (!selectedAccount) {
            transactionsContent.innerHTML = '';
            return;
        }

        const soldeFormatted = selectedAccount.solde.toLocaleString('fr-FR', {minimumFractionDigits: 2});
        
        let html = `
            <!-- Account info box -->
            <div class="account-info-box">
                <div>
                    <div class="account-holder">Titulaire</div>
                    <div class="account-name">${selectedAccount.nom}</div>
                </div>
                <div>
                    <div class="balance-label">Solde actuel</div>
                    <div class="balance-amount">${soldeFormatted} FCFA</div>
                </div>
            </div>
        `;

        if (selectedAccount.transactions.length === 0) {
            
            html += `
                <div class="transactions-header">0 transaction</div>
            `;
        } else {
            
            const count = selectedAccount.transactions.length;
            html += `
                <div class="transactions-header">${count} transaction${count > 1 ? 's' : ''}</div>
            `;

            selectedAccount.transactions.forEach(transaction => {
                const isRetrait = transaction.type === 'retrait';
                const typeClass = isRetrait ? 'retrait' : 'depot';
                const typeLabel = isRetrait ? 'Retrait' : 'Dépôt';
                const typeIcon = isRetrait ? 'bi-dash-circle' : 'bi-plus-circle';
                const amountSign = isRetrait ? '-' : '+';
                const amountFormatted = transaction.montant.toLocaleString('fr-FR', {minimumFractionDigits: 2});

                html += `
                    <div class="transaction-card ${typeClass}">
                        <div class="transaction-header">
                            <div class="transaction-type ${typeClass}">
                                <i class="bi ${typeIcon}"></i>
                                ${typeLabel}
                            </div>
                            <div class="transaction-amount ${typeClass}">
                                ${amountSign}${amountFormatted} FCFA
                            </div>
                        </div>
                        <div class="transaction-details">
                            <div class="transaction-detail">
                                <i class="bi bi-receipt"></i>
                                <span>${transaction.description}</span>
                            </div>
                            <div class="transaction-detail">
                                <i class="bi bi-calendar"></i>
                                <span>${transaction.date}</span>
                            </div>
                `;

                if (transaction.frais) {
                    const fraisFormatted = transaction.frais.toLocaleString('fr-FR', {minimumFractionDigits: 2});
                    html += `
                            <div class="transaction-detail fee">
                                <i class="bi bi-currency-dollar"></i>
                                <span>Frais: ${fraisFormatted} FCFA</span>
                            </div>
                    `;
                }

                html += `
                        </div>
                    </div>
                `;
            });
        }

        transactionsContent.innerHTML = html;
    }