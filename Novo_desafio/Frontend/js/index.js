// Botão para acessar a página de cadastro sem validação
document.getElementById('goToCadastro').addEventListener('click', function () {
    window.location.href = 'Frontend/address.html'; // Redireciona diretamente para a página de cadastro
});

// Função para cadastrar o usuário
document.getElementById('btnCadastro').addEventListener('click', async function () {
    try {
        const userData = {
            name: document.getElementById('name').value.trim(),
            email: document.getElementById('email').value.trim(),
            phone: document.getElementById('phone').value.trim()
        };

        // Validação de campos obrigatórios
        if (!userData.name || !userData.email || !userData.phone) {
            alert('Preencha todos os campos antes de cadastrar.');
            return;
        }

        // Validação de e-mail e telefone
        if (!validateEmail(userData.email)) {
            alert('Por favor, insira um e-mail válido.');
            return;
        }

        if (!validatePhone(userData.phone)) {
            alert('Por favor, insira um telefone válido (somente números, 10 ou 11 dígitos).');
            return;
        }

        // Enviando os dados para o backend via fetch
        const response = await fetch('http://localhost/backend/api/api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'register', user: userData })
        });

        const data = await response.json();

        if (data.success) {
            alert('Usuário cadastrado com sucesso! Seu ID é: ' + data.id);
            localStorage.setItem('userId', data.id); // Armazena o ID no localStorage
            window.location.href = 'Frontend/transaction.html'; // Redireciona após cadastro
        } else {
            alert('Erro ao cadastrar usuário: ' + (data.message || 'Erro desconhecido.'));
            console.error('Erro do servidor:', data.message);
        }
    } catch (error) {
        alert('Erro ao conectar ao backend. Verifique sua conexão e tente novamente.');
        console.error('Erro ao conectar ao backend:', error);
    }
});

// Função para login (acesso à página de transação)
document.getElementById('btnLogin').addEventListener('click', async function () {
    try {
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();

        // Validação de campos obrigatórios
        if (!email || !phone) {
            alert('Preencha o e-mail e o telefone para fazer login.');
            return;
        }

        // Enviando os dados para o backend via fetch
        const response = await fetch('http://localhost/backend/api/api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'login', email: email, phone: phone })
        });

        const data = await response.json();

        if (data.success) {
            alert('Login realizado com sucesso!');
            window.location.href = 'Frontend/transaction.html'; // Redireciona para a página de transação
        } else {
            alert('Erro ao fazer login: ' + (data.message || 'Erro desconhecido.'));
            console.error('Erro do servidor:', data.message);
        }
    } catch (error) {
        alert('Erro ao conectar ao backend. Verifique sua conexão e tente novamente.');
        console.error('Erro ao conectar ao backend:', error);
    }
});

// Função de validação de e-mail
function validateEmail(email) {
    const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return re.test(email);
}

// Função de validação de telefone
function validatePhone(phone) {
    const re = /^[0-9]{10,11}$/; // Aceita 10 ou 11 dígitos numéricos
    return re.test(phone);
}
