function moneyMask(input) {
    if (input.value) {
        const numericInput = input.value.replace(/\D/g, '');
        const formattedInput = (parseInt(numericInput) / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        input.value = formattedInput;
    }
}