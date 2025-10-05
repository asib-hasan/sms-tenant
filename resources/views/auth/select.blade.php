<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            height: 100%;
            overflow: hidden;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            background: #0d1117;
            z-index: -1;
        }

        .container-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 25px;
            padding: 60px 50px;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 900px;
            width: 90%;
        }

        .school-card {
            padding: 40px 20px;
            border-radius: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .school-card:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        }
        h2 {
            font-size: 2.2rem;
            font-weight: 700;
        }
        h3 {
            font-size: 1.8rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
<div id="particles-js"></div>

<div class="d-flex align-items-center justify-content-center h-100">
    <div class="container-box text-center">
        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <div class="card school-card">
                    <h3>School 1</h3>
                    <p class="text-muted">Click to enter School 1</p>
                    <a href="{{ url('/school1') }}" target="_blank" class="btn btn-primary btn-lg mt-3">Enter</a>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <div class="card school-card">
                    <h3>School 2</h3>
                    <p class="text-muted">Click to enter School 2</p>
                    <a href="{{ url('/school2') }}" target="_blank" class="btn btn-success btn-lg mt-3 fw">Enter</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
    particlesJS("particles-js", {
        "particles": {
            "number": { "value": 90, "density": { "enable": true, "value_area": 800 } },
            "color": { "value": "#00d1ff" },
            "shape": { "type": "circle" },
            "opacity": { "value": 0.6, "random": true },
            "size": { "value": 4, "random": true },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#00d1ff",
                "opacity": 0.4,
                "width": 1
            },
            "move": { "enable": true, "speed": 2 }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": { "enable": true, "mode": "grab" },
                "onclick": { "enable": true, "mode": "push" }
            },
            "modes": {
                "grab": { "distance": 200, "line_linked": { "opacity": 0.7 } },
                "push": { "particles_nb": 4 }
            }
        },
        "retina_detect": true
    });
</script>
</body>
</html>
