<?php require_once './header_inicio.php'; ?>

<script>
    function prueba() {


        $.ajax({
            type: 'POST',
            headers: {
                'Authorization': 'Bearer cdb0891d7bb32241235b31420bb0847a44d07a49',
                'Content-Type': 'application/json'},
            url: "https://vitalea-dev.herokuapp.com/api/users/create_user",
            data: JSON.stringify({
                "users": [
                    {
                        "email": "nuevoejemploj@4nn.com",
                        "name": "aaaa",
                        "last_name": "bbb",
                        "client_id": "800",
                        "document": "61235954",
                        "document_type_id": "1",
                        "phone1": "123456789",
                        "phone2": "123456789",
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
                alert(xhr.responseText);
                $("#result").html(xhr.responseText);
            }
        });


        /*var hola = {
         "users": [
         {
         "email": "useremailexample@gmail.com",
         "name": "user example name",
         "last_name": "user example last name",
         "client_id": "1100",
         "document": "54214214",
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
         };*/

        //var myJSON = JSON.stringify(hola);


        // return false;

        /*
         $.ajax({
         type: 'POST',
         headers: {
         'Authorization': 'Bearer cdb0891d7bb32241235b31420bb0847a44d07a49',
         'Content-type': 'application/json'},
         url: "https://vitalea-dev.herokuapp.com/api/users/create_user",
         dataType: 'json',
         data: JSON.stringify({
         users:
         {
         email: "nuevoyy@4nn.com",
         name: "aaaa",
         last_name: "bbb",
         client_id: "5000",
         document: "4575154",
         document_type_id: "1",
         phone1: "123456789",
         phone2: "123456789",
         birth_date: "1970-03-15",
         district: "chapinero",
         address: "Carrera 15 # 81-30",
         civil_status_id: "2",
         gender_id: "1",
         department_id: "3",
         city_id: "149"
         }
         
         }),
         success: function (retu) {
         console.log(retu);
         }
         });*/
    }
</script>
<input type="button" value="prueba" onclick="prueba()">
