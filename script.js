const passwordInput = document.getElementById('password');
const passwordConfirmInput = document.getElementById('password_confirm');

function validarFormulario() {
    if (passwordInput.value !== passwordConfirmInput.value) {
        passwordConfirmInput.classList.add('is-invalid');
        return false;
    } else {
        passwordConfirmInput.classList.remove('is-invalid');
        return true;
    }
}

const rangeInput = document.getElementById('calificacion_eventos');
const rangeValueSpan = document.getElementById('calificacion_valor');

if (rangeInput && rangeValueSpan) {
    rangeInput.addEventListener('input', function() {
        rangeValueSpan.textContent = this.value;
    });
}

const passwordFields = [passwordInput, passwordConfirmInput];
for (const field of passwordFields) {
    if (field) {
        field.addEventListener('input', function() {
            if (passwordInput.value === passwordConfirmInput.value) {
                passwordConfirmInput.classList.remove('is-invalid');
            }
        });
    }
}
