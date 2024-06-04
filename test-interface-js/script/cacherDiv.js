document.addEventListener('DOMContentLoaded', (event) => {
    if(localStorage.getItem('trajets') !== null){
        const cacherDiv = document.getElementById('cacher');
        cacherDiv.classList.add('hidden');
        cacherDiv.classList.remove('cacher');
    
    }
})