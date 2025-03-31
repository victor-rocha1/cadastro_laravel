document.addEventListener('DOMContentLoaded', function () {
    let campoPesquisaCPF = document.getElementById('pesquisar');

    if (campoPesquisaCPF) {
        // Adiciona o ouvinte de evento para a entrada de dados
        campoPesquisaCPF.addEventListener('input', function (event) {
            let valor = event.target.value;

            if (valor.replace(/\D/g, '').length === 11) {
                campoPesquisaCPF.setAttribute('maxlength', 14);
            } else {
                campoPesquisaCPF.removeAttribute('maxlength');
            }

            mascaraCPF(event);
        });
    }
});

function mascaraCPF(event) {
    let input = event.target;
    let valor = input.value;

    let numeros = valor.replace(/\D/g, '');

    if (numeros.length <= 11) {
        numeros = numeros.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
    }

    input.value = valor.replace(/\d/g, '').replace(/[^a-zA-Z\s]/g, '') + numeros;
}