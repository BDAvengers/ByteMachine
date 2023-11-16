function prepareFormData() {
    var inputs = document.querySelectorAll('.schedule-input');  
    inputs.forEach(function(input) {
        var hiddenInput = input.parentElement.querySelector('.hidden-group-id');
        
        if (hiddenInput) {
            hiddenInput.value = input.getAttribute('data-group-id');
        }
    });

    // Добавляем вывод в консоль для отладки
    console.log('FormData prepared:', document.querySelector('form').innerHTML);
} 

