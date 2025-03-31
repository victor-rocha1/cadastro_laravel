document.addEventListener('DOMContentLoaded', function() {
    formatarTelefone();
    formatarCEP();

    let campoPesquisaCPF = document.getElementById('pesquisar');
    if (campoPesquisaCPF) {
        campoPesquisaCPF.addEventListener('input', mascaraCPF);
    }
    
    let digitarCPF = document.getElementById('cpf');
    if (digitarCPF) {
        digitarCPF.addEventListener('input', formatarCPF);
    }
    
});
