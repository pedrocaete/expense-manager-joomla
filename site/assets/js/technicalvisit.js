(function() {
    
    const initDateFields = function() {
        const dateFields = document.querySelectorAll('.em-calendar-input');
        if (!dateFields.length) return;

        const applyDateMask = function(event) {
            let input = event.target;
            let value = input.value.replace(/\D/g, '');
            let maskedValue = '';

            if (value.length > 0) maskedValue = value.substring(0, 2);
            if (value.length > 2) maskedValue += '/' + value.substring(2, 4);
            if (value.length > 4) maskedValue += '/' + value.substring(4, 8);
            
            input.value = maskedValue;
        };

        const openCalendar = function(event) {
            const fieldId = event.target.id;
            const calendarButton = document.getElementById(fieldId + '_btn');
            if (calendarButton) calendarButton.click();
        };

        dateFields.forEach(function(dateField) {
            dateField.removeAttribute('readonly');
            dateField.addEventListener('input', applyDateMask);
            dateField.addEventListener('click', openCalendar);
        });
    };

    const initSectionTogglers = function() {
        const togglers = document.querySelectorAll('.section-toggler');
        if (!togglers.length) return;

        const handleToggle = function(event) {
            const togglerFieldset = event.target.closest('.section-toggler');
            if (!togglerFieldset) return;

            const fieldContainer = togglerFieldset.closest('.form-group');
            if (!fieldContainer) return;

            const contentWrapper = fieldContainer.nextElementSibling;

            if (!contentWrapper || !contentWrapper.classList.contains('section-content-wrapper')) {
                console.error('Não foi possível encontrar o contentor da secção correspondente para', togglerFieldset);
                return;
            }
            
            const selectedValue = togglerFieldset.querySelector('input:checked').value;
            contentWrapper.style.display = selectedValue === '1' ? 'block' : 'none';
        };
        
        togglers.forEach(function(toggler) {
            const radios = toggler.querySelectorAll('input[type="radio"]');
            radios.forEach(radio => {
                radio.addEventListener('change', handleToggle);
                if (radio.checked) {
                    radio.dispatchEvent(new Event('change'));
                }
            });
        });
    };

    document.addEventListener('DOMContentLoaded', function() {
        try {
            initDateFields();
            initSectionTogglers();
        } catch (e) {
            console.error('Erro ao inicializar o formulário de visita técnica:', e);
        }
    });

})();

