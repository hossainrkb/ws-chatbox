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

        .p-5 {
            padding: 50px
        }

        .float-right {
            /* float: right; */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="message-list p-5">

        </div>
        <div style="background-color: red;" class="float-right">
            <form onsubmit="sendMessage(event)">
                <div>
                    <input type="text" id="name" placeholder="Enter Your Name" />
                </div>
                <div>
                    <textarea id="message-box" required cols="30" rows="5" placeholder="Enter Message.."></textarea>
                </div>
                <div>
                    <input type="submit">
                </div>
            </form>
        </div>
    </div>
</body>
<script>
    const socket = new WebSocket('ws://localhost:8006');
    socket.addEventListener('open', function(event) {
        console.log('connection init');
    });

    socket.addEventListener('message', function(event) {
        let data = JSON.parse(event.data);
        console.log(data);
        let messageList = document.querySelector('.message-list');
        // messageList.innerHTML = '';
        let messageHtml = Object.keys(data).map(e => {
            return (
                `<div>
              <h5>${data[e]['from']}</h5>
                <p>${data[e]['message']}</p>
              </div>`
            )
        })

        messageList.innerHTML = messageHtml;
    });

    function sendMessage(e) {
        e.preventDefault();
        let messageBox = document.getElementById('message-box');
        let name = document.getElementById('name');
        let data = {
            'from_user': name.value,
            'message': messageBox.value
        }
        socket.send(JSON.stringify(data))
        messageBox.value = '';
    }

    socket.addEventListener('close', function(event) {
        console.log('The connection has been closed successfully.');
    });
</script>

</html>