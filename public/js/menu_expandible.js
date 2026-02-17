// =============================================
//  MENÚ EXPANDIBLE
// =============================================

document.onreadystatechange = function() {
    if (document.readyState === 'complete') {
        inicializarMenuExpandible();
    }
};

function inicializarMenuExpandible() {
    const toggleButtons = document.querySelectorAll('.toggle-menu');
    
    toggleButtons.forEach(function(button) {
        button.onclick = function() {
            const menuId = this.getAttribute('data-menu-id');
            const menuText = document.getElementById(menuId);
            const toggleTextSpan = this.querySelector('.toggle-text');
            const toggleIcon = this.querySelector('.toggle-icon');
            const isExpanded = !menuText.classList.contains('line-clamp-2');
            
            if (isExpanded) {
                menuText.classList.add('line-clamp-2');
                toggleTextSpan.textContent = 'Ver más';
                toggleIcon.style.transform = 'rotate(0deg)';
            } else {
                menuText.classList.remove('line-clamp-2');
                toggleTextSpan.textContent = 'Ver menos';
                toggleIcon.style.transform = 'rotate(180deg)';
            }
            
            toggleIcon.style.transition = 'transform 0.3s ease';
        };
    });
}