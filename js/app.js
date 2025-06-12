let totalGeral;
limpar();

function adicionar() {
    //Recuperar valores nome do produto, quantidade e valor ↓
    let produto = document.getElementById('produto').value;
    let quantidade =  document.getElementById('quantidade').value;
    
    //verfificando se o produto selecionado é válido ↓ 
    if (!produto || produto.trim() === ""){
        alert ("selecione um produto válido")
        return;
    } 

    // verificando se a quantidade inserida é valida ↓
    if(isNaN(quantidade) || quantidade <=0) {
        alert ("selecione uma quantidade válida")
    return;
    }

    let nomeProduto = produto.split('-')[0];
    let valorUnitario = parseFloat (produto.split('R$')[1]);
   //Calcular o preço, o nosso subtotal ↓
    let preco = quantidade*valorUnitario;
    //Adicionar no carrinho ↓
    let carrinho = document.getElementById('lista-produtos')
    carrinho.innerHTML = carrinho.innerHTML + `<section class="carrinho__produtos__produto">
          <span class="texto-vermelho">${quantidade}x</span> ${nomeProduto}<span class="texto-vermelho">R$${preco}</span>
        </section>`;
    //Atualizar o valor total da compra ↓
    totalGeral = totalGeral + preco;
    let campoTotal = document.getElementById('valor-total');
    campoTotal.textContent = `R$${totalGeral}`; 
    quantidade =  document.getElementById('quantidade').value = 0;
}

function limpar() {
    //Limpar o carrinho de compras ↓
totalGeral = 0; 
document.getElementById('lista-produtos').innerHTML = ''; 
document.getElementById('valor-total').textContent = 'R$ 0';
}