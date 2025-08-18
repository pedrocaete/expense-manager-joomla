/**
 * @package     ExpenseManager
 * @description Adiciona máscara de data e interatividade do campo de calendário.
 * @version     2.0.0 (final e robusta)
 */

 (function() {
    // Espera que toda a página, incluindo todos os scripts e imagens, esteja carregada.
    // Isto garante que o script do calendário do Joomla já foi inicializado.
    window.addEventListener('load', function() {
        
        try {
            // Procura o campo de data pelo seu ID exato.
            const dateField = document.getElementById('jform_visit_date');

            if (!dateField) {
                // Se não encontrar o campo, não faz nada para evitar erros.
                return;
            }

            // Libera o campo para digitação do utilizador.
            dateField.removeAttribute('readonly');

            // --- Função para aplicar a máscara de data (sem alterações) ---
            const applyDateMask = function(event) {
                let input = event.target;
                let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número
                let maskedValue = '';

                if (value.length > 0) {
                    maskedValue = value.substring(0, 2);
                }
                if (value.length > 2) {
                    maskedValue = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                if (value.length > 4) {
                    maskedValue = value.substring(0, 2) + '/' + value.substring(2, 4) + '/' + value.substring(4, 8);
                }
                
                input.value = maskedValue;
            };

            // --- Função para abrir o calendário (lógica final) ---
            const openCalendar = function() {
                // Por padrão, o Joomla 3 cria o botão do calendário com o ID do campo + o sufixo "_btn".
                const calendarButton = document.getElementById('jform_visit_date_btn');
                
                // Se o botão for encontrado, simula um clique nele.
                if (calendarButton) {
                    calendarButton.click();
                } 
                // Se não for encontrado, avisa o programador na consola, sem incomodar o utilizador.
                else {
                    console.error('Botão do calendário (#jform_visit_date_btn) não encontrado.');
                }
            };

            // --- Associa os eventos ao campo ---
            dateField.addEventListener('input', applyDateMask);
            dateField.addEventListener('click', openCalendar);

        } catch (e) {
            // Em caso de um erro inesperado, mostra-o na consola.
            console.error('Ocorreu um erro no script technicalvisit.js:', e);
        }
    });
})();