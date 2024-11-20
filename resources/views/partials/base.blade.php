<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Document')</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: orange;
            color: white;
            text-align: center;
            padding: 10px 20px;
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .head-container{
            display: flex;
        }

        .upload-form {
            display: flex;
            margin-left: auto;
            margin-right: 20px;
            margin-bottom: 20px;
            width: 30%;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            border: 2px solid #0066cc;
            padding: 10px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #0066cc;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0052a3;
        }

        .auth-section {
            padding-right: 50px;
        }

        aside {
        width: 200px;
        position: fixed;
        left: 0;
        top: 60px;
        bottom: 0;
        background: #f4f4f4; /* Fondo general del sidebar */
        padding: 20px;
    }

    aside ul {
        list-style: none;
        padding: 0;
    }

    aside ul li {
        margin-bottom: 10px;
    }

    aside ul li a {
        color: #333; /* Color normal del enlace */
        text-decoration: none;
        display: block;
        padding: 10px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    aside ul li a:hover {
        background-color: #8795a2; /* Color de fondo al pasar el ratón */
        color: white; /* Cambia el color del texto al pasar el ratón */
    }
    aside ul li.active a {
        background-color: #0066cc; /* Fondo del enlace activo */
        color: white; /* Color del texto para el enlace activo */
    }
    .tags-menu {
            margin-top: 20px;
            height: 150px; /* Limitar la altura del menú de etiquetas */
            overflow-y: auto; /* Agregar barra de scroll solo en el menú de etiquetas */
            border: 1px solid #ccc;
            padding: 10px;
            background: #ffffff;
        }

        .tags-menu ul {
            list-style: none;
            padding: 0;
        }

        .tags-menu ul li {
            margin: 5px 0;
        }

        .tags-menu ul li a {
            text-decoration: none;
            color: #0066cc;
        }

        .tags-menu ul li a:hover {
            text-decoration: underline;
        }

        .add-tag {
            margin-top: 15px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .add-tag input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .add-tag button {
            padding: 10px;
            border: none;
            background-color: #0066cc;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .add-tag button:hover {
            background-color: #0052a3;
        }


        main {
            margin-left: 220px;
            padding: 20px;
            padding-top: 80px;
        }

        input[type="search"],
        input[type="submit"] {
            padding: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            border-top: 1px solid #ccc;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #e8f4f8;
        }

        tr:has(input:checked) {
        background: rgb(142, 186, 228);
    }
    </style>
</head>

<body>
    @include('partials.header')
    <main>
        @yield('content')
    </main>
    @if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif
</body>

</html>
