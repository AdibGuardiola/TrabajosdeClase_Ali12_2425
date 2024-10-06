document.addEventListener("DOMContentLoaded", function () {
    // Referencia al formulario
    const form = document.getElementById("contactForm");

    // Manejador de eventos para el formulario
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Evita que el formulario se envíe de forma tradicional

        // Captura los valores de los campos del formulario
        const name = document.getElementById("name").value;
        const email = document.getElementById("emailContact").value;
        const message = document.getElementById("message").value;

        // Crea un objeto con los datos del usuario
        const user = {
            name: name,
            email: email,
            message: message
        };

        // Enviar los datos al servidor
        fetch('http://localhost:3000/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(user)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Success:', data);
            alert('Usuario registrado con éxito!');
            // Reinicia el formulario para permitir un nuevo registro
            form.reset();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al registrar el usuario.');
        });
    });

    // Función para descargar el archivo JSON con los registros de usuarios (si aún quieres mantener esta funcionalidad local)
    function downloadUsersAsJSON() {
        // Convierte el array de usuarios a una cadena JSON
        const json = JSON.stringify(users, null, 2);

        // Crea un Blob a partir de la cadena JSON
        const blob = new Blob([json], { type: "application/json" });

        // Crea una URL para el Blob
        const url = URL.createObjectURL(blob);

        // Crea un enlace para iniciar la descarga
        const a = document.createElement("a");
        a.href = url;
        a.download = "users.json";
        document.body.appendChild(a);
        a.click(); // Simula un clic para iniciar la descarga

        // Limpia el DOM
        document.body.removeChild(a);

        // Libera la URL creada
        URL.revokeObjectURL(url);
    }

    // Agrega el método de descarga a la consola para su uso
    window.downloadUsersAsJSON = downloadUsersAsJSON;
});
