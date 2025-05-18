function setDaltonismo(tipo) {
    document.body.classList.remove('Protanopia', 'Deuteranopia', 'Tritanopia', 'Monocromacia');

    document.body.classList.add(tipo);
    document.cookie = `Daltonismo=${tipo}; path=/`;

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
    
    document.cookie.split('; ').forEach(cookie => {
        const [name, value] = cookie.split('=');
        if (name === 'Daltonismo') {
            document.body.classList.add(value);
        }
    });
});
