//Aqui se importaran las url que se ingresan en el archivo .env para comuinicarse con el back

export const login = async (user) => {
  try {
    const response = await fetch(
      "http://localhost/archivos/depStock/login.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: user.nombreUsuario, // Enviar el nombre de usuario ingresado
          password: user.contrasenia, // Enviar la contraseña ingresada
        }),
      }
    );

    // Si la respuesta no es OK (por ejemplo, código 404 o 500)
    if (!response.ok) {
      return { status: response.status, datos: null }; // Retorna el código de error
    }

    // Convertimos la respuesta a JSON
    const data = await response.json();

    // Validamos el contenido del JSON antes de proceder
    if (data.success) {
      return { status: 200, datos: data }; // Retorna los datos de éxito
    } else {
      return { status: 401, datos: null, message: data.message }; // Usuario o contraseña incorrectos
    }
  } catch (err) {
    return { status: 500, datos: null }; // Error del servidor
  }
};

/*
    try
    {
        console.log(user);
        if(user.nombreUsuario==='admin' && user.contrasenia==='admin')
        {
            return {
                status: 200,
                mensaje: 'Usuario encontrado',
                type: 'user',
                datos: user,
                uid: 1
            }
        }else
        {
            return 400; //Error de usuario no encontrado
        }
    }catch(error)
    {
        console.log('A ocurrido un error: '+error);
        return null;
    }*/
// };
