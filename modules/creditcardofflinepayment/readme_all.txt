Credit Card Offline Payment - Módulo para Prestashop 1.5 y 1.4
----------------------------------------------------------------

[ES] Descripción
Desarrollado por: idnovate (http://www.idnovate.com)
Versión: 1.34 - May 2, 2012
Este módulo permite a las tiendas aceptar el pago de compras mediante la tarjeta de crédito, sin necesidad de 
realizar el pago al instante. El usuario introduce la información de su tarjeta mediante un formulario. 
La información introducida se valida y una parte de la información se almacena en la base de datos mientras
que otra parte se envía por correo electrónico, de forma que el vendedor pueda realizar el cobro posteriormente
mediante un terminal de cobro u otro dispositivo.
Este módulo es el único de Prestashop que cumple con la normativa PCI DSS debido ya que no almacena la información de 
la tarjeta de crédito en la base de datos.

[EN] Description
Developed by: idnovate (http://www.idnovate.com)
Version: 1.34 - May 2, 2012
Description: This module allows stores to accept payment of purchases by credit or debit card without having 
to pay instantly. The user enters the card information through a form. The information entered is validated and 
stored, so that the seller can then make the payment through a payment terminal or other device afterwards.
This is the only Prestashop module that complies with PCI DSS because it does not store the information of 
the credit card in the database.



[ES] Registro de cambios
V1.34 - Bug solucionado.
V1.33 - Bug solucionado. Añadido Isracard
V1.31 - Compatible con PS 1.5 y 1.4
V1.3 - 2 modos de funcionamiento y más idiomas
V1.2 - Añadido más campos y compatibilidad para la versión móvil
V1.1 - Añadido un campo cuando el cliente inserta sus datos para que introduzca su código de identificación

[EN] Changelog
V1.34 - Bug fixed.
V1.33 - Bug fixed. Isracard added
V1.31 - Compatibility with PS 1.5 and 1.4
V1.3 - 2 working mode and more languages
V1.2 - More fields added and mobile theme compatibility
V1.1 - Added a field to let the customer to inform his identity card



[ES]Instrucciones de instalación:
1. Copia la carpeta creditcardofflinepayment a la carpeta Modules
2. Desde el BackOffice accede a Módulos - Pago
3. Instala el módulo

[EN]Installation
1. Copy creditcardpaymentoffline folder to the Modules folder
2. From the Backoffice, enter Modules - Payments and Gateways
3. Install the module



[ES]Opciones de configuración
- Introduce en el campo "Correo electrónico" la dirección de correo a la que le llegará el aviso de pago, con la parte 
necesaria para completar el número de tarjeta de crédito. Es imprescindible definir la dirección de correo electrónico
para que el módulo se muestre como opción de pago.
- Puedes definir en que estado quedarán las compras cuando el usuario realiza el pago.
- Puedes definir los campos que se solicitarán al usuario y que seran obligatorios (cvv, fecha de caducidad y tipo de tarjetas)
- Selecciona los tipos de tarjetas que el usuario podrá seleccionar para realizar el pago

[EN]Configuration
- Enter in the "Email" field the email address where you will be noticed of the payment, with the needed part to 
complete the credit card number. It is essential to define the email for the module to be displayed as a payment option.
- You can define which is the inital state for the sellings when the user makes the payment.
- You can define the fields to be requested to the user and taht will be required to fill (cvc, expiration date and card issuers)
- Select the card issuers that the user can select to make the payment