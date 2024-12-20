document.getElementById("btnCadastrar").addEventListener("click", async () => {
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;

    const response = await fetch("/backend/api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "create", name, email, phone })
    });

    const result = await response.json();
    if (result.success) {
        alert(result.message);
        window.location.href = "address.html";
    } else {
        alert(result.message);
    }
});

document.getElementById("btnLogin").addEventListener("click", async () => {
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;

    const response = await fetch("/backend/api.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ action: "login", email, phone })
    });

    const result = await response.json();
    if (result.success) {
        alert(result.message);
        window.location.href = "transaction.html";
    } else {
        alert(result.message);
    }
});
