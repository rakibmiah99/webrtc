<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio/Video Call & Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">
<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- Sidebar for Contact List -->
        <div class="col-3 bg-white border-end p-3">
            <h4 class="fw-bold">Contacts</h4>
            <ul class="list-group mt-4">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>User 1</span>
                    <div class="btn-group">
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Audio Call">
                            🎤
                        </button>
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Video Call">
                            🎥
                        </button>
                    </div>
                </li>
                <!-- Repeat for other users -->
            </ul>
        </div>

        <!-- Main Content Area -->
        <div class="col-9 d-flex flex-column">
            <!-- Call Area -->
            <div class="flex-grow-1 bg-secondary d-flex justify-content-center align-items-center">
                <div class="position-relative w-75 h-75 bg-dark rounded overflow-hidden">
                    <video class="w-100 h-100" autoplay></video>
                    <div class="position-absolute bottom-3 end-3">
                        <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="End Call">
                            ❌ End Call
                        </button>
                        <button class="btn btn-dark btn-sm" data-bs-toggle="tooltip" title="Mute Audio">
                            🔇 Mute
                        </button>
                    </div>
                </div>
            </div>

            <!-- Message Area -->
            <div class="bg-white p-3 border-top">
                <div class="overflow-auto" style="height: 200px;">
                    <!-- Chat History -->
                    <div class="mb-2">
                        <span class="badge bg-secondary">Hello!</span>
                    </div>
                    <div class="d-flex justify-content-end mb-2">
                        <span class="badge bg-primary text-end">Hi there!</span>
                    </div>
                    <!-- Repeat for more messages -->
                </div>
                <!-- Message Input -->
                <div class="input-group mt-3">
                    <input type="text" class="form-control" placeholder="Type your message...">
                    <button class="btn btn-primary">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
