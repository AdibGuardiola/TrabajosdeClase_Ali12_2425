# Usar una imagen base de Node.js
FROM node:16

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /app

# Copiar el archivo package.json y package-lock.json para instalar dependencias
COPY js_clase/package*.json ./

# Instalar las dependencias del proyecto
RUN npm install

# Copiar todos los archivos desde la carpeta js_clase, incluyendo server.js
COPY js_clase /app/js_clase

# Copiar otros archivos HTML, CSS, e imágenes
COPY Proyecto_Ecomerce.html /app/
COPY Basica.css /app/
COPY carrito.png /app/carrito.png
COPY Formulario.css /app/Formulario.css
COPY Diseño.css /app/Diseño.css
COPY logo.jpg /app/logo.jpg
COPY usuario.png /app/usuario.png

# Exponer el puerto 3000
EXPOSE 3000

# Comando para iniciar el servidor
CMD ["node", "js_clase/server.js"]
