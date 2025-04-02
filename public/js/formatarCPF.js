function formatarCPF(event) {
    let input = event.target;
    let cpf = input.value.replace(/\D/g, ''); // Remove tudo que não for número

    if (cpf.length > 3 && cpf.length <= 6) {
        cpf = cpf.replace(/(\d{3})(\d{1,3})/, '$1.$2');
    } else if (cpf.length > 6 && cpf.length <= 9) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
    } else if (cpf.length > 9) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
    }

    input.value = cpf;
    checarCPF(); // Já chama a validação enquanto o usuário digita
}

function validarCPF(cpf) {
    cpf = cpf.replace(/\D/g, ''); // Remove caracteres não numéricos

    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
        return false; // CPF inválido se não tiver 11 dígitos ou for uma sequência repetida
    }

    let soma = 0;
    let resto;

    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(9))) return false;

    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(10))) return false;

    return true;
}

function checarCPF() {
    let inputCPF = document.getElementById('cpf');
    let erroCPF = document.getElementById('erro-cpf');

    if (!validarCPF(inputCPF.value)) {
        inputCPF.classList.add('is-invalid');
        inputCPF.classList.remove('is-valid'); // Remove a classe de válido se houver erro
        erroCPF.style.display = 'block';
    } else {
        inputCPF.classList.remove('is-invalid'); // Remove a classe de erro
        inputCPF.classList.add('is-valid'); // Adiciona a classe de válido
        erroCPF.style.display = 'none';
    }
}