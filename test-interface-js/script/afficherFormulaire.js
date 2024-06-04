//Afficher formulaire

document.addEventListener('DOMContentLoaded', (event) => {
    const button = document.getElementById('lancerForm');
    const formSection = document.getElementById('sectionForm');
    const ajouterExperienceSection = document.querySelector('section.ajouter-experience');

    button.addEventListener('click', () => {
        formSection.classList.remove('hidden');
        ajouterExperienceSection.classList.remove('ajouter-experience');
        ajouterExperienceSection.classList.add('hidden');
        formSection.classList.add('formulaire');
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    const buttonEnvoi = document.getElementById('envoyerForm');
    const ajoutSection = document.getElementById('ajouterExperience');
    const formulaireSection = document.getElementById('sectionForm');
    const confirmationDiv = document.createElement('div');
    confirmationDiv.classList.add('confirmation');
    const confirmationImg = document.createElement('img');
    confirmationImg.src = 'script/tick-mark.png';
    confirmationDiv.appendChild(confirmationImg);

    buttonEnvoi.addEventListener('click', () => {
        confirmationDiv.appendChild(confirmationImg);
        ajoutSection.prepend(confirmationDiv);                
        ajoutSection.classList.remove('hidden');
        formulaireSection.classList.remove('formulaire');
        formulaireSection.classList.add('hidden');
        ajoutSection.classList.add('ajouter-experience');
    });
});



