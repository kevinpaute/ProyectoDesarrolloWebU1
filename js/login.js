const registrarButton = document.getElementById('registro');
const iniciarButton = document.getElementById('iniciarS');
const container = document.getElementById('container');

registrarButton.addEventListener('click', () => {
    container.classList.add("right-panel-active");
});

iniciarButton.addEventListener('click', () => {
    container.classList.remove("right-panel-active");
});

