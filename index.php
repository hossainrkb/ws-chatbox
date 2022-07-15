<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chat</title>
    <style>
        .container {
            margin: auto;
            width: 80%;
            background-color: lightblue;
            padding: 50px;
        }
    </style>
</head>

<body>
    <div class="container">Hi</div>
</body>
<script>
    const socket = new WebSocket('ws://localhost:8006');
    socket.addEventListener('open', function(event) {
        // socket.send('Hello Server!');
        socket.send('Hello Server from js!');
    });

    socket.addEventListener('message', function(event) {
        console.log('Message from server ', event.data);
    });

    socket.addEventListener('close', function(event) {
        console.log('The connection has been closed successfully.');
    });
</script>

</html>