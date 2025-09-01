/**
 * @package     ExpenseManager
 * @description Aplica máscara de data e interatividade a todos os campos de calendário com a classe .em-calendar-input.
 * @version     3.0.0 (Reutilizável)
 */

 (function() {
    document.addEventListener('DOMContentLoaded', function() {
        
        try {
            const dateFields = document.querySelectorAll('.em-calendar-input');

            if (!dateFields.length) {
                return;
            }

            const applyDateMask = function(event) {
                let input = event.target;
                let value = input.value.replace(/\D/g, '');
                let maskedValue = '';

                if (value.length > 0) {
                    maskedValue = value.substring(0, 2);
                }
                if (value.length > 2) {
                    maskedValue += '/' + value.substring(2, 4);
                }
                if (value.length > 4) {
                    maskedValue += '/' + value.substring(4, 8);
                }
                
                input.value = maskedValue;
            };

            const openCalendar = function(event) {
                const fieldId = event.target.id;
                const calendarButton = document.getElementById(fieldId + '_btn');
                
                if (calendarButton) {
                    calendarButton.click();
                } 
                else {
                    console.error('Botão do calendário correspondente não encontrado para o campo:', fieldId);
                }
            };

            dateFields.forEach(function(dateField) {
                dateField.removeAttribute('readonly');

                dateField.addEventListener('input', applyDateMask);
                
                dateField.addEventListener('click', openCalendar);
            });

        } catch (e) {
            console.error('Ocorreu um erro no script de inicialização dos campos de data:', e);
        }
    });
})();