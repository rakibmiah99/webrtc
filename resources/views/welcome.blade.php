<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/peerjs@1.5.4/dist/peerjs.min.js"></script>
        <style>
            .content-area{
                height: 100vh;
            }
            .content{
                width: 750px;
                border: 1px solid purple;
                padding: 20px
            }
        </style>
    </head>
    <body>

            <div  class="content-area d-flex justify-content-center align-items-center">
                <div class="content">
                    <h6 id="my-pear-id-btn" class="mb-3 btn  btn-light"><b>Your ID:</b> <span id="peer_id">dd</span></h6>

                    <input placeholder="enter another peer id" type="text" id="text" class="form-control">
                    <br>
                    <div class="mt-3 d-flex align-items-center">
                        <button id="connect-btn" class="btn btn-primary me-2">Connect</button>
                        <button id="send-data-btn" class="btn d-none btn-primary me-2  text-white">Send Data</button>
                        <button id="call-btn" class="btn btn-primary d-none  text-white">Call</button>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <video id="my-video" class="border" style="height: 300px; width: 300px"></video>
                        <div class="border" style="height: 300px;"></div>
                        <video id="remote-video" class="border" style="height: 300px; width: 300px"></video>
                    </div>

                </div>
            </div>

        <script>
            var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
                cluster: "{{env('PUSHER_APP_CLUSTER')}}",
                appId: "{{env('PUSHER_APP_ID')}}",
                secret: "{{env('PUSHER_APP_SECRET')}}",
                encrypted: true
            });



            let chanel = pusher.subscribe('web-rtc-chanel')
            chanel.bind('make-call', (data) => {
                console.log('data', data)
            })





            $(document).ready(async function(){
                var peer = new Peer({
                    config: {
                        iceServers: [
                            { urls: 'stun:stun.l.google.com:19302' },  // Public Google STUN server
                            {
                                urls: 'turn:relay1.expressturn.com:3478',
                                username: 'efLA7R35EUSZO917QZ',
                                credential: 'ovU0YbgXiub77Pa5'
                            }
                        ]
                    },
                    debug: 0
                });

                // Listen for connections from other peers
                peer.on('connection', function(conn) {
                    console.log('Connected to peer: ' + conn.peer);

                    // Listen for incoming data
                    conn.on('data', function(data) {
                        // Display the received message
                        // document.getElementById('receivedMessage').innerHTML = 'Received: ' + data;
                        console.log('Received message: ' + data);
                    });
                });



                function getPearId(){
                    return new Promise((resolve, reject) => {
                        peer.on('open', function (id){
                            resolve(id)
                        })
                    })
                }


                let connect_btn = document.getElementById('connect-btn');
                let call_btn = document.getElementById('call-btn');
                let peer_id_el = document.getElementById('peer_id');
                let my_video = document.getElementById('my-video');
                let remote_video = document.getElementById('remote-video');



                let peer_id = await getPearId();
                peer_id_el.innerText = peer_id;


                let conn = null;
                document.getElementById('connect-btn').addEventListener('click', function (){
                    let destination_peer_id = $('input').val();


                    console.log(destination_peer_id)
                    conn = peer.connect(destination_peer_id);

                    conn.on('open', function() {
                        connect_btn.classList.add('disabled')
                        connect_btn.innerText = "Connected";
                        call_btn.classList.remove('d-none')
                        // Send messages
                        conn.send('connected!');

                    });

                    // Handle connection errors
                    conn.on('error', function(err) {
                        console.error('Connection error:', err);
                    });

                    /*axios.post('{{route('make-call')}}', {
                        peer_id: peer_id
                    })*/
                })

                /*document.getElementById('send-data-btn').addEventListener('click', function (){
                    conn.send("hello")
                })*/



                //make call
                call_btn.addEventListener('click', function (){
                    let destination_peer_id = document.querySelector('input')
                    navigator.mediaDevices.getUserMedia({
                        audio: true,
                        video: true
                    }).then(function (stream){
                        my_video.srcObject = stream
                        my_video.onloadedmetadata = function (e){
                            my_video.play()
                        }

                        var call = peer.call(destination_peer_id, stream)
                    })

                })


                // Answer the call
                peer.on('call', function(call) {
                    navigator.mediaDevices.getUserMedia({
                        audio: true,
                        video: true
                    }).then(function (stream) {
                        my_video.srcObject = stream

                        my_video.onloadedmetadata = function (e) {
                            my_video.play()
                        }

                        // Answer the call, providing our mediaStream
                        call.answer(stream);

                        //Get and show remote stream
                        call.on('stream', (remoteStream) => {
                            remote_video.srcObject = remoteStream;
                            remote_video.play();
                        })
                    });
                });



                document.getElementById('my-pear-id-btn').addEventListener('click', function (){
                    // Copy the text inside the text field
                    navigator.clipboard.writeText(peer_id);

                    // Alert the copied text
                    alert("Copied the text: " + peer_id);
                })

            });














        </script>
    </body>
</html>
