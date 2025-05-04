function setDaltonismo(tipo) {
    document.body.classList.remove('Protanopia', 'Deuteranopia', 'Tritanopia', 'Monocromacia');

    if (tipo === 'Protanopia') {
        document.body.classList.add('Protanopia');
    } else if (tipo === 'Deuteranopia') {
        document.body.classList.add('Deuteranopia');
    } else if (tipo === 'Tritanopia') {
        document.body.classList.add('Tritanopia');
    } else if (tipo === 'Monocromacia') {
        document.body.classList.add('Monocromacia');
    }
    const menu = document.getElementById('acessibilidade-menu');
    if (menu) {
        menu.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const toggleButton = document.getElementById('toggle-menu');
    const menu = document.getElementById('acessibilidade-menu');

    toggleButton.addEventListener('click', () => {
        const isVisible = menu.style.display === 'flex';
        menu.style.display = isVisible ? 'none' : 'flex';
    });
});
