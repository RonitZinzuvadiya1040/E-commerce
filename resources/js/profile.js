document.addEventListener('DOMContentLoaded', function() {
    // Function to focus on the first empty field
    function focusFirstEmptyField() {
        var emptyFields = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
        for (var field of emptyFields) {
            if (!field.value.trim()) {
                field.focus();
                break;
            }
        }
    }

    // Call the function to focus the first empty field on page load
    focusFirstEmptyField();

    // Toggle password visibility functionality
    var togglePasswordButtons = document.querySelectorAll('.toggle-password');
    togglePasswordButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var input = this.closest('.input-group').querySelector('input');
            var icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});
