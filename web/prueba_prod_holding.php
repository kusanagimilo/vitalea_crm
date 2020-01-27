<?PHP
//require_once '../include/script.php';
require_once '../include/script.php';
require_once '../include/header_administrador.php';
?>
<script>

    function PruebaCliente() {

        $.ajax({
            type: 'POST',
            async: false,
            headers: {
                'Authorization': 'Bearer 20759f2e13e83281b23382d37b41888ee07126b0',
                'Content-Type': 'application/json'},
            url: "https://vitalea.co/api/users/create_user",
            data: JSON.stringify({
                "users": [
                    {
                        "email": "useremailexample2@gmail.com",
                        "name": "user example name",
                        "last_name": "user example last name",
                        "client_id": "987465",
                        "document": "77665544",
                        "document_type_id": "1",
                        "phone1": "3101234568796",
                        "phone2": "3101234568796",
                        "birth_date": "1970-03-15",
                        "district": "chapinero",
                        "address": "Carrera 15 # 81-30",
                        "civil_status_id": "2",
                        "gender_id": "1",
                        "department_id": "3",
                        "city_id": "149"
                    }
                ]
            }),
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            	alert(xhr.responseText);
            },
            success: function (retu) {
                console.log(retu);
            	alert(retu);
            }
        });
    }

</script>    
<input type="button" onclick="PruebaCliente()" value="probar">

<?php
echo "Tu dirección IP es: {$_SERVER['REMOTE_ADDR']}";
?>
