<?php
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone_number = $_POST["phone_number"];
    $message = substr($_POST["message"], 0, 180);  // Limitar el mensaje a 180 caracteres
    
    if (empty($phone_number) || empty($message)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        $whatsapp_url = "https://api.whatsapp.com/send?phone={$phone_number}&text=" . urlencode($message);
        echo "<script>window.open('$whatsapp_url', '_blank');</script>";
        echo "<script>window.location.href = '$whatsapp_url';</script>";  // Redirigir al sitio de WhatsApp después de abrir en una nueva ventana
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enviar Mensaje de WhatsApp</title>
    <script>
        function openWhatsApp() {
            var phoneNumberInput = document.getElementById("phone_number");
            var messageInput = document.getElementById("message");
            
            if (phoneNumberInput.value.trim() === '' || messageInput.value.trim() === '') {
                alert("Por favor, completa todos los campos.");
                return;
            }
            
            messageInput.value = messageInput.value.substring(0, 180);  // Limitar el mensaje a 180 caracteres
            document.getElementById("whatsappForm").submit();
        }

        function updateCharacterCount() {
            var messageInput = document.getElementById("message");
            var count = messageInput.value.length;
            document.getElementById("characterCount").innerHTML = count + "/180";
        }
    </script>
</head>
<body>
    <form id="whatsappForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" target="_blank">
        <label>Número de Teléfono (10 dígitos):</label>
        <input type="text" name="phone_number" id="phone_number" required><br><br>

        <label>Mensaje:</label>
        <input type="text" name="message" id="message" maxlength="180" required oninput="updateCharacterCount()"><br>
        <span id="characterCount">0/180</span><br><br>

        <button type="button" onclick="openWhatsApp()">Enviar</button>
        <p><?php echo $error; ?></p>
    </form>
</body>
</html>
