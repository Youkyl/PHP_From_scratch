    let comptes = [
        {
            type: 'cheque',
            nom: 'Hounkpatin Youan',
            numero: 'FR571889690521',
            dateCreation: '22/12/2025',
            solde: 1000000.00,
            transactions: 0
        },
        {
            type: 'epargne',
            nom: 'Gerard OKB',
            numero: 'FR018802782931',
            dateCreation: '22/12/2025',
            solde: 10000000.00,
            transactions: 0,
            bloque: true,
            dateDeblocage: '22/12/2026'
        }
    ];

    
    // comptes = [];

    
        const container = document.getElementById('accountsContainer');
        const emptyState = document.getElementById('emptyState');

        if (comptes.length === 0) {
            
            emptyState.style.display = 'block';

        } else {
            
            emptyState.style.display = 'none';
            
            
            const accHTML = comptes.map(compte => {
                const typeLabel = compte.type === 'cheque' ? 'Compte Chèque' : 'Compte Épargne';
                const cardClass = compte.type === 'cheque' ? 'cheque' : 'epargne';
                const badgeClass = compte.type === 'cheque' ? 'badge-cheque' : 'badge-epargne';
                
                let badges = `<span class="account-type-badge ${badgeClass}">${typeLabel}</span>`;
                if (compte.bloque) {
                    badges += `<span class="account-type-badge badge-bloque"><i class="bi bi-lock-fill"></i> Bloqué</span>`;
                }

                let detailsHTML = `
                    <div class="account-detail-row">
                        <i class="bi bi-person"></i>
                        <span>${compte.nom}</span>
                    </div>
                    <div class="account-detail-row">
                        <i class="bi bi-hash"></i>
                        <span>${compte.numero}</span>
                    </div>
                    <div class="account-detail-row">
                        <i class="bi bi-calendar"></i>
                        <span>Créé le ${compte.dateCreation}</span>
                    </div>
                `;

                if (compte.bloque && compte.dateDeblocage) {
                    detailsHTML += `
                        <div class="account-detail-row">
                            <i class="bi bi-lock"></i>
                            <span>Bloqué jusqu'au ${compte.dateDeblocage}</span>
                        </div>
                    `;
                }

                return `
                    <div class="account-card ${cardClass}">
                        ${badges}
                        <div class="account-info">
                            <div class="account-details">
                                ${detailsHTML}
                            </div>
                            <div class="account-balance">
                                <div class="balance-label">Solde</div>
                                <div class="balance-amount">${compte.solde.toLocaleString('fr-FR', {minimumFractionDigits: 2})} FCFA</div>
                                <div class="transaction-count">${compte.transactions} transaction${compte.transactions > 1 ? 's' : ''}</div>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            container.innerHTML = accHTML;
        }