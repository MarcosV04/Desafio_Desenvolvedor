document.getElementById('calculateButton').addEventListener('click', function () {
    // Obter os valores dos campos de investimento
    const investmentAmount = parseFloat(document.getElementById('investmentAmount').value);
    const interestRate = parseFloat(document.getElementById('interestRate').value);
    const period = parseInt(document.getElementById('period').value);

    // Debugging: Verifique os valores dos campos
    console.log('investmentAmount:', investmentAmount);
    console.log('interestRate:', interestRate);
    console.log('period:', period);

    // Verificar se todos os campos obrigatórios estão preenchidos
    if (isNaN(investmentAmount) || isNaN(interestRate) || isNaN(period)) {
        alert('Por favor, preencha todos os campos corretamente.');
        return;
    }

    // Cálculo do valor total com juros compostos
    const totalAmount = investmentAmount * Math.pow(1 + (interestRate / 100), period);

    // Debugging: Verifique o valor do totalAmount
    console.log('totalAmount:', totalAmount);

    // Exibir o valor total
    document.getElementById('totalAmount').value = totalAmount.toFixed(2);  // Formatar o valor com 2 casas decimais
});

// Evento de envio do formulário de transação
document.getElementById('investmentForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Impede o envio padrão do formulário

    // Cria o objeto transactionData com os dados do formulário de transação
    const transactionData = {
        user_id: localStorage.getItem('userId'), // Recupera o ID do usuário armazenado no localStorage
        type: document.getElementById('transactionType').value, // Recupera o tipo da transação (depósito ou retirada)
        amount: document.getElementById('amount').value, // Recupera o valor da transação
        date: document.getElementById('date').value // Recupera a data da transação
    };

    // Verifica se todos os campos obrigatórios estão preenchidos
    if (!transactionData.type || !transactionData.amount || !transactionData.date) {
        alert('Por favor, preencha todos os campos da transação.');
        return;
    }

    // Envia a requisição para a API com os dados da transação
    fetch('http://localhost/backend/api/api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ transaction: transactionData }) // Envia os dados da transação como JSON
    })
        .then(response => response.json()) // Converte a resposta para JSON
        .then(data => {
            alert('Transação salva com sucesso!'); // Exibe um alerta quando a transação for salva
            console.log(data); // Você pode ver a resposta no console para depuração
        })
        .catch(error => {
            alert('Erro ao salvar transação.'); // Exibe um alerta se ocorrer um erro
            console.error(error); // Exibe o erro no console
        });
});
