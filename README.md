# Proyecto de Gestión de Cuentas Bancarias

Este proyecto es un sistema de simulación para la gestión de cuentas bancarias, desarrollado en PHP con MySQL y Bootstrap. Permite realizar operaciones bancarias básicas como consignar, retirar, transferir y visualizar los movimientos de una cuenta, todo dentro de una interfaz moderna y funcional.

## Características

- **Consignaciones**: Permite al usuario realizar depósitos a una cuenta bancaria.
- **Retiros**: Permite realizar retiros de una cuenta.
- **Transferencias**: Facilita la transferencia de fondos entre cuentas.
- **Movimientos de cuenta**: Permite al usuario ver un historial de transacciones realizadas.

Cabe aclarar que el registro del usuario se crea en la base de datos, pero es el administrador quien crea la cuenta bancaria, relaciona la cuenta con el usuario y asigna el número de cuenta, el monto o saldo correspondiente.

## Estructura del Proyecto

- **database/**: Contiene los archivos relacionados con la base de datos, como esquemas y scripts de migración.
- **funciones/**: Incluye funciones PHP que manejan la lógica principal del sistema.
- **img/**: Almacena imágenes utilizadas en la aplicación (iconos, logos, etc.).
- **index.php**: Archivo principal que sirve como punto de entrada de la aplicación.
- **views/**: Carpeta donde se encuentran las vistas de la aplicación.

## Requisitos

- **PHP** 7.x o superior
- **MySQL** 5.x o superior
- **Bootstrap** (para la interfaz)
- Servidor local como XAMPP o LAMP

## Instalación

1. Clona este repositorio en tu servidor local:
   ```bash
   git clone https://github.com/EsnaiderG/cuentaBanco.git
   ```
2. Configura la base de datos:
   - Crea una base de datos llamada `diplo2`.
   - Importa el archivo SQL que se encuentra en la carpeta `database` para crear las tablas necesarias.
3. Configura el acceso a la base de datos en el archivo `funciones/conexion.php`.
4. Asegúrate de tener configurado un servidor PHP y MySQL (puedes usar XAMPP, LAMP, etc.).
5. Accede al sistema desde tu navegador a través de `http://localhost/cuentaBanco`.

## Uso

1. Navega al sistema e inicia sesión con tus credenciales.
2. El administrador puede gestionar las cuentas bancarias, asignando números de cuenta y montos a los usuarios registrados.
3. Los usuarios pueden gestionar sus cuentas, realizando depósitos, retiros y transferencias, así como visualizando un historial de transacciones.

## Licencia

Este proyecto está bajo la Licencia MIT.