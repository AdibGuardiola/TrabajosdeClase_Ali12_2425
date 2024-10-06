const express = require('express');
const bodyParser = require('body-parser');
const { User } = require('./db');
const path = require('path');

const app = express();
app.use(bodyParser.json());

// Configurar la carpeta pública para servir archivos estáticos, como imágenes y CSS desde la raíz
app.use(express.static(path.join(__dirname, '../')));  // Sirviendo archivos desde la carpeta raíz

// Servir la carpeta de camisetas para que las imágenes sean accesibles
app.use('/Camisetas', express.static(path.join(__dirname, '../Camisetas')));  // Sirviendo imágenes desde la carpeta Camisetas

// Ruta para servir el archivo HTML cuando visites '/'
app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, '../Proyecto_Ecomerce.html'));  // Subir un nivel desde js_clase para acceder a la raíz
});

// Ruta para registrar un nuevo usuario
app.post('/register', async (req, res) => {
    try {
        const { name, email, message } = req.body;
        const newUser = await User.create({ name, email, message });
        res.status(201).json(newUser);
    } catch (error) {
        res.status(400).json({ error: error.message });
    }
});

// Ruta para obtener todos los usuarios registrados y mostrar en formato legible
app.get('/users', async (req, res) => {
    const users = await User.findAll();
    
    // Mostrar los usuarios en formato JSON legible
    res.send(`<pre>${JSON.stringify(users, null, 2)}</pre>`);
});

// Iniciar el servidor
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
});
