// Importa el módulo HTTP de Node.js
const http = require('http');

// Define el puerto en el que el servidor estará escuchando
const PORT = 3000;

// Crea el servidor HTTP
const server = http.createServer((req, res) => {
    // Establece el código de estado HTTP en 200 OK
    res.statusCode = 200;

    // Establece el tipo de contenido de la respuesta como texto plano
    res.setHeader('Content-Type', 'text/plain');

    // Envía la respuesta con el mensaje "Hola Mundo"
    res.end('Hola Mundo');
});

// El servidor comienza a escuchar conexiones en el puerto especificado
server.listen(PORT, () => {
    console.log(`Servidor escuchando en el puerto ${PORT}`);
});
