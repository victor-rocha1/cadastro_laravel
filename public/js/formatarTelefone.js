function formatarTelefone() {
    var inputTelefone = document.getElementById('telefone');
    if (!inputTelefone) return;

    inputTelefone.addEventListener('input', function(event) {
        var valor = event.target.value.replace(/\D/g, '');
        if (valor.length <= 2) {
            event.target.value = '(' + valor;
        } else if (valor.length <= 6) {
            event.target.value = '(' + valor.substring(0, 2) + ') ' + valor.substring(2);
        } else {
            event.target.value = '(' + valor.substring(0, 2) + ') ' + valor.substring(2, 7) + '-' + valor.substring(7, 11);
        }
    });
}
