function formatarCEP() {
    var inputCep = document.getElementById('cep');
    if (!inputCep) return;

    inputCep.addEventListener('input', function(event) {
        var valorCep = event.target.value.replace(/\D/g, '');
        event.target.value = valorCep.length > 5 ? valorCep.substring(0, 5) + '-' + valorCep.substring(5, 8) : valorCep;
    });

    inputCep.addEventListener('blur', function() {
        consultarCEP();
    });
}
