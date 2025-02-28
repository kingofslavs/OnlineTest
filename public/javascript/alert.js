function closeAlert() {
    const alert = document.getElementById('alert');
    if (alert) {
        alert.style.animation = 'fadeOut 0.3s ease-out forwards';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }
}

setTimeout(() => {
    closeAlert();
}, 5000);
