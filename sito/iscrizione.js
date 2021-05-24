

function jsonControlloUsername(json) {
    if (formStatus.username = !json.exists) {
        document.querySelector('.username').classList.remove('error');
    } else {
        document.querySelector('.username span').textContent = "USERNAME GIA' UTILIZZATO";
        document.querySelector('.username').classList.add('error');
    }
    checkForm();
}

function jsonControlloMail(json) {
    if (formStatus.mail = !json.exists) {
        document.querySelector('.mail').classList.remove('error');
    } else {
        document.querySelector('.mail span').textContent = "EMAIL GIA' UTILIZZATA";
        document.querySelector('.mail').classList.add('error');
    }
    checkForm();
}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function ControlloUsername(event) {
    const input = document.querySelector('.username input');

    if(!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)) {
        input.parentNode.querySelector('span').textContent = "MAX 15 CARATTERI. SONO AMMESSE LETTERE, NUMERI E UNDERSCORE";
        input.parentNode.classList.add('error');
        formStatus.username = false;
        checkForm();
    } else {
        fetch("ControlloUsername.php?q="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonControlloUsername);
        input.parentNode.querySelector('span').textContent = "";

    }    
}

function ControlloMail(event) {
    const mailInput = document.querySelector('.mail input');
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(emailInput.value).toLowerCase())) {
        document.querySelector('.mail span').textContent = "EMAIL NON VALIDA";
        document.querySelector('.mail').classList.add('error');
        formStatus.mail = false;
        checkForm();
    } else {
        fetch("ControlloMail.php?q="+encodeURIComponent(String(mailInput.value).toLowerCase())).then(fetchResponse).then(jsonControlloMail);
        document.querySelector('.mail span').textContent = "";

    }
}

function ControlloPassword(event) {
    const passwordInput = document.querySelector('.password input');
    if (formStatus.password = passwordInput.value.length >= 8) {
        document.querySelector('.password').classList.remove('error');
        document.querySelector('.password span').textContent = "";

    } else {
        document.querySelector('.password').classList.add('error');
        document.querySelector('.password span').textContent = "PASSWORD NON VALIDA: MIN 8 CARATTERI";

    }
    checkForm();
}

function ControlloConfermaPassword(event) {
    const confermaPasswordInput = document.querySelector('.conferma_password input');
    if (formStatus.confermaPassord = confermaPasswordInput.value === document.querySelector('.password input').value) {
        document.querySelector('.conferma_password').classList.remove('error');
        document.querySelector('.conferma_password span').textContent = "";

    } else {
        document.querySelector('.conferma_password').classList.add('error');
        document.querySelector('.conferma_password span').textContent = "LE PASSWORD NON COINCIDONO";

    }
    checkForm();
}


function checkForm() { 
    // Controlla che tutti i campi siano pieni
    Object.keys(formStatus).length !== 7 || 
    // Controlla che i campi non siano false
    Object.values(formStatus).includes(false);
    
}

const formStatus = {'upload': true};
document.querySelector('.username input').addEventListener('blur', ControlloUsername);
document.querySelector('.mail input').addEventListener('blur', ControlloMail);
document.querySelector('.password input').addEventListener('blur', ControlloPassword);
document.querySelector('.conferma_password input').addEventListener('blur', ControlloConfermaPassword);

if (document.querySelector('.error') !== null) {
    ControlloUsername(); ControlloPassword(); ControlloConfermaPassword(); ControlloMail();
}