
document.addEventListener("DOMContentLoaded", () => {

    const myForm = document.getElementById("contactForm");

    myForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(myForm);

        fetch('http://localhost/projects_dev/project_cda_1/public/?page=contact', {
            method: 'POST',
            mode: 'cors',
            body: formData,
            headers: {
                'Accept': 'application/json',
            }
        })
        .then(async response => {
            if (response.ok) {
                const myResponse = await response.json();
                if (myResponse.ok) {
                    let alert = document.createElement('div');
                    alert.classList.add('checked');
                    alert.innerHTML = myResponse.ok;
                    const alertContainer = document.querySelector('#alertContainer');
                    alertContainer.appendChild(alert);
                } else {
                    console.error('Erreur lors de la requête : ' + myResponse.error);

                    let alert = document.createElement('div');
                    alert.classList.add('alert');
                    alert.innerHTML = myResponse.error;
                    const alertContainer = document.querySelector('#alertContainer');
                    alertContainer.appendChild(alert);
                }
            } else {
                throw new Error('Erreur lors de la requête');
            }
        })
        .catch(error => {
            console.error(error);
            
        })
    })        
});