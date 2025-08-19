/**
 * @package     ExpenseManager
 * @description Adiciona máscara de data e interatividade do campo de calendário.
 * @version     2.0.0 (final e robusta)
 */

 (function() {
    window.addEventListener('load', function() {
        
        try {
            const dateField = document.getElementById('jform_visit_date');

            if (!dateField) {
                return;
            }

            dateField.removeAttribute('readonly');

            const applyDateMask = function(event) {
                let input = event.target;
                let value = input.value.replace(/\D/g, '');
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

            const openCalendar = function() {
                const calendarButton = document.getElementById('jform_visit_date_btn');
                
                if (calendarButton) {
                    calendarButton.click();
                } 
                else {
                    console.error('Botão do calendário (#jform_visit_date_btn) não encontrado.');
                }
            };

            dateField.addEventListener('input', applyDateMask);
            dateField.addEventListener('click', openCalendar);

        } catch (e) {
            console.error('Ocorreu um erro no script technicalvisit.js:', e);
        }
    });
})();