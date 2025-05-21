window.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('serviceForm');
    const title = document.getElementById('title');
    const desc = document.getElementById('description');
    const price = document.getElementById('base_price');
    const submitBtn = document.getElementById('submitBtn');

    function checkForm() {
        submitBtn.disabled = !(title.value.trim() && desc.value.trim() && price.value);
    }
    title.addEventListener('input', checkForm);
    desc.addEventListener('input', checkForm);
    price.addEventListener('input', checkForm);

    // Initial check
    checkForm();
});