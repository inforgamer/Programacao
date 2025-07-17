function validarFormulario() {
    let campos = [
        {nome: 'nome', label: 'Nome'},
        {nome: 'endereco', label: 'Endereço'},
        {nome: 'data_nascimento', label: 'Data de Nascimento'},
        {nome: 'email', label: 'E-mail'},
        {nome: 'telefone', label: 'Telefone'}
    ];
    
    let erros = [];
    
    campos.forEach(function(campo) {
        let valor = document.forms['formLivro'][campo.nome].value.trim();
        if (!valor) {
            erros.push('O campo "' + campo.label + '" é obrigatório.');
        }
    });
    
    // Validação específica para email
    let email = document.forms['formLivro']['email'].value.trim();
    if (email && !email.includes('@')) {
        erros.push('Por favor, insira um e-mail válido.');
    }
    
    // Validação específica para data
    let dataNasc = document.forms['formLivro']['data_nascimento'].value;
    if (dataNasc) {
        let hoje = new Date();
        let nascimento = new Date(dataNasc);
        if (nascimento > hoje) {
            erros.push('A data de nascimento não pode ser no futuro.');
        }
    }
    
    let mensagemErro = erros.length > 0 ? erros.join('<br>') : '';
    document.getElementById('erro').innerHTML = mensagemErro;
    
    return erros.length === 0;
}
