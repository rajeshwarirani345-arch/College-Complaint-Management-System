
document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll("form[data-validate]");

    forms.forEach(function (form) {
        form.addEventListener("submit", function (event) {
            const password = form.querySelector(
                'input[name="password"]'
            );

            if (password && password.value.length < 6) {
                event.preventDefault();
                alert("Password must contain at least 6 characters.");
                password.focus();
                return;
            }

            const subject = form.querySelector(
                'input[name="subject"]'
            );

            if (subject && subject.value.trim() === "") {
                event.preventDefault();
                alert("Please enter a complaint subject.");
                subject.focus();
                return;
            }

            const description = form.querySelector(
                'textarea[name="description"]'
            );

            if (description && description.value.trim() === "") {
                event.preventDefault();
                alert("Please enter the complaint description.");
                description.focus();
            }
        });
    });
});