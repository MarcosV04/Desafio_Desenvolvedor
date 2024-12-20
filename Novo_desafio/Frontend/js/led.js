document.getElementById("btn-register").addEventListener("click", () => {
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;

    fetch("http://localhost/novo_desafio/backend/api/api.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            action: "register",
            name: name,
            email: email,
            phone: phone,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            alert(data.message);
            if (data.id) {
                // Se o cadastro for bem-sucedido, redirecionar
                window.location.href = "index.html";
            }
        })
        .catch((error) => console.error("Erro:", error));
});

document.getElementById("btn-login").addEventListener("click", () => {
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;

    fetch("http://localhost/novo_desafio/backend/api/api.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            action: "login",
            email: email,
            phone: phone,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.message === "Login bem-sucedido!") {
                alert(data.message);
                // Redirecionar para a página de transações
                window.location.href = "transaction.html";
            } else {
                alert(data.message);
            }
        })
        .catch((error) => console.error("Erro:", error));
});
