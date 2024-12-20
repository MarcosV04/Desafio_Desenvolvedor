document.getElementById('addressForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const addressData = {
        user_id: localStorage.getItem('userId'),
        street: document.getElementById('street').value.trim(),
        neighborhood: document.getElementById('neighborhood').value.trim(),
        city: document.getElementById('city').value.trim(),
        state: document.getElementById('state').value.trim(),
        postal_code: document.getElementById('postalCode').value.trim()
    };

    // Verificar se todos os campos estão preenchidos
    if (!addressData.street || !addressData.neighborhood || !addressData.city || !addressData.state || !addressData.postal_code) {
        alert('Por favor, preencha todos os campos.');
        return;
    }

    // Validação de CEP (opcional)
    if (!isValidPostalCode(addressData.postal_code)) {
        alert('Por favor, insira um CEP válido no formato XXXXX-XXX.');
        return;
    }

    fetch('http://localhost/backend/api/api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ address: addressData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Endereço salvo com sucesso!');
            window.location.href = 'index.html'; // Volta para a tela principal
        } else {
            alert('Erro ao salvar endereço: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro ao salvar endereço.');
        console.error(error);
    });
});

// Função para validar o formato do CEP
function isValidPostalCode(postalCode) {
    const regex = /^\d{5}-\d{3}$/;  // Formato de CEP brasileiro
    return regex.test(postalCode);
}
